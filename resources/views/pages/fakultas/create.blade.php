@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Fakultas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item"><a href="{{ route('fakultas.index') }}">Fakultas</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-building-add me-2 text-primary"></i>Form Tambah Fakultas Baru
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('fakultas.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <label for="nama_fakultas" class="col-sm-3 col-form-label fw-semibold">Nama Fakultas <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_fakultas" id="nama_fakultas" class="form-control @error('nama_fakultas') is-invalid @enderror" value="{{ old('nama_fakultas') }}" placeholder="Contoh: FAKULTAS SAINS DAN TEKNOLOGI (FST)" required autofocus>
                                @error('nama_fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Data
                                </button>
                                <a href="{{ route('fakultas.index') }}" class="btn btn-secondary">
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
