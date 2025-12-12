<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ptk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama_lengkap');
            $table->string('nuptk')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->text('alamat');
            $table->string('no_telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'GTT', 'GTY', 'Honorer']);
            $table->enum('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Bendahara Sekolah', 'Wakasek Kurikulum', 'Wakasek Kesiswaan', 'Guru Mapel', 'Tenaga Kependidikan']);
            $table->enum('pangkat_golongan', ['III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e', 'GTY', 'GTT'])->nullable();
            $table->date('tmt_pengangkatan')->nullable();
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']);
            $table->string('jurusan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptk');
    }
};

