<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PTKController extends Controller
{
    /**
     * Display a listing of PTK
     */
    public function index(Request $request)
    {
        $query = PTK::with('user');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status kepegawaian
        if ($request->filled('status_kepegawaian')) {
            $query->byStatusKepegawaian($request->status_kepegawaian);
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->byJenisKelamin($request->jenis_kelamin);
        }

        $ptkList = $query->latest()->paginate(10);

        return view('admin.ptk.index', compact('ptkList'));
    }

    /**
     * Show the form for creating a new PTK
     */
    public function create()
    {
        return view('admin.ptk.create');
    }

    /**
     * Store a newly created PTK
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:guru,staf_tu,kepala_sekolah',
            'nip' => 'required|unique:ptk,nip',
            'nama_lengkap' => 'required|string|max:255',
            'nuptk' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'status_kepegawaian' => 'required|in:PNS,PPPK,GTT,PTT,Honorer',
            'jabatan' => 'required|string',
            'pangkat_golongan' => 'nullable|string',
            'tmt_pengangkatan' => 'nullable|date',
            'pendidikan_terakhir' => 'required|string',
            'jurusan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('ptk/photos', 'public');
        }

        // Create PTK
        $ptk = PTK::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'nuptk' => $validated['nuptk'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'email' => $validated['email'],
            'status_kepegawaian' => $validated['status_kepegawaian'],
            'jabatan' => $validated['jabatan'],
            'pangkat_golongan' => $validated['pangkat_golongan'] ?? null,
            'tmt_pengangkatan' => $validated['tmt_pengangkatan'] ?? null,
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
            'jurusan' => $validated['jurusan'] ?? null,
            'foto' => $fotoPath,
        ]);

        // Log activity
        ActivityLog::log('create', 'Membuat data PTK baru: ' . $ptk->nama_lengkap, 'PTK', $ptk->id);

        return redirect()->route('admin.ptk.index')->with('success', 'Data PTK berhasil ditambahkan.');
    }

    /**
     * Display the specified PTK
     */
    public function show(PTK $ptk)
    {
        $ptk->load(['user', 'documents.category']);
        return view('admin.ptk.show', compact('ptk'));
    }

    /**
     * Show the form for editing the specified PTK
     */
    public function edit(PTK $ptk)
    {
        $ptk->load('user');
        return view('admin.ptk.edit', compact('ptk'));
    }

    /**
     * Update the specified PTK
     */
    public function update(Request $request, PTK $ptk)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $ptk->user_id,
            'role' => 'required|in:guru,staf_tu,kepala_sekolah',
            'nip' => 'required|unique:ptk,nip,' . $ptk->id,
            'nama_lengkap' => 'required|string|max:255',
            'nuptk' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'status_kepegawaian' => 'required|in:PNS,PPPK,GTT,PTT,Honorer',
            'jabatan' => 'required|string',
            'pangkat_golongan' => 'nullable|string',
            'tmt_pengangkatan' => 'nullable|date',
            'pendidikan_terakhir' => 'required|string',
            'jurusan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Update user
        $ptk->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($ptk->foto) {
                Storage::disk('public')->delete($ptk->foto);
            }
            $validated['foto'] = $request->file('foto')->store('ptk/photos', 'public');
        }

        // Update PTK
        $ptk->update($validated);

        // Log activity
        ActivityLog::log('update', 'Mengupdate data PTK: ' . $ptk->nama_lengkap, 'PTK', $ptk->id);

        return redirect()->route('admin.ptk.index')->with('success', 'Data PTK berhasil diupdate.');
    }

    /**
     * Remove the specified PTK
     */
    public function destroy(PTK $ptk)
    {
        $nama = $ptk->nama_lengkap;

        // Delete photo if exists
        if ($ptk->foto) {
            Storage::disk('public')->delete($ptk->foto);
        }

        // Log activity before delete
        ActivityLog::log('delete', 'Menghapus data PTK: ' . $nama, 'PTK', $ptk->id);

        // Delete PTK (will cascade delete user due to FK)
        $user = $ptk->user;
        $ptk->delete();
        $user->delete();

        return redirect()->route('admin.ptk.index')->with('success', 'Data PTK berhasil dihapus.');
    }
}
