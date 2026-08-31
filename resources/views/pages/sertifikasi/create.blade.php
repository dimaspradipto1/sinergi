@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Sertifikasi Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik & Penilaian</li>
            <li class="breadcrumb-item"><a href="{{ route('sertifikasi.index') }}">Sertifikasi</a></li>
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
                        <i class="bi bi-patch-check me-2 text-primary"></i>Form Tambah Sertifikasi Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="nama_sertifikat" class="form-label fw-semibold">Nama Sertifikat / Pelatihan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sertifikat" id="nama_sertifikat" class="form-control @error('nama_sertifikat') is-invalid @enderror" value="{{ old('nama_sertifikat') }}" placeholder="Contoh: Sertifikasi Junior Web Developer / Pelatihan Aksesibilitas Digital" required>
                            @error('nama_sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="lembaga" class="form-label fw-semibold">Lembaga Penerbit / Penyelenggara <span class="text-danger">*</span></label>
                                <input type="text" name="lembaga" id="lembaga" class="form-control @error('lembaga') is-invalid @enderror" value="{{ old('lembaga') }}" placeholder="Contoh: BNSP / Kominfo / Cisco Academy" required>
                                @error('lembaga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label for="tahun" class="form-label fw-semibold">Tahun Penerbitan <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" id="tahun" min="1990" max="{{ date('Y') + 1 }}" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" placeholder="Contoh: {{ date('Y') }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Berkas -->
                        <div class="mb-4">
                            <label for="file" class="form-label fw-semibold">Upload Berkas Sertifikat (PDF/Gambar)</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Format yang didukung: PDF, JPG, PNG (Maks. 5MB).</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('sertifikasi.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Sertifikasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
