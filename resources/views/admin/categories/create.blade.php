@extends('layouts.app')

@section('title', 'Tambah Kategori Dokumen')

@section('content')
<div class="mb-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.categories.index') }}" class="mr-4 text-white hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">Tambah Kategori Dokumen</h1>
            <p class="text-white">Buat kategori baru untuk pengarsipan dokumen</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
        @csrf

        <div class="space-y-6">
            <!-- Kode Kategori -->
            <div>
                <label for="kode_kategori" class="block mb-2 text-sm font-medium text-gray-900">
                    Kode Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kode_kategori" id="kode_kategori" value="{{ old('kode_kategori') }}" 
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('kode_kategori') border-red-500 @enderror" 
                       placeholder="contoh: SK-001, IJZ-001, SRT-001" required>
                <p class="mt-1 text-sm text-gray-500">Kode unik untuk kategori (huruf besar tanpa spasi)</p>
                @error('kode_kategori')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Kategori -->
            <div>
                <label for="nama_kategori" class="block mb-2 text-sm font-medium text-gray-900">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" 
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nama_kategori') border-red-500 @enderror" 
                       placeholder="contoh: SK pengangkatan, ijazah" required>
                @error('nama_kategori')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">
                    Deskripsi
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('deskripsi') border-red-500 @enderror" 
                          placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="ml-2 text-sm text-gray-900">
                        Kategori Aktif
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">Kategori yang tidak aktif tidak akan muncul dalam pilihan</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-200">
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection

