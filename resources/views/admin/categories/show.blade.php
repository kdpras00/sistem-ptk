@extends('layouts.app')

@section('title', 'Detail Kategori Dokumen')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <a href="{{ route('admin.categories.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Kategori Dokumen</h1>
                <p class="text-gray-600">Informasi lengkap kategori {{ $category->nama_kategori }}</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.edit', $category) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Kategori
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Category Info Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $category->nama_kategori }}</h2>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Kode Kategori</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $category->kode_kategori }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Total Dokumen</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $category->documents->count() }} dokumen</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Dibuat</p>
                    <p class="text-gray-900">{{ $category->created_at->format('d F Y') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Terakhir Update</p>
                    <p class="text-gray-900">{{ $category->updated_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Deskripsi Kategori</h3>
            </div>
            <div class="p-6">
                @if($category->deskripsi)
                    <p class="text-gray-700">{{ $category->deskripsi }}</p>
                @else
                    <p class="text-gray-500 italic">Tidak ada deskripsi</p>
                @endif
            </div>
        </div>

        <!-- Documents List -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Dokumen dalam Kategori Ini</h3>
            </div>
            <div class="p-6">
                @if($category->documents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nomor Dokumen</th>
                                    <th scope="col" class="px-4 py-3">Nama Dokumen</th>
                                    <th scope="col" class="px-4 py-3">PTK</th>
                                    <th scope="col" class="px-4 py-3">Tanggal</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->documents as $document)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $document->nomor_dokumen }}</td>
                                        <td class="px-4 py-3">{{ $document->nama_dokumen }}</td>
                                        <td class="px-4 py-3">{{ $document->ptk->nama_lengkap }}</td>
                                        <td class="px-4 py-3">{{ $document->tanggal_dokumen?->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $document->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Belum ada dokumen dalam kategori ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

