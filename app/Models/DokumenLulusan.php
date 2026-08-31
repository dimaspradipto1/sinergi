<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenLulusan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_lulusans';

    protected $fillable = [
        'mahasiswa_id',
        'jenis_dokumen',
        'nomor_dokumen',
        'tanggal_terbit',
        'file',
        'status_verifikasi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terbit' => 'date',
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
