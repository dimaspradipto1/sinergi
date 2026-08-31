<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mahasiswas';

    protected $fillable = [
        'mahasiswa_id',
        'nama_dokumen',
        'jenis_dokumen',
        'nomor_dokumen',
        'file_dokumen',
        'keterangan',
    ];

    /**
     * Relasi ke Mahasiswa.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
