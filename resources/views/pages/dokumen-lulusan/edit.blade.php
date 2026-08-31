@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Dokumen Lulusan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Kelulusan</li>
            <li class="breadcrumb-item"><a href="{{ route('dokumen-lulusan.index') }}">Dokumen Lulusan</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Dokumen Kelulusan
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('dokumen-lulusan.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa / Alumni <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Pilih Mahasiswa --" required>
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $dokumen->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
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
                                <label for="jenis_dokumen" class="form-label fw-semibold">Jenis Dokumen <span class="text-danger">*</span></label>
                                <select name="jenis_dokumen" id="jenis_dokumen" class="form-select @error('jenis_dokumen') is-invalid @enderror" required>
                                    @foreach($jenisList as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nomor_dokumen" class="form-label fw-semibold">Nomor Dokumen / SK <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control @error('nomor_dokumen') is-invalid @enderror" value="{{ old('nomor_dokumen', $dokumen->nomor_dokumen) }}" placeholder="Contoh: IJZ-2026-00129" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal Terbit Dokumen <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control @error('tanggal_terbit') is-invalid @enderror" value="{{ old('tanggal_terbit', $dokumen->tanggal_terbit ? $dokumen->tanggal_terbit->format('Y-m-d') : '') }}" required>
                                @error('tanggal_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_verifikasi" class="form-label fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                                <select name="status_verifikasi" id="status_verifikasi" class="form-select @error('status_verifikasi') is-invalid @enderror" required>
                                    <option value="Menunggu Verifikasi" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="Terverifikasi" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="Ditolak" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status_verifikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload File -->
                        <div class="mb-3">
                            <label for="file" class="form-label fw-semibold">Upload File Dokumen Baru (Opsional)</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            @if($dokumen->file)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye me-1"></i> Lihat Berkas Saat Ini
                                    </a>
                                </div>
                            @endif
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Catatan tambahan mengenai dokumen kelulusan">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dokumen-lulusan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Dokumen Lulusan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
