<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'FAKULTAS EKONOMI DAN BISNIS (FEB)' => [
                'S2-MAGISTER MANAJEMEN',
                'S1-AKUNTANSI',
                'S1-MANAJEMEN',
            ],
            'FAKULTAS SAINS DAN TEKNOLOGI (FST)' => [
                'S1-TEKNIK INDUSTRI',
                'S1-TEKNIK INFORMATIKA',
                'S1-TEKNIK LOGISTIK',
                'S1-SISTEM INFORMASI',
                'S1-TEKNIK PERKAPALAN',
            ],
            'FAKULTAS ILMU KESEHATAN (FIKes)' => [
                'S2-KESEHATAN MASYARAKAT',
                'S1-KESEHATAN DAN KESELAMATAN KERJA',
                'S1-KESEHATAN LINGKUNGAN',
            ],
        ];

        foreach ($data as $namaFakultas => $prodis) {
            $fakultas = Fakultas::where('nama_fakultas', $namaFakultas)->first();

            if ($fakultas) {
                foreach ($prodis as $namaProdi) {
                    ProgramStudi::updateOrCreate(
                        [
                            'fakultas_id'   => $fakultas->id,
                            'program_studi' => $namaProdi,
                        ],
                        [
                            'fakultas_id'   => $fakultas->id,
                            'program_studi' => $namaProdi,
                        ]
                    );
                }
            }
        }
    }
}
