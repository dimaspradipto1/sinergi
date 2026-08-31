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
        Schema::create('dokumen_lulusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->string('jenis_dokumen');
            $table->string('nomor_dokumen');
            $table->date('tanggal_terbit');
            $table->string('file')->nullable();
            $table->enum('status_verifikasi', ['Terverifikasi', 'Menunggu Verifikasi', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_lulusans');
    }
};
