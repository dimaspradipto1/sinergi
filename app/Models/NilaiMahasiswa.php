<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_mahasiswas';

    protected $fillable = [
        'krs_id',
        'mata_kuliah_id',
        'nilai_angka',
        'nilai_huruf',
    ];

    protected function casts(): array
    {
        return [
            'nilai_angka' => 'float',
        ];
    }

    /**
     * Relasi ke KRS.
     */
    public function krs(): BelongsTo
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    /**
     * Relasi ke Mata Kuliah.
     */
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Helper konversi nilai huruf ke bobot indeks (4.0 basis)
     */
    public function getBobotAttribute(): float
    {
        return match (strtoupper($this->nilai_huruf)) {
            'A'  => 4.0,
            'B+' => 3.5,
            'B'  => 3.0,
            'C+' => 2.5,
            'C'  => 2.0,
            'D'  => 1.0,
            default => 0.0,
        };
    }
}
