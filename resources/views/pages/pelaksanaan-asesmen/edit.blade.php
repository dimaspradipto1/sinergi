@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Pelaksanaan Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item"><a href="{{ route('pelaksanaan-asesmen.index') }}">Pelaksanaan Asesmen</a></li>
            <li class="breadcrumb-item active">Edit Asesmen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Data Pelaksanaan & Nilai Asesmen
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('pelaksanaan-asesmen.update', $asesmen->id) }}" method="POST" id="form-asesmen">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <!-- Pilihan Mahasiswa -->
                            <div class="col-md-5 mb-3">
                                <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Cari NIM atau Nama Mahasiswa --" required>
                                    @foreach($mahasiswa as $mhs)
                                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $asesmen->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
                                            {{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->programStudi->program_studi ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilihan Instrumen Asesmen -->
                            <div class="col-md-4 mb-3">
                                <label for="instrumen_asesmen_id" class="form-label fw-semibold">Instrumen Asesmen <span class="text-danger">*</span></label>
                                <select name="instrumen_asesmen_id" id="instrumen_asesmen_id" class="form-select @error('instrumen_asesmen_id') is-invalid @enderror" required>
                                    @foreach($instrumen as $ins)
                                        <option value="{{ $ins->id }}" {{ old('instrumen_asesmen_id', $asesmen->instrumen_asesmen_id) == $ins->id ? 'selected' : '' }}>
                                            {{ $ins->nama_instrumen }} (Kategori: {{ $ins->kategori }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('instrumen_asesmen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pelaksanaan -->
                            <div class="col-md-3 mb-3">
                                <label for="tanggal" class="form-label fw-semibold">Tanggal Asesmen <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $asesmen->tanggal ? $asesmen->tanggal->format('Y-m-d') : '') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Area Butir Pertanyaan -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-dark">
                                    <i class="bi bi-list-task me-2 text-primary"></i>Daftar Pertanyaan & Penilaian Asesmen
                                </h6>
                                <span class="badge bg-primary">{{ count($pertanyaan) }} Butir Soal</span>
                            </div>
                            <div class="card-body p-3" id="container-pertanyaan">
                                @forelse($pertanyaan as $index => $item)
                                    @php
                                        $no = $index + 1;
                                        $savedJawaban = $jawabanMap[$item->id]->jawaban ?? '';
                                        $savedSkor = $jawabanMap[$item->id]->skor ?? $item->bobot;
                                        $tipe = strtolower($item->tipe_jawaban ?? '');
                                    @endphp

                                    <div class="border rounded p-3 mb-3 bg-white shadow-xs">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge bg-primary me-2">No. {{ $no }}</span>
                                                <span class="fw-semibold text-dark">{{ $item->pertanyaan }}</span>
                                            </div>
                                            <span class="badge bg-secondary">{{ $item->tipe_jawaban }}</span>
                                        </div>

                                        @if(str_contains($tipe, 'likert'))
                                            <div class="row align-items-center mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted mb-1">Skala Penilaian (1 - 5):</label>
                                                    <select name="skor[{{ $item->id }}]" class="form-select form-select-sm" required>
                                                        <option value="5" {{ $savedSkor == 5 ? 'selected' : '' }}>5 - Sangat Baik / Mahir</option>
                                                        <option value="4" {{ $savedSkor == 4 ? 'selected' : '' }}>4 - Baik / Kompeten</option>
                                                        <option value="3" {{ $savedSkor == 3 ? 'selected' : '' }}>3 - Cukup / Rata-rata</option>
                                                        <option value="2" {{ $savedSkor == 2 ? 'selected' : '' }}>2 - Kurang</option>
                                                        <option value="1" {{ $savedSkor == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted mb-1">Catatan / Jawaban Deskriptif (Opsional):</label>
                                                    <input type="text" name="jawaban[{{ $item->id }}]" class="form-control form-control-sm" value="{{ $savedJawaban }}" placeholder="Catatan observasi butir ini">
                                                </div>
                                            </div>
                                        @elseif(str_contains($tipe, 'ya') || str_contains($tipe, 'boolean'))
                                            <div class="row align-items-center mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted mb-1">Pilihan Jawaban:</label>
                                                    <select name="jawaban[{{ $item->id }}]" class="form-select form-select-sm" required>
                                                        <option value="Ya" {{ $savedJawaban === 'Ya' ? 'selected' : '' }}>Ya (Memenuhi)</option>
                                                        <option value="Tidak" {{ $savedJawaban === 'Tidak' ? 'selected' : '' }}>Tidak (Belum Memenuhi)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted mb-1">Skor Poin:</label>
                                                    <input type="number" name="skor[{{ $item->id }}]" class="form-control form-control-sm" value="{{ $savedSkor }}" min="0" required>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row align-items-center mt-2">
                                                <div class="col-md-7">
                                                    <label class="form-label small text-muted mb-1">Jawaban / Respon Mahasiswa:</label>
                                                    <textarea name="jawaban[{{ $item->id }}]" rows="2" class="form-control form-control-sm" placeholder="Tuliskan jawaban atau hasil tes">{{ $savedJawaban }}</textarea>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label small text-muted mb-1">Skor Penilaian:</label>
                                                    <input type="number" name="skor[{{ $item->id }}]" class="form-control form-control-sm" value="{{ $savedSkor }}" min="0" required>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="alert alert-warning mb-0">
                                        Tidak ada pertanyaan pada instrumen ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Catatan Asesor -->
                        <div class="mb-4">
                            <label for="catatan_asesor" class="form-label fw-semibold">Catatan / Rekomendasi Asesor (Opsional)</label>
                            <textarea name="catatan_asesor" id="catatan_asesor" rows="3" class="form-control @error('catatan_asesor') is-invalid @enderror" placeholder="Catatan hasil observasi, kelebihan, atau rekomendasi tindak lanjut bagi mahasiswa...">{{ old('catatan_asesor', $asesmen->catatan_asesor) }}</textarea>
                            @error('catatan_asesor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pelaksanaan-asesmen.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui & Hitung Ulang Nilai Asesmen
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
