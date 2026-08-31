@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Monitoring Alumni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pelacakan Karir</li>
            <li class="breadcrumb-item active">Monitoring Alumni</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <!-- Stat Cards Monitoring -->
    <div class="row mb-3">
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

        <!-- Sudah Tracer -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Telah Terdata Tracer</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalSudahTracer }}</h6>
                            <span class="text-success small pt-1 fw-bold">{{ $persenTracer }}%</span> <span class="text-muted small pt-2 ps-1">Partisipasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Tracer -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Belum Mengisi Survey</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff771d; background: #ffefe6;">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalBelumTracer }}</h6>
                            <span class="text-muted small pt-2 ps-1">Perlu Dihubungi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akselerasi Karir -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Aksi Cepat</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0dcaf0; background: #e3f9fc;">
                            <i class="bi bi-send"></i>
                        </div>
                        <div class="ps-3">
                            <a href="{{ route('tracer-study.create') }}" class="btn btn-sm btn-primary mt-1">
                                <i class="bi bi-plus-lg me-1"></i> Input Tracer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables Monitoring Alumni -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-binoculars me-2 text-primary"></i>Tabel Monitoring & Kontak Alumni
                        </h5>
                        <small class="text-muted">Pantau perkembangan status pekerjaan alumni serta hubungi via WhatsApp/Email langsung</small>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'monitoringalumni-table']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
