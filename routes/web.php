<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenLulusanController;
use App\Http\Controllers\DokumenMahasiswaController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HasilAsesmenController;
use App\Http\Controllers\InstrumenAsesmenController;
use App\Http\Controllers\IpIpkController;
use App\Http\Controllers\KarierAlumniController;
use App\Http\Controllers\KebutuhanInklusifController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\LaporanAkademikController;
use App\Http\Controllers\LaporanAlumniController;
use App\Http\Controllers\LaporanAsesmenController;
use App\Http\Controllers\LaporanMahasiswaController;
use App\Http\Controllers\LaporanTracerStudyController;
use App\Http\Controllers\MahasiswaBaruController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\MonitoringAlumniController;
use App\Http\Controllers\NilaiMahasiswaController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PelaksanaanAsesmenController;
use App\Http\Controllers\PemetaanKompetensiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PertanyaanAsesmenController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\StatusPekerjaanController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\WisudaController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login');
    Route::post('/login', 'loginproses')->name('login.proses');
    Route::get('/loginproses', 'loginproses');
    Route::post('/loginproses', 'loginproses')->name('loginproses');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerproses')->name('register.proses');
    Route::get('/registerproses', 'registerproses');
    Route::post('/registerproses', 'registerproses')->name('registerproses');

    Route::post('/logout', 'logout')->name('logout');
    Route::get('/logout', 'logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Pendataan
    Route::resource('mahasiswa-baru', MahasiswaBaruController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('dokumen-mahasiswa', DokumenMahasiswaController::class);
    Route::resource('kebutuhan-inklusif', KebutuhanInklusifController::class);
    Route::resource('alumni', AlumniController::class);

    // 2. Akademik & Penilaian
    Route::resource('mata-kuliah', MataKuliahController::class);
    Route::resource('krs', KrsController::class);
    Route::resource('nilai-mahasiswa', NilaiMahasiswaController::class);
    Route::resource('ip-ipk', IpIpkController::class)->only(['index', 'show']);
    Route::resource('prestasi', PrestasiController::class);
    Route::resource('sertifikasi', SertifikasiController::class);
    Route::resource('portofolio', PortofolioController::class);

    // 3. Asesmen Kompetensi
    Route::resource('instrumen-asesmen', InstrumenAsesmenController::class);
    Route::resource('pertanyaan-asesmen', PertanyaanAsesmenController::class);
    Route::get('/pelaksanaan-asesmen/get-pertanyaan', [PelaksanaanAsesmenController::class, 'getPertanyaan'])->name('pelaksanaan-asesmen.get-pertanyaan');
    Route::resource('pelaksanaan-asesmen', PelaksanaanAsesmenController::class);
    Route::resource('hasil-asesmen', HasilAsesmenController::class)->only(['index', 'show']);
    Route::get('/pemetaan-kompetensi', [PemetaanKompetensiController::class, 'index'])->name('pemetaan-kompetensi.index');

    // 4. Kelulusan
    Route::resource('data-kelulusan', KelulusanController::class);
    Route::resource('wisuda', WisudaController::class);
    Route::resource('dokumen-lulusan', DokumenLulusanController::class);

    // 5. Pelacakan Karir
    Route::resource('tracer-study', TracerStudyController::class);
    Route::get('/status-pekerjaan', [StatusPekerjaanController::class, 'index'])->name('status-pekerjaan.index');
    Route::resource('riwayat-karier', KarierAlumniController::class);
    Route::resource('perusahaan-mitra', PerusahaanController::class);
    Route::get('/monitoring-alumni', [MonitoringAlumniController::class, 'index'])->name('monitoring-alumni.index');

    // 6. Laporan & Export
    Route::get('/laporan-mahasiswa', [LaporanMahasiswaController::class, 'index'])->name('laporan-mahasiswa.index');
    Route::get('/laporan-akademik', [LaporanAkademikController::class, 'index'])->name('laporan-akademik.index');
    Route::get('/laporan-asesmen', [LaporanAsesmenController::class, 'index'])->name('laporan-asesmen.index');
    Route::get('/laporan-alumni', [LaporanAlumniController::class, 'index'])->name('laporan-alumni.index');
    Route::get('/laporan-tracer-study', [LaporanTracerStudyController::class, 'index'])->name('laporan-tracer-study.index');
    Route::get('/export-data', [ExportDataController::class, 'index'])->name('export-data.index');
    Route::get('/export-data/download/{type}', [ExportDataController::class, 'export'])->name('export-data.download');

    // 7. Master Data
    Route::put('/pengguna/{pengguna}/password', [PenggunaController::class, 'updatePassword'])->name('pengguna.password.update');
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('fakultas', FakultasController::class);
    Route::resource('program-studi', ProgramStudiController::class);
    Route::resource('tahun-akademik', TahunAkademikController::class);
    Route::resource('semester', SemesterController::class);
});

