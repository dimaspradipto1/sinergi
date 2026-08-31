<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelulusan extends Model
{
    use HasFactory;

    protected $table = 'kelulusans';

    protected $fillable = [
        'mahasiswa_id',
        'nomor_sk_yudisium',
        'tanggal_sk_yudisium',
        'tanggal_lulus',
        'ipk_kelulusan',
        'predikat',
        'judul_tugas_akhir',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sk_yudisium' => 'date',
            'tanggal_lulus'       => 'date',
            'ipk_kelulusan'       => 'float',
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
