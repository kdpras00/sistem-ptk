<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PTK;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin Latansa',
            'email' => 'latansa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Staf TU
        $stafTU = User::create([
            'name' => 'Staf Tata Usaha',
            'email' => 'staftu@ptk.com',
            'password' => Hash::make('password'),
            'role' => 'staf_tu',
            'is_active' => true,
        ]);

        // Create Kepala Sekolah
        $kepsek = User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@ptk.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah',
            'is_active' => true,
        ]);

        // Create Guru 1
        $guru1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@ptk.com',
            'password' => Hash::make('password'),
            'role' => 'guru',   
            'is_active' => true,
        ]);

        // Create PTK for Guru 1
        PTK::create([
            'user_id' => $guru1->id,
            'nip' => '198501012010011001',
            'nama_lengkap' => 'Budi Santoso, S.Pd',
            'nuptk' => '1234567890123456',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1985-01-01',
            'tempat_lahir' => 'Jakarta',
            'alamat' => 'Jl. Pendidikan No. 123, Jakarta Selatan',
            'no_telepon' => '081234567890',
            'email' => 'budi@ptk.com',
            'status_kepegawaian' => 'PNS',
            'jabatan' => 'Guru Matematika',
            'pangkat_golongan' => 'III/c',
            'tmt_pengangkatan' => '2010-01-01',
            'pendidikan_terakhir' => 'S1',
            'jurusan' => 'Pendidikan Matematika',
        ]);

        // Create Guru 2
        $guru2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@ptk.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        // Create PTK for Guru 2
        PTK::create([
            'user_id' => $guru2->id,
            'nip' => '199001012015012001',
            'nama_lengkap' => 'Siti Nurhaliza, S.Pd',
            'nuptk' => '1234567890123457',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1990-01-01',
            'tempat_lahir' => 'Bandung',
            'alamat' => 'Jl. Pendidikan No. 456, Bandung',
            'no_telepon' => '081234567891',
            'email' => 'siti@ptk.com',
            'status_kepegawaian' => 'PNS',
            'jabatan' => 'Guru Bahasa Indonesia',
            'pangkat_golongan' => 'III/b',
            'tmt_pengangkatan' => '2015-01-01',
            'pendidikan_terakhir' => 'S1',
            'jurusan' => 'Pendidikan Bahasa Indonesia',
        ]);

        // Create Categories
        $categories = [
            [
                'nama_kategori' => 'SK Pengangkatan',
                'kode_kategori' => 'SK-001',
                'deskripsi' => 'Surat Keputusan Pengangkatan sebagai PNS/PPPK',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Ijazah',
                'kode_kategori' => 'IJZ-001',
                'deskripsi' => 'Ijazah Pendidikan Terakhir',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Sertifikat Pendidik',
                'kode_kategori' => 'SRT-001',
                'deskripsi' => 'Sertifikat Pendidik Profesional',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'SK Kenaikan Pangkat',
                'kode_kategori' => 'SK-002',
                'deskripsi' => 'Surat Keputusan Kenaikan Pangkat',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Surat Tugas',
                'kode_kategori' => 'ST-001',
                'deskripsi' => 'Surat Tugas Mengajar',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Kartu Identitas',
                'kode_kategori' => 'KI-001',
                'deskripsi' => 'KTP, Kartu Keluarga, NPWP',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Default Accounts:');
        $this->command->info('=====================================');
        $this->command->info('Admin:');
        $this->command->info('  Email: admin@ptk.com');
        $this->command->info('  Password: admin123');
        $this->command->info('');
        $this->command->info('Staf TU:');
        $this->command->info('  Email: staftu@ptk.com');
        $this->command->info('  Password: staftu123');
        $this->command->info('');
        $this->command->info('Kepala Sekolah:');
        $this->command->info('  Email: kepsek@ptk.com');
        $this->command->info('  Password: kepsek123');
        $this->command->info('');
        $this->command->info('Guru 1:');
        $this->command->info('  Email: budi@ptk.com');
        $this->command->info('  Password: guru123');
        $this->command->info('');
        $this->command->info('Guru 2:');
        $this->command->info('  Email: siti@ptk.com');
        $this->command->info('  Password: guru123');
        $this->command->info('=====================================');
    }
}
