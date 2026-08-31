@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Laporan Asesmen Kompetensi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active">Laporan Asesmen</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('export-data.download', 'asesmen') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Data
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Filter Card (d-print-none) -->
    <div class="card shadow-sm border-0 mb-3 d-print-none">
        <div class="card-header bg-white py-3">
            <h6 class="card-title mb-0 p-0 fs-6 fw-bold">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Asesmen
            </h6>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('laporan-asesmen.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Instrumen Asesmen</label>
                        <select name="instrumen_asesmen_id" class="form-select form-select-sm">
                            <option value="">-- Semua Instrumen Asesmen --</option>
                            @foreach($instrumenList as $ins)
                                <option value="{{ $ins->id }}" {{ request('instrumen_asesmen_id') == $ins->id ? 'selected' : '' }}>
                                    {{ $ins->nama_asesmen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control form-select-sm" value="{{ request('tanggal_mulai') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control form-select-sm" value="{{ request('tanggal_selesai') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('laporan-asesmen.index') }}" class="btn btn-secondary btn-sm">
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
                    <h5 class="card-title">Total Asesmen</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAsesmen }}</h6>
                            <span class="text-muted small pt-2 ps-1">Sesi Pelaksanaan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Skor</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $avgSkor }}</h6>
                            <span class="text-muted small pt-2 ps-1">Rata-rata Nilai Asesmen</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Akomodasi / Kategori Tinggi</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2eca6a; background: #e0f8e9;">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalTinggi }}</h6>
                            <span class="text-muted small pt-2 ps-1">Mahasiswa Mandiri/Optimal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Laporan Asesmen -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-card-checklist me-2 text-primary"></i>Rekapitulasi Hasil Asesmen Mahasiswa
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th width="120">NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Instrumen Asesmen</th>
                                    <th width="120" class="text-center">Tanggal</th>
                                    <th width="100" class="text-center">Skor Total</th>
                                    <th>Rekomendasi Akomodasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asesmenList as $index => $as)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary">{{ $as->mahasiswa->nim ?? '-' }}</td>
                                        <td class="fw-semibold">{{ $as->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $as->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $as->instrumenAsesmen->nama_asesmen ?? '-' }}</span></td>
                                        <td class="text-center">{{ $as->tanggal_asesmen ? $as->tanggal_asesmen->format('d/m/Y') : '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6 fw-bold">{{ $as->skor_total }}</span>
                                        </td>
                                        <td class="small">{{ $as->rekomendasi ?: 'Tidak ada rekomendasi khusus.' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Belum ada data asesmen yang sesuai filter.</td>
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
