<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KebutuhanInklusif extends Model
{
    use HasFactory;

    protected $table = 'kebutuhan_inklusifs';

    protected $fillable = [
        'mahasiswa_id',
        'kebutuhan',
        'kategori',
        'deskripsi',
        'layanan_pendukung',
    ];

    /**
     * Relasi ke Mahasiswa.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
