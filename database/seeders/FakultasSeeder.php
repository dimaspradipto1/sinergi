<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakultasList = [
            ['nama_fakultas' => 'FAKULTAS EKONOMI DAN BISNIS (FEB)'],
            ['nama_fakultas' => 'FAKULTAS SAINS DAN TEKNOLOGI (FST)'],
            ['nama_fakultas' => 'FAKULTAS ILMU KESEHATAN (FIKes)'],
        ];

        foreach ($fakultasList as $fakultas) {
            Fakultas::updateOrCreate(
                ['nama_fakultas' => $fakultas['nama_fakultas']],
                $fakultas
            );
        }
    }
}
