@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Transkrip & Rincian IP / IPK</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Akademik & Penilaian</li>
                <li class="breadcrumb-item"><a href="{{ route('ip-ipk.index') }}">IP & IPK</a></li>
                <li class="breadcrumb-item active">Rincian Mahasiswa</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <a href="{{ route('ip-ipk.index') }}" class="btn btn-secondary btn-sm me-1">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak Transkrip
        </button>
    </div>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0">
                <!-- Header Transkrip -->
                <div class="card-header bg-white border-bottom py-4 text-center">
                    <h4 class="fw-bold mb-1 text-primary">PUSAT LAYANAN DISABILITAS (PLD)</h4>
                    <h6 class="text-secondary fw-semibold mb-0">TRANSKRIP NILAI & HISTORI AKADEMIK MAHASISWA</h6>
                </div>

                <div class="card-body p-4">
                    <!-- Biodata Mahasiswa -->
                    <div class="row mb-4 bg-light p-3 rounded">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <th width="150" class="text-muted">NIM</th>
                                    <td class="fw-bold">{{ $mahasiswa->nim }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Nama Lengkap</th>
                                    <td class="fw-bold text-primary">{{ $mahasiswa->nama }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Program Studi</th>
                                    <td>{{ $mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Fakultas</th>
                                    <td>{{ $mahasiswa->programStudi->fakultas->nama_fakultas ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <th width="160" class="text-muted">Tahun Angkatan</th>
                                    <td>{{ $mahasiswa->tahunAkademik->tahun_akademik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Total SKS Diambil</th>
                                    <td><span class="badge bg-secondary fs-6">{{ $totalSksKumulatif }} SKS</span></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">IPK Kumulatif</th>
                                    <td>
                                        <span class="badge bg-success fs-5 fw-bold">{{ number_format($ipk, 2) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Rekapitulasi per Semester -->
                    @forelse($rekapSemester as $rekap)
                        <div class="card border mb-4">
                            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">
                                    <i class="bi bi-calendar3 me-2 text-primary"></i>T.A {{ $rekap['krs']->tahun_akademik }} - Semester {{ $rekap['krs']->semester }}
                                </span>
                                <div>
                                    <span class="badge bg-light text-dark border me-2">SKS: {{ $rekap['sks_semester'] }} SKS</span>
                                    <span class="badge bg-primary">IP Semester: {{ number_format($rekap['ips'], 2) }}</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50" class="text-center">No</th>
                                                <th width="120">Kode Matkul</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th width="80" class="text-center">SKS</th>
                                                <th width="100" class="text-center">Nilai Angka</th>
                                                <th width="100" class="text-center">Nilai Huruf</th>
                                                <th width="80" class="text-center">Bobot</th>
                                                <th width="90" class="text-center">Mutu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rekap['krs']->nilaiMahasiswas as $index => $nilai)
                                                @php
                                                    $sks = $nilai->mataKuliah->sks ?? 0;
                                                    $bobot = $nilai->bobot;
                                                    $mutu = $sks * $bobot;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="fw-semibold">{{ $nilai->mataKuliah->kode_matkul ?? '-' }}</td>
                                                    <td>{{ $nilai->mataKuliah->nama_matkul ?? '-' }}</td>
                                                    <td class="text-center">{{ $sks }}</td>
                                                    <td class="text-center">{{ number_format($nilai->nilai_angka, 1) }}</td>
                                                    <td class="text-center fw-bold text-primary">{{ $nilai->nilai_huruf }}</td>
                                                    <td class="text-center">{{ number_format($bobot, 1) }}</td>
                                                    <td class="text-center fw-bold">{{ number_format($mutu, 1) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-2">Belum ada mata kuliah yang diambil pada semester ini.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-circle me-2"></i>Mahasiswa ini belum memiliki data KRS atau nilai akademik.
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
