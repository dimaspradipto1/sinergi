@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Survey Tracer Study</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pelacakan Karir</li>
            <li class="breadcrumb-item"><a href="{{ route('tracer-study.index') }}">Tracer Study</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Tracer Study Alumni
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('tracer-study.update', $tracerStudy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Alumni -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="alumni_id" class="form-label fw-semibold">Alumni <span class="text-danger">*</span></label>
                                <select name="alumni_id" id="alumni_id" class="form-select select2 @error('alumni_id') is-invalid @enderror" data-placeholder="-- Pilih Alumni --" required>
                                    @foreach($alumni as $alm)
                                        <option value="{{ $alm->id }}" {{ old('alumni_id', $tracerStudy->alumni_id) == $alm->id ? 'selected' : '' }}>
                                            {{ $alm->mahasiswa->nim ?? '-' }} - {{ $alm->mahasiswa->nama ?? '-' }} (Lulus: {{ $alm->tahun_lulus }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('alumni_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tahun_survey" class="form-label fw-semibold">Tahun Pelaksanaan Survey <span class="text-danger">*</span></label>
                                <input type="number" min="2000" max="{{ date('Y') + 1 }}" name="tahun_survey" id="tahun_survey" class="form-control @error('tahun_survey') is-invalid @enderror" value="{{ old('tahun_survey', $tracerStudy->tahun_survey) }}" placeholder="Contoh: {{ date('Y') }}" required>
                                @error('tahun_survey')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status_pekerjaan" class="form-label fw-semibold">Status Pekerjaan Saat Ini <span class="text-danger">*</span></label>
                                <select name="status_pekerjaan" id="status_pekerjaan" class="form-select @error('status_pekerjaan') is-invalid @enderror" required>
                                    @foreach($statusList as $status)
                                        <option value="{{ $status }}" {{ old('status_pekerjaan', $tracerStudy->status_pekerjaan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="pendapatan" class="form-label fw-semibold">Kisaran Pendapatan / Penghasilan Bulanan <span class="text-danger">*</span></label>
                                <select name="pendapatan" id="pendapatan" class="form-select @error('pendapatan') is-invalid @enderror" required>
                                    @foreach($pendapatanList as $pendapatan)
                                        <option value="{{ $pendapatan }}" {{ old('pendapatan', $tracerStudy->pendapatan) == $pendapatan ? 'selected' : '' }}>{{ $pendapatan }}</option>
                                    @endforeach
                                </select>
                                @error('pendapatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="waktu_tunggu" class="form-label fw-semibold">Masa Tunggu Mendapat Kerja Pertama (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" min="0" max="120" name="waktu_tunggu" id="waktu_tunggu" class="form-control @error('waktu_tunggu') is-invalid @enderror" value="{{ old('waktu_tunggu', $tracerStudy->waktu_tunggu) }}" placeholder="Contoh: 3" required>
                                @error('waktu_tunggu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="relevansi_bidang" class="form-label fw-semibold">Relevansi / Kesesuaian Bidang Studi (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" min="0" max="100" name="relevansi_bidang" id="relevansi_bidang" class="form-control @error('relevansi_bidang') is-invalid @enderror" value="{{ old('relevansi_bidang', $tracerStudy->relevansi_bidang) }}" placeholder="Contoh: 80" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('relevansi_bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Tracer Study
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
