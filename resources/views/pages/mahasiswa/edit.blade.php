@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a></li>
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
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Data Mahasiswa
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri: Informasi Akademik -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Informasi Akademik</h6>

                                <div class="mb-3">
                                    <label for="program_studi_id" class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                                    <select name="program_studi_id" id="program_studi_id" class="form-select @error('program_studi_id') is-invalid @enderror" required>
                                        @foreach($programStudi as $prodi)
                                            <option value="{{ $prodi->id }}" {{ old('program_studi_id', $mahasiswa->program_studi_id) == $prodi->id ? 'selected' : '' }}>
                                                {{ $prodi->program_studi }} ({{ $prodi->fakultas->nama_fakultas ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('program_studi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tahun_akademik_id" class="form-label fw-semibold">Tahun Masuk / Angkatan <span class="text-danger">*</span></label>
                                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-select @error('tahun_akademik_id') is-invalid @enderror" required>
                                        @foreach($tahunAkademik as $thn)
                                            <option value="{{ $thn->id }}" {{ old('tahun_akademik_id', $mahasiswa->tahun_akademik_id) == $thn->id ? 'selected' : '' }}>
                                                {{ $thn->tahun_akademik }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahun_akademik_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jalur_masuk" class="form-label fw-semibold">Jalur Masuk <span class="text-danger">*</span></label>
                                    <select name="jalur_masuk" id="jalur_masuk" class="form-select @error('jalur_masuk') is-invalid @enderror" required>
                                        @foreach($jalurMasukList as $jalur)
                                            <option value="{{ $jalur }}" {{ old('jalur_masuk', $mahasiswa->jalur_masuk) == $jalur ? 'selected' : '' }}>
                                                {{ $jalur }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jalur_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nim" class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $mahasiswa->nim) }}" placeholder="Contoh: 202611001" required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status_mahasiswa" class="form-label fw-semibold">Status Mahasiswa <span class="text-danger">*</span></label>
                                    <select name="status_mahasiswa" id="status_mahasiswa" class="form-select @error('status_mahasiswa') is-invalid @enderror" required>
                                        @foreach($statusList as $status)
                                            <option value="{{ $status }}" {{ old('status_mahasiswa', $mahasiswa->status_mahasiswa) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_mahasiswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                                    @if($mahasiswa->foto)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto" class="rounded" width="80" height="80" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. (Maksimal 2MB)</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Data Pribadi -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Biodata Pribadi</h6>

                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama) }}" placeholder="Masukkan nama lengkap" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label fw-semibold">NIK (No. KTP)</label>
                                    <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $mahasiswa->nik) }}" placeholder="16 digit NIK">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir) }}" placeholder="Kota kelahiran">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('Y-m-d') : '') }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $mahasiswa->email) }}" placeholder="email@contoh.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_hp" class="form-label fw-semibold">No. HP / WhatsApp</label>
                                        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $mahasiswa->no_hp) }}" placeholder="08xxxxxxxxxx">
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat domisili/tempat tinggal">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Data Mahasiswa
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
