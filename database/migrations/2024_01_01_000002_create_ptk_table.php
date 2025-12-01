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
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'GTT', 'PTT', 'Honorer']);
            $table->string('jabatan');
            $table->string('pangkat_golongan')->nullable();
            $table->date('tmt_pengangkatan')->nullable();
            $table->string('pendidikan_terakhir');
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

