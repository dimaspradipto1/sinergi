@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Program Studi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}">Program Studi</a></li>
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
                        <i class="bi bi-mortarboard-fill me-2 text-primary"></i>Form Tambah Program Studi Baru
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('program-studi.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label for="fakultas_id" class="col-sm-3 col-form-label fw-semibold">Fakultas <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="fakultas_id" id="fakultas_id" class="form-select @error('fakultas_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('fakultas_id') ? '' : 'selected' }}>-- Pilih Fakultas --</option>
                                    @foreach($fakultas as $item)
                                        <option value="{{ $item->id }}" {{ old('fakultas_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fakultas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="program_studi" class="col-sm-3 col-form-label fw-semibold">Nama Program Studi <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="program_studi" id="program_studi" class="form-control @error('program_studi') is-invalid @enderror" value="{{ old('program_studi') }}" placeholder="Contoh: S1-TEKNIK INFORMATIKA" required>
                                @error('program_studi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Data
                                </button>
                                <a href="{{ route('program-studi.index') }}" class="btn btn-secondary">
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
