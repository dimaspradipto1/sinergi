@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Prestasi Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik & Penilaian</li>
            <li class="breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi</a></li>
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
                        <i class="bi bi-trophy me-2 text-primary"></i>Form Tambah Prestasi Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('prestasi.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Pilih Mahasiswa --" required>
                                <option value="" disabled {{ old('mahasiswa_id') ? '' : 'selected' }}>-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                        {{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->programStudi->program_studi ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label fw-semibold">Nama Prestasi / Penghargaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control @error('nama_prestasi') is-invalid @enderror" value="{{ old('nama_prestasi') }}" placeholder="Contoh: Juara 1 Lomba Catur Difabel Nasional / Best Paper PKM" required>
                            @error('nama_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tingkat" class="form-label fw-semibold">Tingkat Prestasi <span class="text-danger">*</span></label>
                                <select name="tingkat" id="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('tingkat') ? '' : 'selected' }}>-- Pilih Tingkat --</option>
                                    @foreach($tingkatList as $tingkat)
                                        <option value="{{ $tingkat }}" {{ old('tingkat') == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                                    @endforeach
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tahun" class="form-label fw-semibold">Tahun Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" id="tahun" min="1990" max="{{ date('Y') + 1 }}" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" placeholder="Contoh: {{ date('Y') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Prestasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
