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
        Schema::create('wisudas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->string('periode_wisuda');
            $table->date('tanggal_wisuda');
            $table->string('nomor_kursi')->nullable();
            $table->enum('status_kehadiran', ['Terdaftar', 'Hadir', 'Tidak Hadir'])->default('Terdaftar');
            $table->text('kebutuhan_khusus_wisuda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisudas');
    }
};
