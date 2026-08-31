@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Hasil Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item active">Hasil Asesmen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3 py-2 px-3">
        <i class="bi bi-file-earmark-bar-graph fs-4 text-success me-3"></i>
        <div>
            <strong>Rekapitulasi & Rapor Hasil Asesmen Mahasiswa:</strong>
            <div class="small text-muted">Tinjau nilai capaian akhir, kategori kompetensi, dan cetak rapor hasil asesmen per mahasiswa.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-trophy me-2 text-primary"></i>Daftar Rekapitulasi Hasil Asesmen
                        </h5>
                        <small class="text-muted">Capaian skor kompetensi mahasiswa berdasarkan instrumen</small>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'hasilasesmen-table']) !!}
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
