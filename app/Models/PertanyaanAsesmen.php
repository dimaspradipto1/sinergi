<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PertanyaanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_asesmens';

    protected $fillable = [
        'instrumen_asesmen_id',
        'pertanyaan',
        'tipe_jawaban',
        'bobot',
        'pilihan_jawaban',
    ];

    /**
     * Relasi ke Instrumen Asesmen.
     */
    public function instrumenAsesmen(): BelongsTo
    {
        return $this->belongsTo(InstrumenAsesmen::class, 'instrumen_asesmen_id');
    }
}
