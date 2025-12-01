<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::withCount('documents')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:categories,kode_kategori',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category = Category::create($validated);

        // Log activity
        ActivityLog::log('create', 'Membuat kategori baru: ' . $category->nama_kategori, 'Category', $category->id);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $category->load('documents.ptk');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:categories,kode_kategori,' . $category->id,
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        // Log activity
        ActivityLog::log('update', 'Mengupdate kategori: ' . $category->nama_kategori, 'Category', $category->id);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has documents
        if ($category->documents()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen.');
        }

        $nama = $category->nama_kategori;

        // Log activity
        ActivityLog::log('delete', 'Menghapus kategori: ' . $nama, 'Category', $category->id);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
