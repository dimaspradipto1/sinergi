@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Laporan Capaian Akademik</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active">Laporan Akademik</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('export-data.download', 'mahasiswa') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Data
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Filter Card (d-print-none) -->
    <div class="card shadow-sm border-0 mb-3 d-print-none">
        <div class="card-header bg-white py-3">
            <h6 class="card-title mb-0 p-0 fs-6 fw-bold">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Akademik
            </h6>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('laporan-akademik.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Tahun Akademik KRS</label>
                        <select name="tahun_akademik" class="form-select form-select-sm">
                            <option value="">-- Semua Periode --</option>
                            @foreach($tahunAkademikList as $ta)
                                <option value="{{ $ta->tahun_akademik }}" {{ request('tahun_akademik') == $ta->tahun_akademik ? 'selected' : '' }}>
                                    {{ $ta->tahun_akademik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Program Studi</label>
                        <select name="program_studi_id" class="form-select form-select-sm">
                            <option value="">-- Semua Program Studi --</option>
                            @foreach($programStudiList as $prodi)
                                <option value="{{ $prodi->id }}" {{ request('program_studi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->program_studi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Semester KRS</label>
                        <select name="semester" class="form-select form-select-sm">
                            <option value="">-- Semua Semester --</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('laporan-akademik.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stat Cards Summary (NiceAdmin Clean Card Style) -->
    <div class="row">
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalMahasiswa }}</h6>
                            <span class="text-muted small pt-2 ps-1">Mahasiswa Terdata</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata IPK</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($avgIpk, 2) }}</h6>
                            <span class="text-muted small pt-2 ps-1">Rata-rata Indeks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">IPK ≥ 3.50 (Cumlaude)</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2eca6a; background: #e0f8e9;">
                            <i class="bi bi-award"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalCumlaude }}</h6>
                            <span class="text-muted small pt-2 ps-1">Dengan Pujian</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">IPK 3.00 - 3.49</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4154f1; background: #f6f6fe;">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalSangatMemuaskan }}</h6>
                            <span class="text-muted small pt-2 ps-1">Sangat Memuaskan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Laporan Akademik -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-journal-bookmark me-2 text-primary"></i>Rekapitulasi Nilai & Capaian Akademik Mahasiswa
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th width="120">NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Program Studi</th>
                                    <th width="100" class="text-center">Total SKS</th>
                                    <th width="100" class="text-center">IPK</th>
                                    <th width="140" class="text-center">Predikat</th>
                                    <th width="100" class="text-center">Prestasi</th>
                                    <th width="100" class="text-center">Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapAkademik as $index => $row)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary">{{ $row['mahasiswa']->nim }}</td>
                                        <td class="fw-semibold">{{ $row['mahasiswa']->nama }}</td>
                                        <td>{{ $row['mahasiswa']->programStudi->program_studi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $row['total_sks'] }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $row['ipk'] >= 3.5 ? 'bg-success' : ($row['ipk'] >= 3.0 ? 'bg-primary' : 'bg-secondary') }} fs-6">
                                                {{ number_format($row['ipk'], 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($row['ipk'] >= 3.50)
                                                <span class="badge bg-success">Dengan Pujian (Cumlaude)</span>
                                            @elseif($row['ipk'] >= 3.00)
                                                <span class="badge bg-primary">Sangat Memuaskan</span>
                                            @elseif($row['ipk'] >= 2.50)
                                                <span class="badge bg-info text-dark">Memuaskan</span>
                                            @elseif($row['ipk'] > 0)
                                                <span class="badge bg-warning text-dark">Cukup</span>
                                            @else
                                                <span class="badge bg-light text-dark border">Belum Ada Nilai</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">{{ $row['total_prestasi'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">{{ $row['total_sertifikat'] }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data akademik yang sesuai filter.</td>
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
