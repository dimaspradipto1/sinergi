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
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->cascadeOnDelete();
            $table->year('tahun_survey');
            $table->string('status_pekerjaan');
            $table->integer('waktu_tunggu')->comment('Masa tunggu mendapatkan pekerjaan dalam hitungan bulan');
            $table->integer('relevansi_bidang')->comment('Persentase kesesuaian bidang studi (0 - 100%)');
            $table->string('pendapatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_studies');
    }
};
