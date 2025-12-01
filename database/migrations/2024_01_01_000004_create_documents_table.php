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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ptk_id')->constrained('ptk')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict');
            $table->string('nomor_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type', 50);
            $table->integer('file_size'); // in bytes
            $table->date('tanggal_dokumen');
            $table->date('tanggal_upload');
            $table->enum('status', ['aktif', 'arsip', 'dihapus'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

