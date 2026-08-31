@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Tahun Akademik</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item"><a href="{{ route('tahun-akademik.index') }}">Tahun Akademik</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-calendar-plus me-2 text-primary"></i>Form Tambah Tahun Akademik Baru
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('tahun-akademik.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <label for="tahun_akademik" class="col-sm-3 col-form-label fw-semibold">Tahun Akademik <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control @error('tahun_akademik') is-invalid @enderror" value="{{ old('tahun_akademik') }}" placeholder="Contoh: 2026/2027 Ganjil atau 2026/2027" required autofocus>
                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Data
                                </button>
                                <a href="{{ route('tahun-akademik.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
