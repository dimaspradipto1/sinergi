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
        Schema::create('pertanyaan_asesmens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrumen_asesmen_id')->constrained('instrumen_asesmens')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->string('tipe_jawaban');
            $table->integer('bobot')->default(1);
            $table->text('pilihan_jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_asesmens');
    }
};
