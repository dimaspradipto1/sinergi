@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Pertanyaan Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item"><a href="{{ route('pertanyaan-asesmen.index') }}">Bank Pertanyaan</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Butir Pertanyaan Asesmen
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('pertanyaan-asesmen.update', $pertanyaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Instrumen Asesmen -->
                        <div class="mb-3">
                            <label for="instrumen_asesmen_id" class="form-label fw-semibold">Instrumen Asesmen <span class="text-danger">*</span></label>
                            <select name="instrumen_asesmen_id" id="instrumen_asesmen_id" class="form-select select2 @error('instrumen_asesmen_id') is-invalid @enderror" data-placeholder="-- Pilih Instrumen Asesmen --" required>
                                @foreach($instrumen as $ins)
                                    <option value="{{ $ins->id }}" {{ old('instrumen_asesmen_id', $pertanyaan->instrumen_asesmen_id) == $ins->id ? 'selected' : '' }}>
                                        {{ $ins->nama_instrumen }} (Kategori: {{ $ins->kategori }})
                                    </option>
                                @endforeach
                            </select>
                            @error('instrumen_asesmen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pertanyaan" class="form-label fw-semibold">Butir Pertanyaan Asesmen <span class="text-danger">*</span></label>
                            <textarea name="pertanyaan" id="pertanyaan" rows="4" class="form-control @error('pertanyaan') is-invalid @enderror" placeholder="Tuliskan teks pertanyaan atau butir pernyataan indikator asesmen..." required>{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
                            @error('pertanyaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipe_jawaban" class="form-label fw-semibold">Tipe Format Jawaban <span class="text-danger">*</span></label>
                                <select name="tipe_jawaban" id="tipe_jawaban" class="form-select @error('tipe_jawaban') is-invalid @enderror" required>
                                    @foreach($tipeJawabanList as $tipe)
                                        <option value="{{ $tipe }}" {{ old('tipe_jawaban', $pertanyaan->tipe_jawaban) == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipe_jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="bobot" class="form-label fw-semibold">Bobot Poin Nilai <span class="text-danger">*</span></label>
                                <input type="number" name="bobot" id="bobot" min="1" class="form-control @error('bobot') is-invalid @enderror" value="{{ old('bobot', $pertanyaan->bobot) }}" placeholder="Contoh: 1, 5, 10" required>
                                <small class="text-muted">Bobot kontribusi nilai untuk pertanyaan ini.</small>
                                @error('bobot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4" id="pilihan-wrapper">
                            <label for="pilihan_jawaban" class="form-label fw-semibold">Pilihan Jawaban (Opsional / Jika Pilihan Ganda)</label>
                            <textarea name="pilihan_jawaban" id="pilihan_jawaban" rows="3" class="form-control @error('pilihan_jawaban') is-invalid @enderror" placeholder="Contoh:
A. Sangat Baik
B. Baik
C. Cukup
D. Kurang">{{ old('pilihan_jawaban', $pertanyaan->pilihan_jawaban) }}</textarea>
                            <small class="text-muted">Kosongkan jika menggunakan format Skala Likert otomatis atau Esai.</small>
                            @error('pilihan_jawaban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pertanyaan-asesmen.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Pertanyaan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
