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
        // dd('Reached index');
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
        $newDocumentNumber = $this->generateDocumentNumber();

        return view('staf-tu.documents.create', compact('ptkList', 'categories', 'newDocumentNumber'));
    }

    /**
     * Generate automatic document number
     */
    private function generateDocumentNumber()
    {
        $year = date('Y');
        $prefix = "DOC-";
        $suffix = "/{$year}";

        $lastDocument = Document::where('nomor_dokumen', 'like', "{$prefix}%{$suffix}")
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastDocument) {
            $number = 1;
        } else {
            // Format: DOC-001/2024
            $parts = explode('/', $lastDocument->nomor_dokumen);
            $numberPart = explode('-', $parts[0]);
            $number = (int)end($numberPart) + 1;
        }

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT) . $suffix;
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

    /**
     * Generate document number based on category via AJAX
     */
    public function generateNumber(Request $request)
    {
        if (!$request->has('category_id')) {
            return response()->json(['number' => '']);
        }

        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json(['number' => '']);
        }

        $year = date('Y');
        // Use Category Code as prefix, e.g. SK-001/2024
        // If category code is just 'SK', we append '-'
        // If it already contains '-', we use it as is? 
        // Let's assume Category Code is just the prefix part like 'SK' or 'IJZ'.
        // So we append '-'.
        // But the previous auto-gen for categories made 'KTG-001'.
        // If the user sets 'SK', then we want 'SK-001/2024'.
        // If the user sets 'SK-001' as category code (unlikely if they followed instructions), handled too.
        
        $prefix = $category->kode_kategori . '-';
        $suffix = "/{$year}";

        // Find last document with this prefix and year suffix
        $lastDocument = Document::where('nomor_dokumen', 'like', "{$prefix}%{$suffix}")
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastDocument) {
            $number = 1;
        } else {
            // Format: PREFIX-001/2024
            // exploded[0] is PREFIX-001
            // exploded[0] parts by '-' -> last part is 001
            $parts = explode('/', $lastDocument->nomor_dokumen);
            $numberPart = explode('-', $parts[0]);
            $number = (int)end($numberPart) + 1;
        }

        $newNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT) . $suffix;

        return response()->json(['number' => $newNumber]);
    }
}
