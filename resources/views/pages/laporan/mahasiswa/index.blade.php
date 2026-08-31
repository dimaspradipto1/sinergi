@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Laporan Data Mahasiswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active">Laporan Mahasiswa</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('export-data.download', 'mahasiswa') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel/CSV
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Filter Card (d-print-none) -->
    <div class="card shadow-sm border-0 mb-3 d-print-none">
        <div class="card-header bg-white py-3">
            <h6 class="card-title mb-0 p-0 fs-6 fw-bold">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Mahasiswa
            </h6>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('laporan-mahasiswa.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Tahun Akademik</label>
                        <select name="tahun_akademik_id" class="form-select form-select-sm">
                            <option value="">-- Semua Angkatan --</option>
                            @foreach($tahunAkademik as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_akademik_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_akademik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Fakultas</label>
                        <select name="fakultas_id" class="form-select form-select-sm">
                            <option value="">-- Semua Fakultas --</option>
                            @foreach($fakultas as $fak)
                                <option value="{{ $fak->id }}" {{ request('fakultas_id') == $fak->id ? 'selected' : '' }}>
                                    {{ $fak->nama_fakultas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Program Studi</label>
                        <select name="program_studi_id" class="form-select form-select-sm">
                            <option value="">-- Semua Program Studi --</option>
                            @foreach($programStudi as $prodi)
                                <option value="{{ $prodi->id }}" {{ request('program_studi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->program_studi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select form-select-sm">
                            <option value="">-- Semua --</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('laporan-mahasiswa.index') }}" class="btn btn-secondary btn-sm">
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
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalMahasiswa }}</h6>
                            <span class="text-muted small pt-2 ps-1">Mahasiswa Terfilter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Laki-laki</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-gender-male"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalLaki }}</h6>
                            <span class="text-muted small pt-2 ps-1">Mahasiswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Perempuan</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #e83e8c; background: #fdf2f8;">
                            <i class="bi bi-gender-female"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalPerempuan }}</h6>
                            <span class="text-muted small pt-2 ps-1">Mahasiswi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mahasiswa Baru</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff771d; background: #ffefe6;">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalMaba }}</h6>
                            <span class="text-muted small pt-2 ps-1">Status MABA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-table me-2 text-primary"></i>Rekapitulasi Data Mahasiswa
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
                                    <th width="50" class="text-center">L/P</th>
                                    <th>Program Studi</th>
                                    <th>Fakultas</th>
                                    <th width="120" class="text-center">Angkatan</th>
                                    <th>Kebutuhan Khusus / Ragam</th>
                                    <th>Kontak Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswaList as $index => $mhs)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary">{{ $mhs->nim }}</td>
                                        <td class="fw-semibold">{{ $mhs->nama }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $mhs->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">
                                                {{ $mhs->jenis_kelamin }}
                                            </span>
                                        </td>
                                        <td>{{ $mhs->programStudi->program_studi ?? '-' }}</td>
                                        <td>{{ $mhs->programStudi->fakultas->nama_fakultas ?? '-' }}</td>
                                        <td class="text-center">{{ $mhs->tahunAkademik->tahun_akademik ?? '-' }}</td>
                                        <td>
                                            @if($mhs->kebutuhanInklusif)
                                                <span class="badge bg-info text-dark">{{ $mhs->kebutuhanInklusif->ragam_disabilitas }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="small">
                                            @if($mhs->no_hp) <div><i class="bi bi-telephone text-muted me-1"></i>{{ $mhs->no_hp }}</div> @endif
                                            @if($mhs->email) <div><i class="bi bi-envelope text-muted me-1"></i>{{ $mhs->email }}</div> @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Tidak ada data mahasiswa yang sesuai dengan filter.</td>
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
