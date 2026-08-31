<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'jawaban_asesmens';

    protected $fillable = [
        'asesmen_mahasiswa_id',
        'pertanyaan_asesmen_id',
        'jawaban',
        'skor',
    ];

    /**
     * Relasi ke Asesmen Mahasiswa.
     */
    public function asesmenMahasiswa(): BelongsTo
    {
        return $this->belongsTo(AsesmenMahasiswa::class, 'asesmen_mahasiswa_id');
    }

    /**
     * Relasi ke Pertanyaan Asesmen.
     */
    public function pertanyaanAsesmen(): BelongsTo
    {
        return $this->belongsTo(PertanyaanAsesmen::class, 'pertanyaan_asesmen_id');
    }
}
