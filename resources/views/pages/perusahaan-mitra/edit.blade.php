@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Perusahaan Mitra</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pelacakan Karir</li>
            <li class="breadcrumb-item"><a href="{{ route('perusahaan-mitra.index') }}">Perusahaan Mitra</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Perusahaan & Instansi Mitra
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('perusahaan-mitra.update', $perusahaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_perusahaan" class="form-label fw-semibold">Nama Perusahaan / Lembaga <span class="text-danger">*</span></label>
                                <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" placeholder="Contoh: PT Telkom Indonesia" required>
                                @error('nama_perusahaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="bidang" class="form-label fw-semibold">Bidang Industri / Sektor <span class="text-danger">*</span></label>
                                <select name="bidang" id="bidang" class="form-select @error('bidang') is-invalid @enderror" required>
                                    @foreach($bidangList as $bidang)
                                        <option value="{{ $bidang }}" {{ old('bidang', $perusahaan->bidang) == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                                    @endforeach
                                </select>
                                @error('bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kontak" class="form-label fw-semibold">Kontak / Email / Narahubung HRD</label>
                            <input type="text" name="kontak" id="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak', $perusahaan->kontak) }}" placeholder="Contoh: hrd@perusahaan.co.id / 021-88997766">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">Alamat Kantor</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap kantor operasional perusahaan">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('perusahaan-mitra.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Perusahaan Mitra
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
