@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Rapor Hasil Asesmen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Asesmen Kompetensi</li>
                <li class="breadcrumb-item"><a href="{{ route('hasil-asesmen.index') }}">Hasil Asesmen</a></li>
                <li class="breadcrumb-item active">Rapor</li>
            </ol>
        </nav>
    </div>
    <div class="d-print-none">
        <a href="{{ route('hasil-asesmen.index') }}" class="btn btn-secondary btn-sm me-1">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak Rapor
        </button>
    </div>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0" id="rapor-card">
                <!-- Header Rapor -->
                <div class="card-header bg-white border-bottom py-4 text-center">
                    <h4 class="fw-bold mb-1 text-primary">PUSAT LAYANAN DISABILITAS (PLD)</h4>
                    <h6 class="text-secondary fw-semibold mb-0">RAPOR HASIL ASESMEN KOMPETENSI MAHASISWA</h6>
                </div>

                <div class="card-body p-4">
                    <!-- Biodata Mahasiswa & Asesmen -->
                    <div class="row mb-4 bg-light p-3 rounded">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <th width="150" class="text-muted">NIM</th>
                                    <td class="fw-bold">{{ $asesmen->mahasiswa->nim ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Nama Mahasiswa</th>
                                    <td class="fw-bold text-primary">{{ $asesmen->mahasiswa->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Program Studi</th>
                                    <td>{{ $asesmen->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Fakultas</th>
                                    <td>{{ $asesmen->mahasiswa->programStudi->fakultas->fakultas ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <th width="160" class="text-muted">Instrumen Asesmen</th>
                                    <td class="fw-bold text-dark">{{ $asesmen->instrumenAsesmen->nama_instrumen ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Kategori Instrumen</th>
                                    <td><span class="badge bg-secondary">{{ $asesmen->instrumenAsesmen->kategori ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tanggal Ujian</th>
                                    <td>{{ $asesmen->tanggal ? $asesmen->tanggal->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Capaian Akhir</th>
                                    <td>
                                        <span class="badge bg-success fs-6">{{ $asesmen->kategori ?? 'Belum Dinilai' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Highlight Skor Akhir -->
                    <div class="row mb-4 text-center">
                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3 bg-white shadow-xs">
                                <span class="text-muted small d-block">TOTAL SKOR PENILAIAN</span>
                                <h2 class="fw-bold text-primary mb-0">{{ number_format($asesmen->nilai_total, 1) }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3 bg-white shadow-xs">
                                <span class="text-muted small d-block">JUMLAH BUTIR SOAL</span>
                                <h2 class="fw-bold text-secondary mb-0">{{ count($asesmen->jawabanAsesmens) }} Soal</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3 bg-white shadow-xs">
                                <span class="text-muted small d-block">STATUS KOMPETENSI</span>
                                <h5 class="fw-bold text-success mt-2 mb-0">{{ $asesmen->kategori ?? '-' }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Rincian Butir Pertanyaan & Jawaban -->
                    <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="bi bi-list-check me-2 text-primary"></i>Rincian Nilai Per Butir Pertanyaan
                    </h6>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th>Butir Pertanyaan / Indikator Asesmen</th>
                                    <th>Format Jawaban</th>
                                    <th>Jawaban / Respon</th>
                                    <th width="100" class="text-center">Skor Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asesmen->jawabanAsesmens as $index => $item)
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                        <td>{{ $item->pertanyaanAsesmen->pertanyaan ?? '-' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $item->pertanyaanAsesmen->tipe_jawaban ?? '-' }}</span></td>
                                        <td>{{ $item->jawaban ?: '-' }}</td>
                                        <td class="text-center fw-bold text-primary">{{ $item->skor }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada rincian jawaban.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="4" class="text-end">TOTAL NILAI:</td>
                                    <td class="text-center text-primary fs-6">{{ number_format($asesmen->nilai_total, 1) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Catatan & Rekomendasi Asesor -->
                    <div class="border rounded p-3 bg-light mb-4">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-chat-left-quote me-2 text-primary"></i>Catatan & Rekomendasi Asesor:
                        </h6>
                        <p class="mb-0 text-muted fst-italic">
                            {{ $asesmen->catatan_asesor ?: 'Tidak ada catatan khusus dari asesor.' }}
                        </p>
                    </div>

                    <!-- Tanda Tangan Cetak -->
                    <div class="row mt-5 pt-3 d-none d-print-flex">
                        <div class="col-6 text-center">
                            <p class="mb-5">Mahasiswa Yang Bersangkutan,</p>
                            <p class="fw-bold mb-0 text-decoration-underline">{{ $asesmen->mahasiswa->nama ?? '' }}</p>
                            <p class="small text-muted">NIM: {{ $asesmen->mahasiswa->nim ?? '' }}</p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="mb-1">Tanggal Cetak: {{ date('d F Y') }}</p>
                            <p class="mb-5">Tim Asesor PLD,</p>
                            <p class="fw-bold mb-0 text-decoration-underline">Pusat Layanan Disabilitas</p>
                            <p class="small text-muted">Universitas</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
