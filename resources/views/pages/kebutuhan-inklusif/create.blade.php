@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Kebutuhan Inklusif</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item"><a href="{{ route('kebutuhan-inklusif.index') }}">Kebutuhan Inklusif</a></li>
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
                        <i class="bi bi-universal-access me-2 text-primary"></i>Form Tambah Kebutuhan Inklusif Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('kebutuhan-inklusif.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label fw-semibold">Pilih Mahasiswa <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Cari NIM atau Nama Mahasiswa --" required>
                                <option value="" disabled {{ old('mahasiswa_id') ? '' : 'selected' }}>-- Cari NIM atau Nama Mahasiswa --</option>
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
                                <label for="kategori" class="form-label fw-semibold">Kategori Disabilitas <span class="text-danger">*</span></label>
                                <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih Kategori Disabilitas --</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kebutuhan" class="form-label fw-semibold">Ragam Kebutuhan Khusus <span class="text-danger">*</span></label>
                                <input type="text" name="kebutuhan" id="kebutuhan" class="form-control @error('kebutuhan') is-invalid @enderror" value="{{ old('kebutuhan') }}" placeholder="Contoh: Tuna Netra Low Vision / Tunarungu / Cerebral Palsy" required>
                                @error('kebutuhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="layanan_pendukung" class="form-label fw-semibold">Layanan & Akomodasi Pendukung</label>
                            <textarea name="layanan_pendukung" id="layanan_pendukung" rows="3" class="form-control @error('layanan_pendukung') is-invalid @enderror" placeholder="Contoh: Juru Bahasa Isyarat (JBI) pada kelas tatap muka, perpanjangan waktu ujian 30 menit, materi perkuliahan dalam format file audio/teks digital">{{ old('layanan_pendukung') }}</textarea>
                            <small class="text-muted">Akomodasi, alat bantu, atau jenis pendampingan yang disediakan kampus.</small>
                            @error('layanan_pendukung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi / Catatan Tambahan</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Kondisi kesehatan atau riwayat asesmen yang perlu diketahui tim pendamping">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kebutuhan-inklusif.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Kebutuhan Inklusif
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
