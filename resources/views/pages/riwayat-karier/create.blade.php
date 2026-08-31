@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Riwayat Karier</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pelacakan Karir</li>
            <li class="breadcrumb-item"><a href="{{ route('riwayat-karier.index') }}">Riwayat Karier</a></li>
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
                        <i class="bi bi-briefcase me-2 text-primary"></i>Form Tambah Riwayat Karier Alumni
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('riwayat-karier.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Alumni -->
                        <div class="mb-3">
                            <label for="alumni_id" class="form-label fw-semibold">Alumni <span class="text-danger">*</span></label>
                            <select name="alumni_id" id="alumni_id" class="form-select select2 @error('alumni_id') is-invalid @enderror" data-placeholder="-- Pilih Alumni --" required>
                                <option value="" disabled {{ old('alumni_id') ? '' : 'selected' }}>-- Pilih Alumni --</option>
                                @foreach($alumni as $alm)
                                    <option value="{{ $alm->id }}" {{ old('alumni_id') == $alm->id ? 'selected' : '' }}>
                                        {{ $alm->mahasiswa->nim ?? '-' }} - {{ $alm->mahasiswa->nama ?? '-' }} (Lulus: {{ $alm->tahun_lulus }})
                                    </option>
                                @endforeach
                            </select>
                            @error('alumni_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="perusahaan_id" class="form-label fw-semibold">Perusahaan / Instansi Mitra <span class="text-danger">*</span></label>
                                <select name="perusahaan_id" id="perusahaan_id" class="form-select select2 @error('perusahaan_id') is-invalid @enderror" data-placeholder="-- Pilih Perusahaan --" required>
                                    <option value="" disabled {{ old('perusahaan_id') ? '' : 'selected' }}>-- Pilih Perusahaan / Instansi --</option>
                                    @foreach($perusahaan as $prs)
                                        <option value="{{ $prs->id }}" {{ old('perusahaan_id') == $prs->id ? 'selected' : '' }}>
                                            {{ $prs->nama_perusahaan }} ({{ $prs->bidang }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('perusahaan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jabatan" class="form-label fw-semibold">Jabatan / Posisi Kerja <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" placeholder="Contoh: Frontend Developer / Staff Administrasi" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai Bekerja <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_kerja" class="form-label fw-semibold">Status Hubungan Kerja <span class="text-danger">*</span></label>
                                <select name="status_kerja" id="status_kerja" class="form-select @error('status_kerja') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('status_kerja') ? '' : 'selected' }}>-- Pilih Status Kerja --</option>
                                    @foreach($statusKerjaList as $sk)
                                        <option value="{{ $sk }}" {{ old('status_kerja') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                                    @endforeach
                                </select>
                                @error('status_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('riwayat-karier.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Riwayat Karier
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
