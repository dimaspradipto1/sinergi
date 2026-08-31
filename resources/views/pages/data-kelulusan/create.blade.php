@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Data Kelulusan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Kelulusan</li>
            <li class="breadcrumb-item"><a href="{{ route('data-kelulusan.index') }}">Data Kelulusan</a></li>
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
                        <i class="bi bi-mortarboard me-2 text-primary"></i>Form Tambah Data Kelulusan Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('data-kelulusan.store') }}" method="POST">
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomor_sk_yudisium" class="form-label fw-semibold">Nomor SK Yudisium <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_sk_yudisium" id="nomor_sk_yudisium" class="form-control @error('nomor_sk_yudisium') is-invalid @enderror" value="{{ old('nomor_sk_yudisium') }}" placeholder="Contoh: 128/UN.PLD/SK/2026" required>
                                @error('nomor_sk_yudisium')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_sk_yudisium" class="form-label fw-semibold">Tanggal SK Yudisium <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_sk_yudisium" id="tanggal_sk_yudisium" class="form-control @error('tanggal_sk_yudisium') is-invalid @enderror" value="{{ old('tanggal_sk_yudisium', date('Y-m-d')) }}" required>
                                @error('tanggal_sk_yudisium')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tanggal_lulus" class="form-label fw-semibold">Tanggal Resmi Lulus <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lulus" id="tanggal_lulus" class="form-control @error('tanggal_lulus') is-invalid @enderror" value="{{ old('tanggal_lulus', date('Y-m-d')) }}" required>
                                @error('tanggal_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="ipk_kelulusan" class="form-label fw-semibold">IPK Kelulusan (0 - 4.00) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="4" name="ipk_kelulusan" id="ipk_kelulusan" class="form-control @error('ipk_kelulusan') is-invalid @enderror" value="{{ old('ipk_kelulusan') }}" placeholder="Contoh: 3.85" required>
                                @error('ipk_kelulusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="predikat" class="form-label fw-semibold">Predikat Kelulusan <span class="text-danger">*</span></label>
                                <select name="predikat" id="predikat" class="form-select @error('predikat') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('predikat') ? '' : 'selected' }}>-- Pilih Predikat --</option>
                                    @foreach($predikatList as $pred)
                                        <option value="{{ $pred }}" {{ old('predikat') == $pred ? 'selected' : '' }}>{{ $pred }}</option>
                                    @endforeach
                                </select>
                                @error('predikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="judul_tugas_akhir" class="form-label fw-semibold">Judul Tugas Akhir / Skripsi / Proyek Akhir</label>
                            <textarea name="judul_tugas_akhir" id="judul_tugas_akhir" rows="3" class="form-control @error('judul_tugas_akhir') is-invalid @enderror" placeholder="Tuliskan judul skripsi, tesis, atau tugas akhir mahasiswa">{{ old('judul_tugas_akhir') }}</textarea>
                            @error('judul_tugas_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('data-kelulusan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Data Kelulusan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
