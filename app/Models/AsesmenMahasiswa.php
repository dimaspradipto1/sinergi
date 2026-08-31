<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsesmenMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'asesmen_mahasiswas';

    protected $fillable = [
        'mahasiswa_id',
        'instrumen_asesmen_id',
        'tanggal',
        'nilai_total',
        'kategori',
        'catatan_asesor',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'     => 'date',
            'nilai_total' => 'float',
        ];
    }

    /**
     * Relasi ke Mahasiswa.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Instrumen Asesmen.
     */
    public function instrumenAsesmen(): BelongsTo
    {
        return $this->belongsTo(InstrumenAsesmen::class, 'instrumen_asesmen_id');
    }

    /**
     * Relasi ke Jawaban Asesmen.
     */
    public function jawabanAsesmens(): HasMany
    {
        return $this->hasMany(JawabanAsesmen::class, 'asesmen_mahasiswa_id');
    }
}
