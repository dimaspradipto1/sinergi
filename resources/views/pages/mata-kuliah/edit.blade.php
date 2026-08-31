@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Mata Kuliah</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik & Penilaian</li>
            <li class="breadcrumb-item"><a href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Mata Kuliah
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('mata-kuliah.update', $mataKuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kode_matkul" class="form-label fw-semibold">Kode Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" name="kode_matkul" id="kode_matkul" class="form-control @error('kode_matkul') is-invalid @enderror" value="{{ old('kode_matkul', $mataKuliah->kode_matkul) }}" placeholder="Contoh: IF101 / MKB202" required>
                                @error('kode_matkul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sks" class="form-label fw-semibold">Bobot SKS <span class="text-danger">*</span></label>
                                <input type="number" name="sks" id="sks" min="1" max="10" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', $mataKuliah->sks) }}" placeholder="Contoh: 2, 3, 4" required>
                                @error('sks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_matkul" class="form-label fw-semibold">Nama Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_matkul" id="nama_matkul" class="form-control @error('nama_matkul') is-invalid @enderror" value="{{ old('nama_matkul', $mataKuliah->nama_matkul) }}" placeholder="Contoh: Pemrograman Web Lanjut" required>
                            @error('nama_matkul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="semester" class="form-label fw-semibold">Semester Ditawarkan <span class="text-danger">*</span></label>
                            <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('semester', $mataKuliah->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Mata Kuliah
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
