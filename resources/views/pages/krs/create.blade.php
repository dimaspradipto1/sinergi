@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengisian KRS Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik & Penilaian</li>
            <li class="breadcrumb-item"><a href="{{ route('krs.index') }}">KRS Mahasiswa</a></li>
            <li class="breadcrumb-item active">Isi KRS</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-card-checklist me-2 text-primary"></i>Form Pengisian Kartu Rencana Studi (KRS)
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('krs.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <!-- Pilihan Mahasiswa -->
                            <div class="col-md-5 mb-3">
                                <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Pilih NIM / Nama Mahasiswa --" required>
                                    <option value="" disabled {{ old('mahasiswa_id') ? '' : 'selected' }}>-- Pilih NIM / Nama Mahasiswa --</option>
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

                            <!-- Pilihan Tahun Akademik -->
                            <div class="col-md-4 mb-3">
                                <label for="tahun_akademik" class="form-label fw-semibold">Tahun Akademik <span class="text-danger">*</span></label>
                                <select name="tahun_akademik" id="tahun_akademik" class="form-select @error('tahun_akademik') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('tahun_akademik') ? '' : 'selected' }}>-- Pilih Tahun Akademik --</option>
                                    @foreach($tahunAkademik as $ta)
                                        <option value="{{ $ta->tahun_akademik }}" {{ old('tahun_akademik') == $ta->tahun_akademik ? 'selected' : '' }}>
                                            {{ $ta->tahun_akademik }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilihan Semester -->
                            <div class="col-md-3 mb-3">
                                <label for="semester" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('semester') ? '' : 'selected' }}>-- Pilih Semester --</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pilihan Mata Kuliah (Multi Select) -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-bold text-dark">
                                    <i class="bi bi-book me-2 text-primary"></i>Pilih Mata Kuliah Yang Diambil
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    @forelse($mataKuliah as $mk)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="form-check border rounded p-2 ps-4 bg-white h-100">
                                                <input class="form-check-input" type="checkbox" name="mata_kuliah_id[]" value="{{ $mk->id }}" id="mk_{{ $mk->id }}" {{ is_array(old('mata_kuliah_id')) && in_array($mk->id, old('mata_kuliah_id')) ? 'checked' : '' }}>
                                                <label class="form-check-label d-block cursor-pointer" for="mk_{{ $mk->id }}">
                                                    <span class="badge bg-primary me-1">{{ $mk->kode_matkul }}</span>
                                                    <span class="fw-semibold text-dark">{{ $mk->nama_matkul }}</span>
                                                    <div class="small text-muted mt-1">
                                                        <span class="badge bg-secondary">{{ $mk->sks }} SKS</span>
                                                        <span class="badge bg-light text-dark border">Sem {{ $mk->semester }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center text-muted py-3">
                                            Belum ada data mata kuliah. Silakan tambahkan pada menu <strong>Mata Kuliah</strong>.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('krs.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan KRS
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
