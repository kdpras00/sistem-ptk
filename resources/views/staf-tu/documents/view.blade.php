@extends('layouts.app')

@section('title', 'Detail Dokumen')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-white">Detail Dokumen</h1>
        <p class="text-white">Informasi lengkap dokumen</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ 
                auth()->user()->role == 'guru' ? route('guru.dashboard') : 
                (auth()->user()->role == 'kepala_sekolah' ? route('kepala-sekolah.dashboard') : 
                route('staf-tu.dashboard')) 
            }}" 
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
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

        <!-- File Preview Only - No Actions for Viewers -->
        <!-- <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
            <p class="text-sm text-blue-700">
                <strong>Info:</strong> Anda hanya dapat melihat dokumen ini. Hubungi Staf TU untuk mengunduh atau mengedit.
            </p>
        </div> -->
    </div>
</div>
@endsection

