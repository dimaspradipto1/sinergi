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
        Schema::create('jawaban_asesmens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_mahasiswa_id')->constrained('asesmen_mahasiswas')->cascadeOnDelete();
            $table->foreignId('pertanyaan_asesmen_id')->constrained('pertanyaan_asesmens')->cascadeOnDelete();
            $table->text('jawaban')->nullable();
            $table->integer('skor')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_asesmens');
    }
};
