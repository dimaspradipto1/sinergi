@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pemetaan Kompetensi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item active">Pemetaan Kompetensi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center mb-4 py-2 px-3">
        <i class="bi bi-diagram-3-fill fs-4 text-primary me-3"></i>
        <div>
            <strong>Analisis & Pemetaan Profil Kompetensi Mahasiswa PLD:</strong>
            <div class="small text-muted">Visualisasi distribusi capaian kompetensi, rata-rata nilai per instrumen, dan matriks pemetaan kebutuhan pendampingan lanjutan.</div>
        </div>
    </div>

    <!-- 3 Stat Summary Cards -->
    <div class="row mb-2">
        <!-- Total Sesi Asesmen -->
        <div class="col-md-4">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Sesi Asesmen <span>| Semua</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-clipboard2-check"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAsesmen }}</h6>
                            <span class="text-muted small pt-2">Sesi asesmen selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Terasesmen -->
        <div class="col-md-4">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mahasiswa Terasesmen <span>| Unik</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalMahasiswaTerasesmen }}</h6>
                            <span class="text-muted small pt-2">Mahasiswa terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Katalog Instrumen -->
        <div class="col-md-4">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Katalog Instrumen <span>| Aktif</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalInstrumen }}</h6>
                            <span class="text-muted small pt-2">Jenis instrumen</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Bar Chart: Rata-Rata Skor per Instrumen -->
        <div class="col-lg-7 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0 p-0 fs-6 fw-bold text-dark">
                        <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>Rata-Rata Skor per Instrumen Asesmen
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div id="chart-skor-instrumen" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Donut Chart: Distribusi Kategori Capaian -->
        <div class="col-lg-5 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0 p-0 fs-6 fw-bold text-dark">
                        <i class="bi bi-pie-chart-fill me-2 text-primary"></i>Distribusi Capaian Kompetensi
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div id="chart-distribusi-kategori" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matriks & Riwayat Terkini -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0 p-0 fs-6 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Asesmen Kompetensi Terbaru
                    </h6>
                    <a href="{{ route('hasil-asesmen.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Seluruh Hasil <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Instrumen</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Skor</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatAsesmen as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item->mahasiswa->nim ?? '-' }}</td>
                                        <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $item->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td><span class="text-primary fw-semibold">{{ $item->instrumenAsesmen->nama_instrumen ?? '-' }}</span></td>
                                        <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                                        <td class="text-center fw-bold text-primary">{{ number_format($item->nilai_total, 1) }}</td>
                                        <td class="text-center">
                                            @php
                                                $kat = strtolower($item->kategori ?? '');
                                                $badgeClass = 'bg-secondary';
                                                if (str_contains($kat, 'sangat') || str_contains($kat, 'mahir')) $badgeClass = 'bg-success';
                                                elseif (str_contains($kat, 'kompeten') || str_contains($kat, 'baik')) $badgeClass = 'bg-info text-dark';
                                                elseif (str_contains($kat, 'cukup')) $badgeClass = 'bg-warning text-dark';
                                                elseif (str_contains($kat, 'perlu') || str_contains($kat, 'kurang')) $badgeClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $item->kategori ?: 'Belum Dinilai' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('hasil-asesmen.show', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Rapor">
                                                <i class="bi bi-file-earmark-bar-graph"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-3">Belum ada riwayat pelaksanaan asesmen.</td>
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

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Data Bar Chart Skor per Instrumen
        const instrumenLabels = {!! json_encode($skorPerInstrumen->pluck('nama_instrumen')) !!};
        const instrumenScores = {!! json_encode($skorPerInstrumen->pluck('rata_rata')->map(fn($v) => round($v, 1))) !!};

        new ApexCharts(document.querySelector("#chart-skor-instrumen"), {
            series: [{
                name: 'Rata-Rata Skor',
                data: instrumenScores.length > 0 ? instrumenScores : [0]
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: false,
                    columnWidth: '45%',
                }
            },
            dataLabels: {
                enabled: true
            },
            colors: ['#4154f1'],
            xaxis: {
                categories: instrumenLabels.length > 0 ? instrumenLabels : ['Belum Ada Data'],
            },
            yaxis: {
                title: { text: 'Skor' }
            }
        }).render();

        // Data Donut Chart Distribusi Kategori
        const kategoriLabels = {!! json_encode($kategoriDistribusi->pluck('kategori')->map(fn($v) => $v ?: 'Belum Dinilai')) !!};
        const kategoriCounts = {!! json_encode($kategoriDistribusi->pluck('total')) !!};

        new ApexCharts(document.querySelector("#chart-distribusi-kategori"), {
            series: kategoriCounts.length > 0 ? kategoriCounts : [1],
            chart: {
                type: 'donut',
                height: 320,
                toolbar: { show: false }
            },
            labels: kategoriLabels.length > 0 ? kategoriLabels : ['Belum Ada Data'],
            colors: ['#2eca6a', '#17a2b8', '#ffc107', '#dc3545', '#6c757d'],
            legend: {
                position: 'bottom'
            }
        }).render();
    });
</script>
@endpush
