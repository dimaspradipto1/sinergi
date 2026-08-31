@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Export Data Terpadu</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Laporan</li>
            <li class="breadcrumb-item active">Export Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner -->
    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center mb-4 py-3 px-4">
        <i class="bi bi-cloud-arrow-down-fill fs-2 text-primary me-3"></i>
        <div>
            <h5 class="alert-heading fw-bold mb-1">Pusat Unduh & Export Data (Export Center)</h5>
            <div class="small text-muted">Unduh seluruh master data dan riwayat transaksi sistem Pusat Layanan Disabilitas (PLD) dalam format spreadsheet CSV / Excel siap pakai secara instan.</div>
        </div>
    </div>

    <div class="row">
        <!-- Card 1: Data Mahasiswa -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                            <span class="badge bg-primary fs-6">{{ $countMahasiswa }} Data</span>
                        </div>
                        <h5 class="fw-bold mb-1">Data Mahasiswa</h5>
                        <p class="text-muted small mb-0">Biodata mahasiswa, NIM, fakultas, program studi, status MABA, dan kontak.</p>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('export-data.download', 'mahasiswa') }}" class="btn btn-primary w-100">
                            <i class="bi bi-download me-1"></i> Download CSV / Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Data Asesmen -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #fdf2f8; color: #db2777;">
                                <i class="bi bi-clipboard-check fs-4"></i>
                            </div>
                            <span class="badge bg-danger fs-6">{{ $countAsesmen }} Data</span>
                        </div>
                        <h5 class="fw-bold mb-1">Hasil Asesmen Kompetensi</h5>
                        <p class="text-muted small mb-0">Hasil pengujian asesmen, instrumen, total skor, dan catatan rekomendasi akomodasi.</p>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('export-data.download', 'asesmen') }}" class="btn btn-danger w-100">
                            <i class="bi bi-download me-1"></i> Download CSV / Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Data Alumni -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0f8e9; color: #16a34a;">
                                <i class="bi bi-mortarboard fs-4"></i>
                            </div>
                            <span class="badge bg-success fs-6">{{ $countAlumni }} Data</span>
                        </div>
                        <h5 class="fw-bold mb-1">Data Alumni</h5>
                        <p class="text-muted small mb-0">Database lulusan, tahun kelulusan, kontak terbaru, dan tempat bekerja alumni.</p>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('export-data.download', 'alumni') }}" class="btn btn-success w-100">
                            <i class="bi bi-download me-1"></i> Download CSV / Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Tracer Study -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #ffefe6; color: #ea580c;">
                                <i class="bi bi-search fs-4"></i>
                            </div>
                            <span class="badge bg-warning text-dark fs-6">{{ $countTracer }} Data</span>
                        </div>
                        <h5 class="fw-bold mb-1">Data Tracer Study</h5>
                        <p class="text-muted small mb-0">Hasil survey serapan kerja, masa tunggu pertama, relevansi studi, dan range gaji.</p>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('export-data.download', 'tracer') }}" class="btn btn-warning text-dark w-100">
                            <i class="bi bi-download me-1"></i> Download CSV / Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Pintasan Cetak Laporan -->
        <div class="col-md-6 col-lg-8 mb-4">
            <div class="card shadow-sm h-100 border-0 bg-light">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-2"><i class="bi bi-printer me-2 text-primary"></i>Pintasan Cetak Laporan Fisik / PDF</h5>
                        <p class="text-muted small mb-3">Buka halaman laporan terfilter untuk melakukan pencetakan dokumen PDF atau print fisik:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('laporan-mahasiswa.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right-circle me-1"></i> Laporan Mahasiswa
                            </a>
                            <a href="{{ route('laporan-akademik.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right-circle me-1"></i> Laporan Akademik
                            </a>
                            <a href="{{ route('laporan-asesmen.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right-circle me-1"></i> Laporan Asesmen
                            </a>
                            <a href="{{ route('laporan-alumni.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right-circle me-1"></i> Laporan Alumni
                            </a>
                            <a href="{{ route('laporan-tracer-study.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right-circle me-1"></i> Laporan Tracer Study
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
