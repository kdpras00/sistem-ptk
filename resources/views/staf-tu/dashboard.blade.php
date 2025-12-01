@extends('layouts.app')

@section('title', 'Dashboard Staf TU')

@section('content')
<div class="mb-4">
    <h1 class="text-3xl font-bold text-white">Dashboard Staf TU</h1>
    <p class="text-white">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Documents Uploaded by User -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                    <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Dokumen Saya</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_documents'] }}</p>
            </div>
        </div>
    </div>

    <!-- Documents This Month -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['documents_this_month'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total PTK -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total PTK</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_ptk'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Kategori Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('staf-tu.documents.create') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-gray-900">Upload Dokumen</p>
                <p class="text-sm text-gray-600">Tambah dokumen baru</p>
            </div>
        </a>
        <a href="{{ route('staf-tu.documents.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-gray-900">Kelola Dokumen</p>
                <p class="text-sm text-gray-600">Lihat & edit dokumen</p>
            </div>
        </a>
        <a href="{{ route('staf-tu.report') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
            <svg class="w-8 h-8 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 20h10a1 1 0 001-1v-5H4v5a1 1 0 001 1z"/>
                <path d="M18 7H2a2 2 0 00-2 2v6a2 2 0 002 2v-3a2 2 0 012-2h12a2 2 0 012 2v3a2 2 0 002-2V9a2 2 0 00-2-2z"/>
            </svg>
            <div>
                <p class="font-semibold text-gray-900">Cetak Laporan</p>
                <p class="text-sm text-gray-600">Generate laporan</p>
            </div>
        </a>
    </div>
</div>

<!-- Recent Documents -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Dokumen Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nomor Dokumen</th>
                    <th scope="col" class="px-6 py-3">Nama Dokumen</th>
                    <th scope="col" class="px-6 py-3">PTK</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Tanggal Upload</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentDocuments as $doc)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $doc->nomor_dokumen }}</td>
                        <td class="px-6 py-4">{{ $doc->nama_dokumen }}</td>
                        <td class="px-6 py-4">{{ $doc->ptk->nama_lengkap }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $doc->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $doc->tanggal_upload->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada dokumen</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

