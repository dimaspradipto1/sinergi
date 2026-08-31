@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Dokumen Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item"><a href="{{ route('dokumen-mahasiswa.index') }}">Dokumen Mahasiswa</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Data Dokumen Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('dokumen-mahasiswa.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Cari NIM atau Nama Mahasiswa --" required>
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

                        <div class="mb-3">
                            <label for="nama_dokumen" class="form-label fw-semibold">Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror" value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" placeholder="Contoh: Surat Keterangan Dokter Spesialis THT / KTP Asli" required>
                            @error('nama_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jenis_dokumen" class="form-label fw-semibold">Kategori / Jenis Dokumen <span class="text-danger">*</span></label>
                                <select name="jenis_dokumen" id="jenis_dokumen" class="form-select @error('jenis_dokumen') is-invalid @enderror" required>
                                    @foreach($jenisDokumenList as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nomor_dokumen" class="form-label fw-semibold">Nomor Dokumen / Sertifikat</label>
                                <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control @error('nomor_dokumen') is-invalid @enderror" value="{{ old('nomor_dokumen', $dokumen->nomor_dokumen) }}" placeholder="Nomor surat (jika ada)">
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label fw-semibold">Berkas Dokumen</label>
                            @if($dokumen->file_dokumen)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-file-earmark-check me-1"></i> Lihat Berkas Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file_dokumen" id="file_dokumen" class="form-control @error('file_dokumen') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah berkas dokumen. (Format: PDF, JPG, PNG, WEBP, Maksimal 5MB)</small>
                            @error('file_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan / Catatan Tambahan</label>
                            <textarea name="keterangan" id="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Catatan mengenai dokumen">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dokumen-mahasiswa.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Dokumen
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
