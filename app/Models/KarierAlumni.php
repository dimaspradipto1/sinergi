<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KarierAlumni extends Model
{
    use HasFactory;

    protected $table = 'karier_alumnis';

    protected $fillable = [
        'alumni_id',
        'perusahaan_id',
        'jabatan',
        'tanggal_mulai',
        'status_kerja',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
        ];
    }

    /**
     * Relasi ke Alumni.
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    /**
     * Relasi ke Perusahaan.
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}
