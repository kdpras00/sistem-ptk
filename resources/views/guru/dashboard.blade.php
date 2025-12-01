@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="mb-4">
    <h1 class="text-3xl font-bold text-gray-900">Data Diri PTK</h1>
    <p class="text-gray-600">Informasi lengkap data diri Anda</p>
</div>

@if(isset($ptk))
<!-- Profile Card -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-32"></div>
    <div class="px-6 pb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start -mt-16">
            <!-- Photo -->
            <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center overflow-hidden">
                @if($ptk->foto)
                    <img src="{{ asset('storage/' . $ptk->foto) }}" alt="{{ $ptk->nama_lengkap }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                @endif
            </div>
            
            <!-- Basic Info -->
            <div class="md:ml-6 mt-4 md:mt-0 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-900">{{ $ptk->nama_lengkap }}</h2>
                <p class="text-gray-600">{{ $ptk->jabatan }}</p>
                <div class="flex flex-wrap gap-2 mt-2 justify-center md:justify-start">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                        {{ $ptk->status_kepegawaian }}
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                        {{ $ptk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Information -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Personal Data -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
            Data Pribadi
        </h3>
        <div class="space-y-3">
            <div>
                <label class="text-sm font-medium text-gray-500">NIP</label>
                <p class="text-gray-900">{{ $ptk->nip }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">NUPTK</label>
                <p class="text-gray-900">{{ $ptk->nuptk ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                <p class="text-gray-900">{{ $ptk->tempat_lahir }}, {{ $ptk->tanggal_lahir->format('d F Y') }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Alamat</label>
                <p class="text-gray-900">{{ $ptk->alamat }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                <p class="text-gray-900">{{ $ptk->no_telepon ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Email</label>
                <p class="text-gray-900">{{ $ptk->email }}</p>
            </div>
        </div>
    </div>

    <!-- Employment Data -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
            </svg>
            Data Kepegawaian
        </h3>
        <div class="space-y-3">
            <div>
                <label class="text-sm font-medium text-gray-500">Status Kepegawaian</label>
                <p class="text-gray-900">{{ $ptk->status_kepegawaian }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Jabatan</label>
                <p class="text-gray-900">{{ $ptk->jabatan }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Pangkat/Golongan</label>
                <p class="text-gray-900">{{ $ptk->pangkat_golongan ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">TMT Pengangkatan</label>
                <p class="text-gray-900">{{ $ptk->tmt_pengangkatan ? $ptk->tmt_pengangkatan->format('d F Y') : '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Pendidikan Terakhir</label>
                <p class="text-gray-900">{{ $ptk->pendidikan_terakhir }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Jurusan</label>
                <p class="text-gray-900">{{ $ptk->jurusan ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Documents -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
            <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
        </svg>
        Dokumen Terkait
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Dokumen</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Tanggal Dokumen</th>
                    <th scope="col" class="px-6 py-3">Ukuran</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ptk->documents as $doc)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $doc->nama_dokumen }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $doc->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $doc->tanggal_dokumen->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $doc->formatted_file_size }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('documents.view', $doc) }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                               target="_blank">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat
                            </a>
                        </td>
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

@else
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-700">
                Data PTK Anda belum tersedia dalam sistem. Silakan hubungi administrator.
            </p>
        </div>
    </div>
</div>
@endif
@endsection

