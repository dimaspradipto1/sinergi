<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            'SEMESTER SATU (I)',
            'SEMESTER DUA (II)',
            'SEMESTER TIGA (III)',
            'SEMESTER EMPAT (IV)',
            'SEMESTER LIMA (V)',
            'SEMESTER ENAM (VI)',
            'SEMESTER TUJUH (VII)',
            'SEMESTER DELAPAN (VIII)',
        ];

        foreach ($semesters as $item) {
            Semester::updateOrCreate(
                ['semester' => $item],
                ['semester' => $item]
            );
        }
    }
}
