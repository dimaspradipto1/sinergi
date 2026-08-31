@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Laporan Alumni & Kelulusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active">Laporan Alumni</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('export-data.download', 'alumni') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Data
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Filter Card (d-print-none) -->
    <div class="card shadow-sm border-0 mb-3 d-print-none">
        <div class="card-header bg-white py-3">
            <h6 class="card-title mb-0 p-0 fs-6 fw-bold">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Alumni
            </h6>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('laporan-alumni.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Tahun Kelulusan</label>
                        <select name="tahun_lulus" class="form-select form-select-sm">
                            <option value="">-- Semua Tahun Lulus --</option>
                            @foreach($tahunLulusList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>
                                    Tahun {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
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
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('laporan-alumni.index') }}" class="btn btn-secondary btn-sm">
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
                    <h5 class="card-title">Total Alumni</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAlumni }}</h6>
                            <span class="text-muted small pt-2 ps-1">Lulusan Terfilter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Telah Bekerja / Berkarier</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalBekerja }}</h6>
                            <span class="text-muted small pt-2 ps-1">Alumni Bekerja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mengisi Tracer Study</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4154f1; background: #f6f6fe;">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalTracerTerisi }}</h6>
                            <span class="text-muted small pt-2 ps-1">Partisipan Kuesioner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Laporan Alumni -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-mortarboard me-2 text-primary"></i>Rekapitulasi Data Alumni & Karier
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
                                    <th width="100" class="text-center">Tahun Lulus</th>
                                    <th>Pekerjaan Saat Ini</th>
                                    <th>Instansi / Kantor</th>
                                    <th width="120" class="text-center">Tracer Study</th>
                                    <th>Kontak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alumniList as $index => $alm)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary">{{ $alm->mahasiswa->nim ?? '-' }}</td>
                                        <td class="fw-semibold">{{ $alm->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $alm->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $alm->tahun_lulus }}</td>
                                        <td>{{ $alm->pekerjaan_sekarang ?: '-' }}</td>
                                        <td>{{ $alm->instansi_tempat_kerja ?: '-' }}</td>
                                        <td class="text-center">
                                            @if($alm->tracerStudies->count() > 0)
                                                <span class="badge bg-success">Terisi</span>
                                            @else
                                                <span class="badge bg-secondary">Belum</span>
                                            @endif
                                        </td>
                                        <td class="small">
                                            @if($alm->no_hp_aktif) <div><i class="bi bi-whatsapp text-success me-1"></i>{{ $alm->no_hp_aktif }}</div> @endif
                                            @if($alm->email_aktif) <div><i class="bi bi-envelope text-muted me-1"></i>{{ $alm->email_aktif }}</div> @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data alumni yang sesuai filter.</td>
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
