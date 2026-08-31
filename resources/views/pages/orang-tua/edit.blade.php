@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Orang Tua / Wali</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item"><a href="{{ route('orang-tua.index') }}">Data Orang Tua/Wali</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Data Orang Tua / Wali Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('orang-tua.update', $orangTua->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pilihan Mahasiswa -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror" required>
                                    @foreach($mahasiswa as $mhs)
                                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $orangTua->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
                                            {{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->programStudi->program_studi ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kolom Kiri: Data Ayah -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    <i class="bi bi-gender-male me-1"></i> Data Ayah
                                </h6>

                                <div class="mb-3">
                                    <label for="nama_ayah" class="form-label fw-semibold">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" id="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $orangTua->nama_ayah) }}" placeholder="Masukkan nama lengkap ayah">
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label fw-semibold">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" value="{{ old('pekerjaan_ayah', $orangTua->pekerjaan_ayah) }}" placeholder="Contoh: PNS / Wiraswasta / Petani / Karyawan Swasta">
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pendidikan_ayah" class="form-label fw-semibold">Pendidikan Ayah</label>
                                    <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-select @error('pendidikan_ayah') is-invalid @enderror">
                                        <option value="" disabled {{ old('pendidikan_ayah', $orangTua->pendidikan_ayah) ? '' : 'selected' }}>-- Pilih Pendidikan Ayah --</option>
                                        @foreach($pendidikanList as $pen)
                                            <option value="{{ $pen }}" {{ old('pendidikan_ayah', $orangTua->pendidikan_ayah) == $pen ? 'selected' : '' }}>
                                                {{ $pen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Data Ibu -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    <i class="bi bi-gender-female me-1"></i> Data Ibu
                                </h6>

                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label fw-semibold">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $orangTua->nama_ibu) }}" placeholder="Masukkan nama lengkap ibu">
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label fw-semibold">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" value="{{ old('pekerjaan_ibu', $orangTua->pekerjaan_ibu) }}" placeholder="Contoh: Ibu Rumah Tangga / PNS / Guru / Wiraswasta">
                                    @error('pekerjaan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pendidikan_ibu" class="form-label fw-semibold">Pendidikan Ibu</label>
                                    <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-select @error('pendidikan_ibu') is-invalid @enderror">
                                        <option value="" disabled {{ old('pendidikan_ibu', $orangTua->pendidikan_ibu) ? '' : 'selected' }}>-- Pilih Pendidikan Ibu --</option>
                                        @foreach($pendidikanList as $pen)
                                            <option value="{{ $pen }}" {{ old('pendidikan_ibu', $orangTua->pendidikan_ibu) == $pen ? 'selected' : '' }}>
                                                {{ $pen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak & Wali -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    <i class="bi bi-telephone-fill me-1"></i> Kontak & Data Wali (Opsional)
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label fw-semibold">No. HP / WhatsApp Orang Tua/Wali</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $orangTua->no_hp) }}" placeholder="Contoh: 08xxxxxxxxxx">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="penghasilan_orang_tua" class="form-label fw-semibold">Penghasilan Orang Tua</label>
                                    <select name="penghasilan_orang_tua" id="penghasilan_orang_tua" class="form-select @error('penghasilan_orang_tua') is-invalid @enderror">
                                        <option value="" disabled {{ old('penghasilan_orang_tua', $orangTua->penghasilan_orang_tua) ? '' : 'selected' }}>-- Pilih Rentang Penghasilan --</option>
                                        @foreach($penghasilanList as $penghasilan)
                                            <option value="{{ $penghasilan }}" {{ old('penghasilan_orang_tua', $orangTua->penghasilan_orang_tua) == $penghasilan ? 'selected' : '' }}>
                                                {{ $penghasilan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penghasilan_orang_tua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nama_wali" class="form-label fw-semibold">Nama Wali (Jika Ada)</label>
                                        <input type="text" name="nama_wali" id="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali', $orangTua->nama_wali) }}" placeholder="Nama wali">
                                        @error('nama_wali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pekerjaan_wali" class="form-label fw-semibold">Pekerjaan Wali</label>
                                        <input type="text" name="pekerjaan_wali" id="pekerjaan_wali" class="form-control @error('pekerjaan_wali') is-invalid @enderror" value="{{ old('pekerjaan_wali', $orangTua->pekerjaan_wali) }}" placeholder="Pekerjaan wali">
                                        @error('pekerjaan_wali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label fw-semibold">Alamat Orang Tua / Wali</label>
                                    <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat domisili tempat tinggal orang tua/wali">{{ old('alamat', $orangTua->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('orang-tua.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Data Orang Tua/Wali
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
