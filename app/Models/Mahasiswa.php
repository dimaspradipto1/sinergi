<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'program_studi_id',
        'tahun_akademik_id',
        'jalur_masuk',
        'nim',
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'no_hp',
        'alamat',
        'status_mahasiswa',
        'foto',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke Program Studi.
     */
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Relasi ke Tahun Akademik.
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    /**
     * Relasi ke Orang Tua / Wali.
     */
    public function orangTua(): HasOne
    {
        return $this->hasOne(OrangTua::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Dokumen Mahasiswa.
     */
    public function dokumenMahasiswas(): HasMany
    {
        return $this->hasMany(DokumenMahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Kebutuhan Inklusif.
     */
    public function kebutuhanInklusifs(): HasMany
    {
        return $this->hasMany(KebutuhanInklusif::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Data Alumni.
     */
    public function alumni(): HasOne
    {
        return $this->hasOne(Alumni::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Asesmen Mahasiswa.
     */
    public function asesmenMahasiswas(): HasMany
    {
        return $this->hasMany(AsesmenMahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke KRS.
     */
    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Prestasi.
     */
    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Sertifikasi.
     */
    public function sertifikasis(): HasMany
    {
        return $this->hasMany(Sertifikasi::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Portofolio.
     */
    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Data Kelulusan.
     */
    public function kelulusan(): HasOne
    {
        return $this->hasOne(Kelulusan::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Wisuda.
     */
    public function wisudas(): HasMany
    {
        return $this->hasMany(Wisuda::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke Dokumen Lulusan.
     */
    public function dokumenLulusans(): HasMany
    {
        return $this->hasMany(DokumenLulusan::class, 'mahasiswa_id');
    }
}
