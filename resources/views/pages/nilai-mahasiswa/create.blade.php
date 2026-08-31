@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Input Nilai Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik & Penilaian</li>
            <li class="breadcrumb-item"><a href="{{ route('nilai-mahasiswa.index') }}">Nilai Mahasiswa</a></li>
            <li class="breadcrumb-item active">Input Nilai</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-award me-2 text-primary"></i>Form Input Nilai Mata Kuliah
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('nilai-mahasiswa.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Mahasiswa / KRS -->
                        <div class="mb-3">
                            <label for="krs_id" class="form-label fw-semibold">Mahasiswa & Periode KRS <span class="text-danger">*</span></label>
                            <select name="krs_id" id="krs_id" class="form-select select2 @error('krs_id') is-invalid @enderror" data-placeholder="-- Pilih Mahasiswa & KRS --" required>
                                <option value="" disabled {{ old('krs_id') ? '' : 'selected' }}>-- Pilih Mahasiswa & KRS --</option>
                                @foreach($krsList as $krs)
                                    <option value="{{ $krs->id }}" {{ old('krs_id') == $krs->id ? 'selected' : '' }}>
                                        {{ $krs->mahasiswa->nim ?? '' }} - {{ $krs->mahasiswa->nama ?? '' }} | T.A: {{ $krs->tahun_akademik }} (Semester {{ $krs->semester }})
                                    </option>
                                @endforeach
                            </select>
                            @error('krs_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilihan Mata Kuliah -->
                        <div class="mb-3">
                            <label for="mata_kuliah_id" class="form-label fw-semibold">Mata Kuliah <span class="text-danger">*</span></label>
                            <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-select select2 @error('mata_kuliah_id') is-invalid @enderror" data-placeholder="-- Pilih Mata Kuliah --" required>
                                <option value="" disabled {{ old('mata_kuliah_id') ? '' : 'selected' }}>-- Pilih Mata Kuliah --</option>
                                @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->id }}" {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->kode_matkul }} - {{ $mk->nama_matkul }} ({{ $mk->sks }} SKS / Sem {{ $mk->semester }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_kuliah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nilai_angka" class="form-label fw-semibold">Nilai Angka (0 - 100) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="nilai_angka" id="nilai_angka" class="form-control @error('nilai_angka') is-invalid @enderror" value="{{ old('nilai_angka') }}" placeholder="Contoh: 85.5" required>
                                @error('nilai_angka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nilai_huruf" class="form-label fw-semibold">Nilai Huruf (Opsional / Otomatis)</label>
                                <select name="nilai_huruf" id="nilai_huruf" class="form-select @error('nilai_huruf') is-invalid @enderror">
                                    <option value="">-- Otomatis Berdasarkan Nilai Angka --</option>
                                    <option value="A" {{ old('nilai_huruf') == 'A' ? 'selected' : '' }}>A (4.0)</option>
                                    <option value="B+" {{ old('nilai_huruf') == 'B+' ? 'selected' : '' }}>B+ (3.5)</option>
                                    <option value="B" {{ old('nilai_huruf') == 'B' ? 'selected' : '' }}>B (3.0)</option>
                                    <option value="C+" {{ old('nilai_huruf') == 'C+' ? 'selected' : '' }}>C+ (2.5)</option>
                                    <option value="C" {{ old('nilai_huruf') == 'C' ? 'selected' : '' }}>C (2.0)</option>
                                    <option value="D" {{ old('nilai_huruf') == 'D' ? 'selected' : '' }}>D (1.0)</option>
                                    <option value="E" {{ old('nilai_huruf') == 'E' ? 'selected' : '' }}>E (0.0)</option>
                                </select>
                                <small class="text-muted">Biarkan otomatis atau tentukan secara manual.</small>
                                @error('nilai_huruf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('nilai-mahasiswa.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Nilai
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
