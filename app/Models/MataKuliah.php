<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks',
        'semester',
    ];

    /**
     * Relasi ke Nilai Mahasiswa.
     */
    public function nilaiMahasiswas(): HasMany
    {
        return $this->hasMany(NilaiMahasiswa::class, 'mata_kuliah_id');
    }
}
