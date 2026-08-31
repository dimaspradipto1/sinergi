@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Alumni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item"><a href="{{ route('alumni.index') }}">Data Alumni</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Data Alumni
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('alumni.update', $alumni->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa Lulusan <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Cari NIM atau Nama Mahasiswa --" required>
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $alumni->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
                                        {{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->programStudi->program_studi ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tahun_lulus" class="form-label fw-semibold">Tahun Lulus <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_lulus" id="tahun_lulus" min="1950" max="{{ date('Y') + 1 }}" class="form-control @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus', $alumni->tahun_lulus) }}" placeholder="Contoh: {{ date('Y') }}" required>
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="email_aktif" class="form-label fw-semibold">Email Aktif</label>
                                <input type="email" name="email_aktif" id="email_aktif" class="form-control @error('email_aktif') is-invalid @enderror" value="{{ old('email_aktif', $alumni->email_aktif) }}" placeholder="email@domain.com">
                                @error('email_aktif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="no_hp_aktif" class="form-label fw-semibold">No. HP / WhatsApp Aktif</label>
                                <input type="text" name="no_hp_aktif" id="no_hp_aktif" class="form-control @error('no_hp_aktif') is-invalid @enderror" value="{{ old('no_hp_aktif', $alumni->no_hp_aktif) }}" placeholder="08xxxxxxxxxx">
                                @error('no_hp_aktif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pekerjaan_sekarang" class="form-label fw-semibold">Pekerjaan / Status Karir Saat Ini</label>
                                <input type="text" name="pekerjaan_sekarang" id="pekerjaan_sekarang" class="form-control @error('pekerjaan_sekarang') is-invalid @enderror" value="{{ old('pekerjaan_sekarang', $alumni->pekerjaan_sekarang) }}" placeholder="Contoh: Graphic Designer / Software Engineer / Wirausaha">
                                @error('pekerjaan_sekarang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="instansi_tempat_kerja" class="form-label fw-semibold">Instansi / Perusahaan Tempat Bekerja</label>
                                <input type="text" name="instansi_tempat_kerja" id="instansi_tempat_kerja" class="form-control @error('instansi_tempat_kerja') is-invalid @enderror" value="{{ old('instansi_tempat_kerja', $alumni->instansi_tempat_kerja) }}" placeholder="Nama perusahaan / lembaga (jika ada)">
                                @error('instansi_tempat_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat_terbaru" class="form-label fw-semibold">Alamat Terbaru Domisili</label>
                            <textarea name="alamat_terbaru" id="alamat_terbaru" rows="3" class="form-control @error('alamat_terbaru') is-invalid @enderror" placeholder="Alamat lengkap domisili alumni saat ini">{{ old('alamat_terbaru', $alumni->alamat_terbaru) }}</textarea>
                            @error('alamat_terbaru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Data Alumni
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
