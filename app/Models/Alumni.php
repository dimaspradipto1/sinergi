<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumnis';

    protected $fillable = [
        'mahasiswa_id',
        'tahun_lulus',
        'email_aktif',
        'no_hp_aktif',
        'alamat_terbaru',
        'pekerjaan_sekarang',
        'instansi_tempat_kerja',
    ];

    /**
     * Relasi ke Mahasiswa.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Tracer Study.
     */
    public function tracerStudies(): HasMany
    {
        return $this->hasMany(TracerStudy::class, 'alumni_id');
    }

    /**
     * Relasi ke Riwayat Karier Alumni.
     */
    public function karierAlumnis(): HasMany
    {
        return $this->hasMany(KarierAlumni::class, 'alumni_id');
    }
}
