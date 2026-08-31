<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SystemAuditTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    /**
     * Test all main index and create routes.
     *
     * @dataProvider routeProvider
     */
    public function test_route_accessible(string $routeName): void
    {
        $response = $this->actingAs($this->user)->get(route($routeName));

        $response->assertStatus(200);
    }

    public static function routeProvider(): array
    {
        return [
            // Dashboard
            ['dashboard'],
            // 1. Pendataan
            ['mahasiswa-baru.index'],
            ['mahasiswa-baru.create'],
            ['mahasiswa.index'],
            ['mahasiswa.create'],
            ['orang-tua.index'],
            ['orang-tua.create'],
            ['dokumen-mahasiswa.index'],
            ['dokumen-mahasiswa.create'],
            ['kebutuhan-inklusif.index'],
            ['kebutuhan-inklusif.create'],
            ['alumni.index'],
            ['alumni.create'],
            // 2. Akademik & Penilaian
            ['mata-kuliah.index'],
            ['mata-kuliah.create'],
            ['krs.index'],
            ['krs.create'],
            ['nilai-mahasiswa.index'],
            ['nilai-mahasiswa.create'],
            ['ip-ipk.index'],
            ['prestasi.index'],
            ['prestasi.create'],
            ['sertifikasi.index'],
            ['sertifikasi.create'],
            ['portofolio.index'],
            ['portofolio.create'],
            // 3. Asesmen Kompetensi
            ['instrumen-asesmen.index'],
            ['instrumen-asesmen.create'],
            ['pertanyaan-asesmen.index'],
            ['pertanyaan-asesmen.create'],
            ['pelaksanaan-asesmen.index'],
            ['pelaksanaan-asesmen.create'],
            ['hasil-asesmen.index'],
            ['pemetaan-kompetensi.index'],
            // 4. Kelulusan
            ['data-kelulusan.index'],
            ['data-kelulusan.create'],
            ['wisuda.index'],
            ['wisuda.create'],
            ['dokumen-lulusan.index'],
            ['dokumen-lulusan.create'],
            // 5. Pelacakan Karir
            ['tracer-study.index'],
            ['tracer-study.create'],
            ['status-pekerjaan.index'],
            ['riwayat-karier.index'],
            ['riwayat-karier.create'],
            ['perusahaan-mitra.index'],
            ['perusahaan-mitra.create'],
            ['monitoring-alumni.index'],
            // 6. Laporan
            ['laporan-mahasiswa.index'],
            ['laporan-akademik.index'],
            ['laporan-asesmen.index'],
            ['laporan-alumni.index'],
            ['laporan-tracer-study.index'],
            ['export-data.index'],
            // 7. Master Data
            ['pengguna.index'],
            ['pengguna.create'],
            ['fakultas.index'],
            ['fakultas.create'],
            ['program-studi.index'],
            ['program-studi.create'],
            ['tahun-akademik.index'],
            ['tahun-akademik.create'],
            ['semester.index'],
            ['semester.create'],
            // Profil
            ['profile.index'],
        ];
    }
}
