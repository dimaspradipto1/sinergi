<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wisuda extends Model
{
    use HasFactory;

    protected $table = 'wisudas';

    protected $fillable = [
        'mahasiswa_id',
        'periode_wisuda',
        'tanggal_wisuda',
        'nomor_kursi',
        'status_kehadiran',
        'kebutuhan_khusus_wisuda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_wisuda' => 'date',
        ];
    }

    /**
     * Relasi ke Mahasiswa.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
