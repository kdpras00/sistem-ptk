@extends('layouts.app')

@section('title', 'Edit Data PTK')

@section('content')
<div class="mb-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.ptk.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Data PTK</h1>
            <p class="text-gray-600">Update informasi PTK {{ $ptk->nama_lengkap }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="{{ route('admin.ptk.update', $ptk) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <!-- User Account Section -->
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Akun</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Pengguna <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $ptk->user->name) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $ptk->user->email) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror" 
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="role" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('role') border-red-500 @enderror" 
                            required>
                        <option value="">Pilih Role</option>
                        <option value="guru" {{ old('role', $ptk->user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="staf_tu" {{ old('role', $ptk->user->role) == 'staf_tu' ? 'selected' : '' }}>Staf TU</option>
                        <option value="kepala_sekolah" {{ old('role', $ptk->user->role) == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <p class="text-sm text-gray-500 italic">Kosongkan jika tidak ingin mengubah password</p>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP <span class="text-red-500">*</span></label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $ptk->nip) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nip') border-red-500 @enderror" 
                           required>
                    @error('nip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nuptk" class="block mb-2 text-sm font-medium text-gray-900">NUPTK</label>
                    <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk', $ptk->nuptk) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nuptk') border-red-500 @enderror">
                    @error('nuptk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $ptk->nama_lengkap) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nama_lengkap') border-red-500 @enderror" 
                           required>
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('jenis_kelamin') border-red-500 @enderror" 
                            required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $ptk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $ptk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tempat_lahir" class="block mb-2 text-sm font-medium text-gray-900">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $ptk->tempat_lahir) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tempat_lahir') border-red-500 @enderror" 
                           required>
                    @error('tempat_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $ptk->tanggal_lahir?->format('Y-m-d')) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tanggal_lahir') border-red-500 @enderror" 
                           required>
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_telepon" class="block mb-2 text-sm font-medium text-gray-900">No. Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $ptk->no_telepon) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('no_telepon') border-red-500 @enderror">
                    @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" id="alamat" rows="3" 
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('alamat') border-red-500 @enderror" 
                              required>{{ old('alamat', $ptk->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto" class="block mb-2 text-sm font-medium text-gray-900">Foto</label>
                    @if($ptk->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $ptk->foto) }}" alt="Foto PTK" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            <p class="mt-1 text-sm text-gray-500">Foto saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto" accept="image/*" 
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('foto') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG (MAX. 2MB) - Kosongkan jika tidak ingin mengubah</p>
                    @error('foto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kepegawaian</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status_kepegawaian" class="block mb-2 text-sm font-medium text-gray-900">Status Kepegawaian <span class="text-red-500">*</span></label>
                    <select name="status_kepegawaian" id="status_kepegawaian" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('status_kepegawaian') border-red-500 @enderror" 
                            required>
                        <option value="">Pilih Status</option>
                        <option value="PNS" {{ old('status_kepegawaian', $ptk->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ old('status_kepegawaian', $ptk->status_kepegawaian) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="GTT" {{ old('status_kepegawaian', $ptk->status_kepegawaian) == 'GTT' ? 'selected' : '' }}>GTT</option>
                        <option value="PTT" {{ old('status_kepegawaian', $ptk->status_kepegawaian) == 'PTT' ? 'selected' : '' }}>PTT</option>
                        <option value="Honorer" {{ old('status_kepegawaian', $ptk->status_kepegawaian) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    </select>
                    @error('status_kepegawaian')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $ptk->jabatan) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('jabatan') border-red-500 @enderror" 
                           required>
                    @error('jabatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pangkat_golongan" class="block mb-2 text-sm font-medium text-gray-900">Pangkat/Golongan</label>
                    <input type="text" name="pangkat_golongan" id="pangkat_golongan" value="{{ old('pangkat_golongan', $ptk->pangkat_golongan) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('pangkat_golongan') border-red-500 @enderror">
                    @error('pangkat_golongan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tmt_pengangkatan" class="block mb-2 text-sm font-medium text-gray-900">TMT Pengangkatan</label>
                    <input type="date" name="tmt_pengangkatan" id="tmt_pengangkatan" value="{{ old('tmt_pengangkatan', $ptk->tmt_pengangkatan?->format('Y-m-d')) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tmt_pengangkatan') border-red-500 @enderror">
                    @error('tmt_pengangkatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Education Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pendidikan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pendidikan_terakhir" class="block mb-2 text-sm font-medium text-gray-900">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                    <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $ptk->pendidikan_terakhir) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('pendidikan_terakhir') border-red-500 @enderror" 
                           required>
                    @error('pendidikan_terakhir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-900">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $ptk->jurusan) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('jurusan') border-red-500 @enderror">
                    @error('jurusan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.ptk.index') }}" 
               class="px-6 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Update Data PTK
            </button>
        </div>
    </form>
</div>
@endsection

