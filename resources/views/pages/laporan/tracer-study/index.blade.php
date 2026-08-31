@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Laporan Hasil Tracer Study</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active">Laporan Tracer Study</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('export-data.download', 'tracer') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Data
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Filter Card (d-print-none) -->
    <div class="card shadow-sm border-0 mb-3 d-print-none">
        <div class="card-header bg-white py-3">
            <h6 class="card-title mb-0 p-0 fs-6 fw-bold">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Tracer Study
            </h6>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('laporan-tracer-study.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Tahun Pelaksanaan Survey</label>
                        <select name="tahun_survey" class="form-select form-select-sm">
                            <option value="">-- Semua Tahun Survey --</option>
                            @foreach($tahunSurveyList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_survey') == $tahun ? 'selected' : '' }}>
                                    Tahun {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Status Pekerjaan</label>
                        <select name="status_pekerjaan" class="form-select form-select-sm">
                            <option value="">-- Semua Status Pekerjaan --</option>
                            @foreach($statusList as $status)
                                <option value="{{ $status }}" {{ request('status_pekerjaan') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('laporan-tracer-study.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stat Cards Summary -->
    <div class="row">
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Responden Survey</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalResponden }}</h6>
                            <span class="text-muted small pt-2 ps-1">Alumni Responden</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Masa Tunggu</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $avgWaktuTunggu }} Bulan</h6>
                            <span class="text-muted small pt-2 ps-1">Waktu Dapat Kerja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kesesuaian Bidang</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2eca6a; background: #e0f8e9;">
                            <i class="bi bi-check2-all"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $avgRelevansi }}%</h6>
                            <span class="text-muted small pt-2 ps-1">Relevansi Studi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Laporan Tracer Study -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-file-earmark-spreadsheet me-2 text-primary"></i>Rekapitulasi Survey Tracer Study
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th width="120">NIM</th>
                                    <th>Nama Alumni</th>
                                    <th>Program Studi</th>
                                    <th width="100" class="text-center">Tahun Survey</th>
                                    <th>Status Pekerjaan</th>
                                    <th width="110" class="text-center">Masa Tunggu</th>
                                    <th width="100" class="text-center">Relevansi</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tracerList as $index => $tr)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary">{{ $tr->alumni->mahasiswa->nim ?? '-' }}</td>
                                        <td class="fw-semibold">{{ $tr->alumni->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $tr->alumni->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $tr->tahun_survey }}</td>
                                        <td><span class="badge bg-primary">{{ $tr->status_pekerjaan }}</span></td>
                                        <td class="text-center">{{ $tr->waktu_tunggu }} Bulan</td>
                                        <td class="text-center"><span class="badge bg-success">{{ $tr->relevansi_bidang }}%</span></td>
                                        <td class="fw-semibold text-primary">{{ $tr->pendapatan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data tracer study yang sesuai filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
