@extends('layouts.app')

@section('title', 'Detail Dokumen')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Dokumen</h1>
        <p class="text-white">Informasi lengkap dokumen</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('staf-tu.documents.download', $document) }}" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download
        </a>
        <a href="{{ route('staf-tu.documents.edit', $document) }}" 
           class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        <a href="{{ route('staf-tu.documents.index') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Document Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Dokumen</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Dokumen</p>
                    <p class="font-semibold text-gray-900">{{ $document->nomor_dokumen }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Dokumen</p>
                    <p class="font-semibold text-gray-900">{{ $document->nama_dokumen }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori</p>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $document->category->nama_kategori }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $document->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($document->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Dokumen</p>
                    <p class="font-semibold text-gray-900">{{ $document->tanggal_dokumen->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Upload</p>
                    <p class="font-semibold text-gray-900">{{ $document->tanggal_upload->format('d F Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-gray-900">{{ $document->deskripsi ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- PTK Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Data PTK</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">NIP</p>
                    <p class="font-semibold text-gray-900">{{ $document->ptk->nip }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="font-semibold text-gray-900">{{ $document->ptk->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jabatan</p>
                    <p class="text-gray-900">{{ $document->ptk->jabatan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Kepegawaian</p>
                    <p class="text-gray-900">{{ $document->ptk->status_kepegawaian }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- File Information & Preview -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi File</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-center p-8 bg-gray-50 rounded-lg">
                    <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                    </svg>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">Nama File</p>
                    <p class="font-medium text-gray-900 break-all">{{ $document->file_name }}</p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tipe File</p>
                        <p class="font-semibold text-gray-900">{{ strtoupper($document->file_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Ukuran</p>
                        <p class="font-semibold text-gray-900">{{ $document->formatted_file_size }}</p>
                    </div>
                </div>

                @if(in_array($document->file_type, ['jpg', 'jpeg', 'png']))
                <div>
                    <p class="text-sm text-gray-500 mb-2">Preview</p>
                    <img src="{{ asset('storage/' . $document->file_path) }}" 
                         alt="{{ $document->nama_dokumen }}" 
                         class="w-full rounded-lg border border-gray-200">
                </div>
                @endif

                <div class="pt-4 border-t">
                    <p class="text-sm text-gray-500">Diupload Oleh</p>
                    <p class="font-semibold text-gray-900">{{ $document->uploader->name }}</p>
                    <p class="text-xs text-gray-500">{{ $document->uploader->email }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Aksi</h2>
            <div class="space-y-2">
                <a href="{{ route('staf-tu.documents.download', $document) }}" 
                   class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Dokumen
                </a>
                <a href="{{ route('staf-tu.documents.edit', $document) }}" 
                   class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Dokumen
                </a>
                <button onclick="confirmDelete()" 
                        class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Dokumen
                </button>
                <form id="delete-form" 
                      action="{{ route('staf-tu.documents.destroy', $document) }}" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Dokumen?',
        text: "Data dokumen akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endpush

