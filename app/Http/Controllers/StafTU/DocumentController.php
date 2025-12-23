<?php

namespace App\Http\Controllers\StafTU;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\PTK;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents
     */
    public function index(Request $request)
    {
        $query = Document::with(['ptk', 'category', 'uploader']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        // Filter by PTK
        if ($request->filled('ptk_id')) {
            $query->byPTK($request->ptk_id);
        }

        $documents = $query->latest()->paginate(10);
        $categories = Category::active()->get();
        $ptkList = PTK::orderBy('nama_lengkap')->get();

        return view('staf-tu.documents.index', compact('documents', 'categories', 'ptkList'));
    }

    /**
     * Show the form for creating a new document
     */
    public function create()
    {
        $ptkList = PTK::orderBy('nama_lengkap')->get();
        $categories = Category::active()->get();

        return view('staf-tu.documents.create', compact('ptkList', 'categories'));
    }

    /**
     * Store a newly created document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ptk_id' => 'required|exists:ptk,id',
            'category_id' => 'required|exists:categories,id',
            'nomor_dokumen' => 'required|unique:documents,nomor_dokumen',
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_dokumen' => 'required|date',
            'file' => 'required|file|mimes:pdf,jpg,jpeg|max:10240', // 10MB max
        ]);

        // Handle file upload
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        // Create document
        $document = Document::create([
            'ptk_id' => $validated['ptk_id'],
            'category_id' => $validated['category_id'],
            'uploaded_by' => auth()->id(),
            'nomor_dokumen' => $validated['nomor_dokumen'],
            'nama_dokumen' => $validated['nama_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'tanggal_upload' => now(),
            'status' => 'aktif',
        ]);

        // Log activity
        ActivityLog::log('upload', 'Mengunggah dokumen: ' . $document->nama_dokumen, 'Document', $document->id);

        return redirect()->route('staf-tu.documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Display the specified document
     */
    public function show(Document $document)
    {
        $document->load(['ptk', 'category', 'uploader']);
        return view('staf-tu.documents.show', compact('document'));
    }

    /**
     * View document (public viewer for Guru and Kepala Sekolah)
     */
    public function view(Document $document)
    {
        $document->load(['ptk', 'category', 'uploader']);
        return view('staf-tu.documents.view', compact('document'));
    }

    /**
     * Show the form for editing the specified document
     */
    public function edit(Document $document)
    {
        $ptkList = PTK::orderBy('nama_lengkap')->get();
        $categories = Category::active()->get();

        return view('staf-tu.documents.edit', compact('document', 'ptkList', 'categories'));
    }

    /**
     * Update the specified document
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'ptk_id' => 'required|exists:ptk,id',
            'category_id' => 'required|exists:categories,id',
            'nomor_dokumen' => 'required|unique:documents,nomor_dokumen,' . $document->id,
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_dokumen' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg|max:10240',
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($document->file_path);

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $fileName;
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        // Log activity
        ActivityLog::log('update', 'Mengupdate dokumen: ' . $document->nama_dokumen, 'Document', $document->id);

        return redirect()->route('staf-tu.documents.index')->with('success', 'Dokumen berhasil diupdate.');
    }

    /**
     * Remove the specified document
     */
    public function destroy(Document $document)
    {
        $nama = $document->nama_dokumen;

        // Delete file
        Storage::disk('public')->delete($document->file_path);

        // Log activity
        ActivityLog::log('delete', 'Menghapus dokumen: ' . $nama, 'Document', $document->id);

        $document->delete();

        return redirect()->route('staf-tu.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        // Log activity
        ActivityLog::log('download', 'Mengunduh dokumen: ' . $document->nama_dokumen, 'Document', $document->id);

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /**
     * Print report
     */
    public function report(Request $request)
    {
        $query = Document::with(['ptk', 'category', 'uploader']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_dokumen', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_dokumen', '<=', $request->end_date);
        }

        $documents = $query->get();

        // Log activity
        ActivityLog::log('report', 'Mencetak laporan pengarsipan');

        return view('staf-tu.documents.report', compact('documents'));
    }
}
