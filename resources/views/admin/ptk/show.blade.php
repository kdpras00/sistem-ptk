@extends('layouts.app')

@section('title', 'Detail Data PTK')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <a href="{{ route('admin.ptk.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Data PTK</h1>
                <p class="text-gray-600">Informasi lengkap {{ $ptk->nama_lengkap }}</p>
            </div>
        </div>
        <a href="{{ route('admin.ptk.edit', $ptk) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Data
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col items-center">
                @if($ptk->foto)
                    <img src="{{ asset('storage/' . $ptk->foto) }}" alt="Foto {{ $ptk->nama_lengkap }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-blue-600 mb-4">
                @else
                    <div class="w-32 h-32 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold mb-4">
                        {{ strtoupper(substr($ptk->nama_lengkap, 0, 1)) }}
                    </div>
                @endif
                <h2 class="text-xl font-bold text-gray-900 text-center">{{ $ptk->nama_lengkap }}</h2>
                <p class="text-gray-600 text-center">{{ $ptk->jabatan }}</p>
                <span class="mt-2 px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ $ptk->status_kepegawaian }}
                </span>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">{{ $ptk->email }}</span>
                </div>
                @if($ptk->no_telepon)
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-sm">{{ $ptk->no_telepon }}</span>
                    </div>
                @endif
                <div class="flex items-start text-gray-700">
                    <svg class="w-5 h-5 mr-3 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm">{{ $ptk->alamat }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md">
            <!-- Personal Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">NIP</p>
                        <p class="font-medium text-gray-900">{{ $ptk->nip }}</p>
                    </div>
                    @if($ptk->nuptk)
                        <div>
                            <p class="text-sm text-gray-500">NUPTK</p>
                            <p class="font-medium text-gray-900">{{ $ptk->nuptk }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium text-gray-900">{{ $ptk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-gray-900">{{ $ptk->tempat_lahir }}, {{ $ptk->tanggal_lahir?->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kepegawaian</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Status Kepegawaian</p>
                        <p class="font-medium text-gray-900">{{ $ptk->status_kepegawaian }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jabatan</p>
                        <p class="font-medium text-gray-900">{{ $ptk->jabatan }}</p>
                    </div>
                    @if($ptk->pangkat_golongan)
                        <div>
                            <p class="text-sm text-gray-500">Pangkat/Golongan</p>
                            <p class="font-medium text-gray-900">{{ $ptk->pangkat_golongan }}</p>
                        </div>
                    @endif
                    @if($ptk->tmt_pengangkatan)
                        <div>
                            <p class="text-sm text-gray-500">TMT Pengangkatan</p>
                            <p class="font-medium text-gray-900">{{ $ptk->tmt_pengangkatan?->format('d F Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Education Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendidikan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Pendidikan Terakhir</p>
                        <p class="font-medium text-gray-900">{{ $ptk->pendidikan_terakhir }}</p>
                    </div>
                    @if($ptk->jurusan)
                        <div>
                            <p class="text-sm text-gray-500">Jurusan</p>
                            <p class="font-medium text-gray-900">{{ $ptk->jurusan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Information -->
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Pengguna</p>
                        <p class="font-medium text-gray-900">{{ $ptk->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $ptk->user->role)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status Akun</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ptk->user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $ptk->user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documents Section -->
<div class="mt-6 bg-white rounded-lg shadow-md">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Dokumen Terkait</h3>
    </div>
    <div class="p-6">
        @if($ptk->documents->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nomor Dokumen</th>
                            <th scope="col" class="px-6 py-3">Nama Dokumen</th>
                            <th scope="col" class="px-6 py-3">Kategori</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ptk->documents as $document)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $document->nomor_dokumen }}</td>
                                <td class="px-6 py-4">{{ $document->nama_dokumen }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $document->category->nama_kategori ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $document->tanggal_dokumen?->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
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
                <p>Belum ada dokumen terkait</p>
            </div>
        @endif
    </div>
</div>
@endsection

