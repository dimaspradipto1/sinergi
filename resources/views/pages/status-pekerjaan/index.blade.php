@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Status Pekerjaan Alumni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pelacakan Karir</li>
            <li class="breadcrumb-item active">Status Pekerjaan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Row Statistik Angka (NiceAdmin clean card style) -->
    <div class="row">
        <!-- Total Alumni -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Alumni</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAlumni }}</h6>
                            <span class="text-muted small pt-2 ps-1">Alumni Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Responden Tracer -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Responden Survey</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalTracer }}</h6>
                            <span class="text-muted small pt-2 ps-1">Data Tracer Study</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Masa Tunggu -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Masa Tunggu</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff771d; background: #ffefe6;">
                            <i class="bi bi-hourglass-bottom"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($avgWaktuTunggu, 1) }}</h6>
                            <span class="text-muted small pt-2 ps-1">Bulan Mendapat Kerja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relevansi Bidang Studi -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kesesuaian Bidang</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0dcaf0; background: #e3f9fc;">
                            <i class="bi bi-check2-all"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($avgRelevansi, 1) }}%</h6>
                            <span class="text-muted small pt-2 ps-1">Relevansi Studi PLD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Visualisasi Charts -->
    <div class="row">
        <!-- Distribusi Status Pekerjaan -->
        <div class="col-lg-7 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Distribusi Status Pekerjaan Alumni
                    </h5>
                </div>
                <div class="card-body pt-3">
                    @if(count($statusDistribution) > 0)
                        <div id="statusPekerjaanChart"></div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data tracer study untuk ditampilkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Distribusi Pendapatan -->
        <div class="col-lg-5 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-bar-chart me-2 text-primary"></i>Tingkat Pendapatan Bulanan
                    </h5>
                </div>
                <div class="card-body pt-3">
                    @if(count($pendapatanDistribution) > 0)
                        <div id="pendapatanChart"></div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data pendapatan untuk ditampilkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Responden Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Survey Tracer Study Terbaru
                    </h5>
                    <a href="{{ route('tracer-study.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Seluruh Data <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Alumni</th>
                                    <th>Program Studi</th>
                                    <th>Tahun Survey</th>
                                    <th>Status Pekerjaan</th>
                                    <th>Masa Tunggu</th>
                                    <th>Relevansi</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTracers as $index => $tr)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $tr->alumni->mahasiswa->nim ?? '-' }}</td>
                                        <td>{{ $tr->alumni->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $tr->alumni->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $tr->tahun_survey }}</td>
                                        <td><span class="badge bg-primary">{{ $tr->status_pekerjaan }}</span></td>
                                        <td class="text-center">{{ $tr->waktu_tunggu }} Bulan</td>
                                        <td class="text-center"><span class="badge bg-success">{{ $tr->relevansi_bidang }}%</span></td>
                                        <td class="fw-semibold text-primary">{{ $tr->pendapatan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data tracer study.</td>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    @if(count($statusDistribution) > 0)
    // Donut Chart Status Pekerjaan
    new ApexCharts(document.querySelector("#statusPekerjaanChart"), {
        series: {!! json_encode(array_values($statusDistribution)) !!},
        labels: {!! json_encode(array_keys($statusDistribution)) !!},
        chart: {
            type: 'donut',
            height: 320,
            toolbar: { show: false }
        },
        colors: ['#4154f1', '#2eca6a', '#ff771d', '#0dcaf0', '#6c757d', '#dc3545'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(1) + "%"
            }
        }
    }).render();
    @endif

    @if(count($pendapatanDistribution) > 0)
    // Bar Chart Pendapatan
    new ApexCharts(document.querySelector("#pendapatanChart"), {
        series: [{
            name: 'Jumlah Alumni',
            data: {!! json_encode(array_values($pendapatanDistribution)) !!}
        }],
        chart: {
            type: 'bar',
            height: 320,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        colors: ['#2eca6a'],
        xaxis: {
            categories: {!! json_encode(array_keys($pendapatanDistribution)) !!},
        },
        dataLabels: {
            enabled: true
        }
    }).render();
    @endif
});
</script>
@endpush
