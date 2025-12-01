@extends('layouts.app')

@section('title', 'Kelola Data PTK')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-white">Kelola Data PTK</h1>
        <p class="text-white">Manajemen data Pendidikan dan Tenaga Kependidikan</p>
    </div>
    <a href="{{ route('admin.ptk.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah PTK
    </a>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.ptk.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari NIP, Nama, NUPTK..." 
               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        
        <select name="status_kepegawaian" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Status</option>
            <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
            <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
            <option value="GTT" {{ request('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT</option>
            <option value="PTT" {{ request('status_kepegawaian') == 'PTT' ? 'selected' : '' }}>PTT</option>
            <option value="Honorer" {{ request('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
        </select>

        <select name="jenis_kelamin" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Jenis Kelamin</option>
            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status_kepegawaian', 'jenis_kelamin']))
                <a href="{{ route('admin.ptk.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- PTK Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">NIP</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Jabatan</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ptkList as $ptk)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $ptk->nip }}</td>
                        <td class="px-6 py-4">{{ $ptk->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $ptk->jabatan }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $ptk->status_kepegawaian }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $ptk->email }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.ptk.show', $ptk) }}" 
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" 
                                   title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.ptk.edit', $ptk) }}" 
                                   class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors" 
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button type="button" 
                                        onclick="confirmDelete({{ $ptk->id }}, '{{ $ptk->nama_lengkap }}')" 
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" 
                                        title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $ptk->id }}" action="{{ route('admin.ptk.destroy', $ptk) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Tidak ada data PTK
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($ptkList->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $ptkList->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Data PTK?',
        html: `Apakah Anda yakin ingin menghapus data PTK<br><br><strong>${name}</strong>?`,
        icon: 'warning',
        iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        width: 500,
        padding: '1.5rem',
        customClass: {
            popup: 'swal-wide'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush

@push('styles')
<style>
.swal-wide {
    border-radius: 1rem;
}
.swal2-icon.swal2-warning {
    border-color: #ef4444 !important;
    color: #ef4444 !important;
    margin-bottom: 2rem !important;
}
.swal2-icon.swal2-warning .swal2-icon-content {
    color: #ef4444 !important;
}
.swal2-title {
    font-size: 1.5rem !important;
    margin-bottom: 1rem !important;
    padding: 0 1rem !important;
}
.swal2-html-container {
    font-size: 1rem !important;
    line-height: 1.8 !important;
    margin: 1.5rem 0 !important;
    padding: 0 1rem !important;
}
.swal2-actions {
    margin-top: 2rem !important;
}
</style>
@endpush

