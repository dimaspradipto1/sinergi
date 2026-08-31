@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="fw-bold text-dark mb-0">Dashboard SINERGI PLD</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- Tanggal & Jam Realtime -->
    <div class="d-none d-md-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm border">
        <i class="bi bi-calendar-event text-primary me-2 fs-5"></i>
        <span class="fw-semibold text-secondary" id="realtimeClock">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">

    <!-- 1. Hero Welcome Banner Modern with Voice Assistant -->
    <div class="card border-0 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #0052d4 100%); border-radius: 16px;">
        <div class="card-body p-4 text-white position-relative">
            <!-- Background Watermark Icon -->
            <div class="position-absolute end-0 top-50 translate-middle-y opacity-10 pe-4 d-none d-lg-block pointer-events-none">
                <i class="bi bi-universal-access" style="font-size: 14rem; color: #ffffff;"></i>
            </div>

            <div class="row align-items-center position-relative z-1">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-white text-primary px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <i class="bi bi-shield-check me-1"></i> Role: {{ $user->role ?? 'User' }}
                        </span>
                        <span class="badge bg-info text-dark px-3 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                            Pusat Layanan Disabilitas
                        </span>
                    </div>

                    @php
                        $hour = date('H');
                        if ($hour < 11) {
                            $greeting = 'Selamat Pagi';
                        } elseif ($hour < 15) {
                            $greeting = 'Selamat Siang';
                        } elseif ($hour < 19) {
                            $greeting = 'Selamat Sore';
                        } else {
                            $greeting = 'Selamat Malam';
                        }
                    @endphp

                    <h2 class="fw-bold mb-2 fs-3 text-white">
                        {{ $greeting }}, {{ $user->name }}! 👋
                    </h2>
                    <p class="text-white-50 mb-3 fs-6" style="max-width: 620px;">
                        @if($role == 'superadmin')
                            Selamat datang di Pusat Kendali SINERGI PLD. Pantau seluruh master data, rekam medis inklusif, asesmen, dan performa pengguna sistem secara menyeluruh.
                        @elseif($role == 'pimpinan')
                            Selamat datang di Dashboard Eksekutif PLD. Akses ringkasan analitik strategis, sebaran disabilitas, capaian akademik, dan tingkat serapan kerja alumni.
                        @else
                            Selamat datang di Portal Operasional PLD. Kelola verifikasi mahasiswa baru, pelaksanaan asesmen, catatan akomodasi, dan pelacakan karier alumni.
                        @endif
                    </p>

                    <!-- Pintasan Cepat Sesuai Role -->
                    <div class="d-flex flex-wrap gap-2 pt-1">
                        @if($role == 'superadmin')
                            <a href="{{ route('pengguna.index') }}" class="btn btn-light btn-sm fw-semibold text-primary shadow-sm rounded-pill px-3">
                                <i class="bi bi-people me-1"></i> Kelola Pengguna
                            </a>
                            <a href="{{ route('export-data.index') }}" class="btn btn-outline-light btn-sm fw-semibold rounded-pill px-3">
                                <i class="bi bi-download me-1"></i> Export Center
                            </a>
                        @elseif($role == 'pimpinan')
                            <a href="{{ route('laporan-mahasiswa.index') }}" class="btn btn-light btn-sm fw-semibold text-primary shadow-sm rounded-pill px-3">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i> Laporan Mahasiswa
                            </a>
                            <a href="{{ route('laporan-tracer-study.index') }}" class="btn btn-outline-light btn-sm fw-semibold rounded-pill px-3">
                                <i class="bi bi-briefcase me-1"></i> Laporan Tracer
                            </a>
                        @else
                            <a href="{{ route('mahasiswa-baru.create') }}" class="btn btn-light btn-sm fw-semibold text-primary shadow-sm rounded-pill px-3">
                                <i class="bi bi-person-plus me-1"></i> Input MABA
                            </a>
                            <a href="{{ route('pelaksanaan-asesmen.create') }}" class="btn btn-outline-light btn-sm fw-semibold rounded-pill px-3">
                                <i class="bi bi-clipboard-check me-1"></i> Sesi Asesmen
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Voice Assistant Widget Box -->
                <div class="col-lg-4">
                    <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-white small d-flex align-items-center">
                                <i class="bi bi-mic-fill text-warning me-2 fs-5"></i> Voice Assistant PLD
                            </span>
                            <span class="badge bg-warning text-dark px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Aksesibilitas</span>
                        </div>
                        <p class="text-white-50 small mb-3" style="font-size: 0.8rem;">
                            Dengarkan ringkasan audio laporan statistik terkini secara otomatis (Text-to-Speech Ramah Disabilitas).
                        </p>

                        <div class="d-flex align-items-center gap-2">
                            <button type="button" id="btnSpeak" class="btn btn-warning text-dark btn-sm fw-bold px-3 rounded-pill flex-grow-1 shadow-sm d-flex align-items-center justify-content-center">
                                <i class="bi bi-volume-up-fill me-2 fs-6"></i>
                                <span id="speakBtnText">Dengarkan Ringkasan</span>
                            </button>
                            <button type="button" id="btnStopSpeak" class="btn btn-outline-light btn-sm rounded-circle d-none" title="Hentikan Suara" style="width: 34px; height: 34px;">
                                <i class="bi bi-stop-fill"></i>
                            </button>
                        </div>

                        <!-- Sound Wave Animation -->
                        <div id="soundWave" class="d-none mt-2 justify-content-center align-items-center gap-1 py-1">
                            <span class="wave-bar"></span>
                            <span class="wave-bar"></span>
                            <span class="wave-bar"></span>
                            <span class="wave-bar"></span>
                            <span class="wave-bar"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Row Kartu Statistik Utama (Role-Tailored) -->
    <div class="row">
        <!-- Total Mahasiswa Disabilitas -->
        <div class="col-xxl-3 col-md-6 mb-4">
            <div class="card info-card sales-card shadow-sm h-100 border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title p-0 m-0 fs-6 fw-semibold text-muted">Mahasiswa Terdaftar</h5>
                        <span class="badge bg-light text-primary border">Total</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalMahasiswa }}</h3>
                            <span class="text-muted small">L: {{ $totalMahasiswaLaki }} | P: {{ $totalMahasiswaPerempuan }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MABA Inklusif -->
        <div class="col-xxl-3 col-md-6 mb-4">
            <div class="card info-card revenue-card shadow-sm h-100 border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title p-0 m-0 fs-6 fw-semibold text-muted">Mahasiswa Baru (MABA)</h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">Tahun Ini</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalMaba }}</h3>
                            <span class="text-success small fw-bold">Pendaftar Inklusif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sesi Asesmen Selesai -->
        <div class="col-xxl-3 col-md-6 mb-4">
            <div class="card info-card customers-card shadow-sm h-100 border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title p-0 m-0 fs-6 fw-semibold text-muted">Asesmen Kompetensi</h5>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Rata Skor: {{ $avgSkorAsesmen }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff771d; background: #ffefe6;">
                            <i class="bi bi-clipboard2-check-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalAsesmen }}</h3>
                            <span class="text-muted small">{{ $totalAsesmenMandiri }} Mandiri / Optimal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelacakan Karir & Alumni Bekerja -->
        <div class="col-xxl-3 col-md-6 mb-4">
            <div class="card info-card shadow-sm h-100 border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title p-0 m-0 fs-6 fw-semibold text-muted">Alumni & Mitra Karir</h5>
                        <span class="badge bg-info-subtle text-info border border-info-subtle">{{ $totalPerusahaan }} Mitra</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0dcaf0; background: #e3f9fc;">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalAlumni }}</h3>
                            <span class="text-muted small">{{ $totalTracer }} Responden Tracer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Row Grafik Visual Interaktif ApexCharts -->
    <div class="row">
        <!-- Chart 1: Sebaran Ragam Disabilitas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>Sebaran Ragam Disabilitas Mahasiswa PLD
                    </h5>
                    <a href="{{ route('kebutuhan-inklusif.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                        Detail Inklusif
                    </a>
                </div>
                <div class="card-body pt-3">
                    <div id="disabilitasChart"></div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Status Karir Alumni & Serapan Industri -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-bar-chart-line-fill text-success me-2"></i>Distribusi Serapan Kerja Alumni di Industri
                    </h5>
                    <a href="{{ route('status-pekerjaan.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 0.75rem;">
                        Analitik Karir
                    </a>
                </div>
                <div class="card-body pt-3">
                    <div id="statusKerjaChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Row Tabel Aktivitas Terkini & Direktori Mitra -->
    <div class="row">
        <!-- Kolom Kiri: Sesi Asesmen & MABA Terbaru -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-clock-history text-primary me-2"></i>Aktivitas Asesmen Mahasiswa Terbaru
                    </h5>
                    <a href="{{ route('hasil-asesmen.index') }}" class="btn btn-sm btn-light border" style="font-size: 0.75rem;">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Instrumen</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAsesmens as $as)
                                    <tr>
                                        <td class="fw-semibold text-primary">{{ $as->mahasiswa->nim ?? '-' }}</td>
                                        <td class="fw-bold">{{ $as->mahasiswa->nama ?? '-' }}</td>
                                        <td class="small">{{ $as->mahasiswa->programStudi->program_studi ?? '-' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $as->instrumenAsesmen->nama_instrumen ?? '-' }}</span></td>
                                        <td class="text-center fw-bold">{{ number_format($as->nilai_total, 1) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary-subtle text-primary border">{{ $as->kategori ?: 'Selesai' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada aktivitas asesmen terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Mitra Industri & Capaian Prestasi -->
        <div class="col-lg-4 mb-4">
            <!-- Mitra Industri Inklusif -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-building text-warning me-2"></i>Mitra Industri Inklusif
                    </h5>
                    <a href="{{ route('perusahaan-mitra.index') }}" class="btn btn-sm btn-light border" style="font-size: 0.75rem;">
                        Semua Mitra
                    </a>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        @forelse($recentPerusahaans as $prs)
                            <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 fw-bold fs-6">{{ $prs->nama_perusahaan }}</h6>
                                    <small class="text-muted"><i class="bi bi-tag me-1"></i>{{ $prs->bidang }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $prs->karier_alumnis_count }} Alumni</span>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3 small">Belum ada mitra industri terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Prestasi Mahasiswa Disabilitas -->
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-trophy text-danger me-2"></i>Prestasi Mahasiswa PLD
                    </h5>
                    <a href="{{ route('prestasi.index') }}" class="btn btn-sm btn-light border" style="font-size: 0.75rem;">
                        Detail
                    </a>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        @forelse($recentPrestasis as $prs)
                            <div class="list-group-item px-0 py-2">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bold text-dark fs-6">{{ $prs->nama_prestasi }}</h6>
                                    <span class="badge bg-warning text-dark fw-bold">{{ $prs->peringkat }}</span>
                                </div>
                                <small class="text-muted d-block">{{ $prs->mahasiswa->nama ?? '-' }} ({{ $prs->tingkat }})</small>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3 small">Belum ada catatan prestasi terbaru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('styles')
<style>
/* Animasi Gelombang Suara (Sound Wave) */
.wave-bar {
    display: inline-block;
    width: 4px;
    height: 16px;
    background-color: #ffc107;
    border-radius: 4px;
    animation: waveAnimation 1.2s infinite ease-in-out;
}
.wave-bar:nth-child(1) { animation-delay: 0.0s; height: 10px; }
.wave-bar:nth-child(2) { animation-delay: 0.2s; height: 20px; }
.wave-bar:nth-child(3) { animation-delay: 0.4s; height: 15px; }
.wave-bar:nth-child(4) { animation-delay: 0.1s; height: 24px; }
.wave-bar:nth-child(5) { animation-delay: 0.3s; height: 12px; }

@keyframes waveAnimation {
    0%, 100% { transform: scaleY(0.4); }
    50% { transform: scaleY(1.2); }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    // 1. ApexChart - Sebaran Ragam Disabilitas
    const disabilitasLabels = {!! json_encode(array_keys($disabilitasDistribution)) !!};
    const disabilitasSeries = {!! json_encode(array_values($disabilitasDistribution)) !!};

    const disabilitasChart = new ApexCharts(document.querySelector("#disabilitasChart"), {
        series: disabilitasSeries.length > 0 ? disabilitasSeries : [1],
        labels: disabilitasLabels.length > 0 ? disabilitasLabels : ['Data Kosong'],
        chart: {
            type: 'donut',
            height: 320,
            toolbar: { show: false }
        },
        colors: ['#4154f1', '#2eca6a', '#ff771d', '#0dcaf0', '#e83e8c', '#6f42c1', '#fd7e14'],
        legend: {
            position: 'bottom',
            fontSize: '13px'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(1) + "%"
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 300 },
                legend: { position: 'bottom' }
            }
        }]
    });
    disabilitasChart.render();


    // 2. ApexChart - Distribusi Status Pekerjaan Alumni
    const statusLabels = {!! json_encode(array_keys($statusPekerjaanRaw)) !!};
    const statusSeries = {!! json_encode(array_values($statusPekerjaanRaw)) !!};

    const statusKerjaChart = new ApexCharts(document.querySelector("#statusKerjaChart"), {
        series: [{
            name: 'Jumlah Alumni',
            data: statusSeries.length > 0 ? statusSeries : [0]
        }],
        chart: {
            type: 'bar',
            height: 320,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                horizontal: true,
                distributed: true
            }
        },
        colors: ['#2eca6a', '#4154f1', '#ff771d', '#0dcaf0', '#6c757d'],
        xaxis: {
            categories: statusLabels.length > 0 ? statusLabels : ['Belum Ada Data'],
        },
        legend: { show: false },
        dataLabels: {
            enabled: true
        }
    });
    statusKerjaChart.render();


    // 3. Web Speech API (Text-to-Speech Ramah Disabilitas)
    const btnSpeak = document.getElementById('btnSpeak');
    const btnStopSpeak = document.getElementById('btnStopSpeak');
    const speakBtnText = document.getElementById('speakBtnText');
    const soundWave = document.getElementById('soundWave');

    // Naskah narasi suara yang ramah aksesibilitas
    const narrationText = `Halo {{ $user->name }}, {{ $greeting }}. Anda masuk ke Sistem Informasi Layanan Disabilitas SINERGI sebagai {{ $user->role ?? 'Pengguna' }}. ` +
        `Berikut adalah ringkasan data saat ini: ` +
        `Total mahasiswa disabilitas terdaftar sebanyak {{ $totalMahasiswa }} orang, dengan {{ $totalMaba }} orang mahasiswa baru. ` +
        `Telah terlaksana {{ $totalAsesmen }} sesi asesmen kompetensi dengan rata-rata skor {{ $avgSkorAsesmen }}. ` +
        `Sebanyak {{ $totalAlumni }} alumni disabilitas telah lulus, dan saat ini universitas telah bermitra dengan {{ $totalPerusahaan }} perusahaan penyerap tenaga kerja inklusif. ` +
        `Semua sistem berfungsi secara normal. Terima kasih.`;

    if ('speechSynthesis' in window) {
        let isSpeaking = false;
        let utterance = null;

        btnSpeak.addEventListener('click', () => {
            if (!isSpeaking) {
                window.speechSynthesis.cancel(); // Reset previous speech
                utterance = new SpeechSynthesisUtterance(narrationText);
                utterance.lang = 'id-ID';
                utterance.rate = 1.0;
                utterance.pitch = 1.0;

                // Ambil daftar suara jika tersedia suara bahasa Indonesia
                const voices = window.speechSynthesis.getVoices();
                const indonesianVoice = voices.find(voice => voice.lang.includes('id') || voice.lang.includes('ID'));
                if (indonesianVoice) {
                    utterance.voice = indonesianVoice;
                }

                utterance.onstart = () => {
                    isSpeaking = true;
                    speakBtnText.textContent = "Sedang Membacakan...";
                    btnStopSpeak.classList.remove('d-none');
                    soundWave.classList.remove('d-none');
                    soundWave.classList.add('d-flex');
                };

                utterance.onend = () => {
                    resetSpeechUi();
                };

                utterance.onerror = () => {
                    resetSpeechUi();
                };

                window.speechSynthesis.speak(utterance);
            } else {
                window.speechSynthesis.cancel();
                resetSpeechUi();
            }
        });

        btnStopSpeak.addEventListener('click', () => {
            window.speechSynthesis.cancel();
            resetSpeechUi();
        });

        function resetSpeechUi() {
            isSpeaking = false;
            speakBtnText.textContent = "Dengarkan Ringkasan";
            btnStopSpeak.classList.add('d-none');
            soundWave.classList.add('d-none');
            soundWave.classList.remove('d-flex');
        }

    } else {
        btnSpeak.disabled = true;
        speakBtnText.textContent = "Audio Tidak Didukung";
    }

});
</script>
@endpush