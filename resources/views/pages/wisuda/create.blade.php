@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Peserta Wisuda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Kelulusan</li>
            <li class="breadcrumb-item"><a href="{{ route('wisuda.index') }}">Wisuda</a></li>
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
                        <i class="bi bi-mortarboard-fill me-2 text-primary"></i>Form Tambah Peserta Wisuda Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('wisuda.store') }}" method="POST">
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
                            <div class="col-md-7">
                                <label for="periode_wisuda" class="form-label fw-semibold">Periode Wisuda <span class="text-danger">*</span></label>
                                <input type="text" name="periode_wisuda" id="periode_wisuda" class="form-control @error('periode_wisuda') is-invalid @enderror" value="{{ old('periode_wisuda') }}" placeholder="Contoh: Wisuda Periode I Tahun Akademik 2026/2027" required>
                                @error('periode_wisuda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label for="tanggal_wisuda" class="form-label fw-semibold">Tanggal Pelaksanaan Wisuda <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_wisuda" id="tanggal_wisuda" class="form-control @error('tanggal_wisuda') is-invalid @enderror" value="{{ old('tanggal_wisuda', date('Y-m-d')) }}" required>
                                @error('tanggal_wisuda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomor_kursi" class="form-label fw-semibold">Nomor Kursi / Baris</label>
                                <input type="text" name="nomor_kursi" id="nomor_kursi" class="form-control @error('nomor_kursi') is-invalid @enderror" value="{{ old('nomor_kursi') }}" placeholder="Contoh: Baris A-12 / Sektor Barat 05">
                                @error('nomor_kursi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_kehadiran" class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                <select name="status_kehadiran" id="status_kehadiran" class="form-select @error('status_kehadiran') is-invalid @enderror" required>
                                    <option value="Terdaftar" {{ old('status_kehadiran', 'Terdaftar') == 'Terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                    <option value="Hadir" {{ old('status_kehadiran') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Tidak Hadir" {{ old('status_kehadiran') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                </select>
                                @error('status_kehadiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="kebutuhan_khusus_wisuda" class="form-label fw-semibold">Kebutuhan Aksesibilitas & Pendampingan Wisuda (Khusus PLD)</label>
                            <textarea name="kebutuhan_khusus_wisuda" id="kebutuhan_khusus_wisuda" rows="3" class="form-control @error('kebutuhan_khusus_wisuda') is-invalid @enderror" placeholder="Contoh: Membutuhkan pendamping juru bahasa isyarat di sisi panggung, akses ramp kursi roda menuju panggung, bantuan navigasi mobilitas.">{{ old('kebutuhan_khusus_wisuda') }}</textarea>
                            <small class="text-muted">Fasilitas atau pendampingan yang disiapkan panitia untuk kelancaran prosesi wisuda mahasiswa.</small>
                            @error('kebutuhan_khusus_wisuda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('wisuda.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Peserta Wisuda
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
