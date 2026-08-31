<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAkademiks = [
            '2026/2027 Gasal',
            '2025/2026 Semester Antara',
            '2025/2026 Genap',
            '2025/2026 Gasal',
            '2024/2025 Semester Antara',
            '2024/2025 Genap',
            '2024/2025 Gasal',
            '2023/2024 Semester Antara',
            '2023/2024 Genap',
            '2023/2024 Gasal',
            '2022/2023 Semester Antara',
            '2022/2023 Genap',
            '2022/2023 Gasal',
            '2021/2022 Semester Antara',
            '2021/2022 Genap',
            '2021/2022 Gasal',
            '2020/2021 Semester Antara',
            '2020/2021 Genap',
            '2020/2021 Gasal',
            '2019/2020 Semester Antara',
            '2019/2020 Genap',
            '2019/2020 Gasal',
        ];

        foreach ($tahunAkademiks as $tahun) {
            TahunAkademik::updateOrCreate(
                ['tahun_akademik' => $tahun],
                ['tahun_akademik' => $tahun]
            );
        }
    }
}
