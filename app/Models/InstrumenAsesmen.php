<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumenAsesmen extends Model
{
    use HasFactory;

    protected $table = 'instrumen_asesmens';

    protected $fillable = [
        'nama_instrumen',
        'kategori',
        'deskripsi',
        'status',
    ];

    /**
     * Relasi ke Pertanyaan Asesmen.
     */
    public function pertanyaanAsesmens(): HasMany
    {
        return $this->hasMany(PertanyaanAsesmen::class, 'instrumen_asesmen_id');
    }

    /**
     * Relasi ke Asesmen Mahasiswa.
     */
    public function asesmenMahasiswas(): HasMany
    {
        return $this->hasMany(AsesmenMahasiswa::class, 'instrumen_asesmen_id');
    }
}
