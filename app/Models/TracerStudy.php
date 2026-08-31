<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_studies';

    protected $fillable = [
        'alumni_id',
        'tahun_survey',
        'status_pekerjaan',
        'waktu_tunggu',
        'relevansi_bidang',
        'pendapatan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_tunggu'     => 'integer',
            'relevansi_bidang' => 'integer',
        ];
    }

    /**
     * Relasi ke Alumni.
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}
