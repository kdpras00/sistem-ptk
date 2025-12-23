@extends('layouts.app')

@section('title', 'Upload Dokumen Baru')

@section('content')
<div class="mb-4">
    <h1 class="text-3xl font-bold text-white">Upload Dokumen Baru</h1>
    <p class="text-white">Tambahkan dokumen PTK baru ke sistem</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('staf-tu.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- PTK -->
            <div>
                <label for="ptk_id" class="block text-sm font-medium text-gray-700 mb-2">
                    PTK <span class="text-red-500">*</span>
                </label>
                <select id="ptk_id" name="ptk_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ptk_id') border-red-500 @enderror">
                    <option value="">Pilih PTK</option>
                    @foreach($ptkList as $ptk)
                        <option value="{{ $ptk->id }}" {{ old('ptk_id') == $ptk->id ? 'selected' : '' }}>
                            {{ $ptk->nip }} - {{ $ptk->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('ptk_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori Dokumen <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Dokumen -->
            <div>
                <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Dokumen <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nomor_dokumen" name="nomor_dokumen" value="{{ old('nomor_dokumen') }}" required
                       placeholder="Contoh: DOC-001/2024"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_dokumen') border-red-500 @enderror">
                @error('nomor_dokumen')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Dokumen -->
            <div>
                <label for="nama_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Dokumen <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" required
                       placeholder="Contoh: SK Pengangkatan PNS"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_dokumen') border-red-500 @enderror">
                @error('nama_dokumen')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Dokumen -->
            <div>
                <label for="tanggal_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Dokumen <span class="text-red-500">*</span>
                </label>
                <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_dokumen') border-red-500 @enderror">
                @error('tanggal_dokumen')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
                      placeholder="Deskripsi singkat dokumen (opsional)"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Upload -->
        <div class="mb-6">
            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                File Dokumen <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center justify-center w-full">
                <label for="file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                        <p class="text-xs text-gray-500">PDF, JPG, JPEG (MAX. 10MB)</p>
                    </div>
                    <input id="file" name="file" type="file" class="hidden" accept=".pdf,.jpg,.jpeg" required />
                </label>
            </div>
            <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
            @error('file')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-4 pt-6 border-t">
            <a href="{{ route('staf-tu.documents.index') }}" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Upload Dokumen
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    const fileSize = e.target.files[0]?.size;
    if (fileName) {
        const fileSizeKB = (fileSize / 1024).toFixed(2);
        const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
        const displaySize = fileSizeMB >= 1 ? fileSizeMB + ' MB' : fileSizeKB + ' KB';
        document.getElementById('file-name').textContent = `File dipilih: ${fileName} (${displaySize})`;
    }
});
</script>
@endpush

