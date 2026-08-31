<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaans';

    protected $fillable = [
        'nama_perusahaan',
        'bidang',
        'alamat',
        'kontak',
    ];

    /**
     * Relasi ke Riwayat Karier Alumni.
     */
    public function karierAlumnis(): HasMany
    {
        return $this->hasMany(KarierAlumni::class, 'perusahaan_id');
    }
}
