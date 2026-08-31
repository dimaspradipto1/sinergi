@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Profil Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Profil Saya</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <!-- Kolom Kiri: Card Ringkasan Profil -->
        <div class="col-xl-4">

            <div class="card shadow-sm border-0">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">

                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fw-bold shadow mb-3" style="width: 100px; height: 100px; font-size: 2.2rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <span class="badge bg-primary px-3 py-2 text-uppercase mb-2">{{ $user->role ?? 'User' }}</span>
                    <p class="text-muted small mb-0"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>

                    <div class="d-flex gap-2 mt-3 pt-3 border-top w-100 justify-content-center">
                        <small class="text-muted">
                            <i class="bi bi-calendar-check me-1"></i> Bergabung: {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Tab Menu Profil, Edit Profil, & Ganti Password -->
        <div class="col-xl-8">

            <div class="card shadow-sm border-0">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" role="tab">
                                <i class="bi bi-person me-1"></i> Ringkasan Profil
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" role="tab">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" role="tab">
                                <i class="bi bi-key me-1"></i> Ganti Password
                            </button>
                        </li>

                    </ul>

                    <div class="tab-content pt-4">

                        <!-- Tab 1: Ringkasan Profil -->
                        <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                            <h5 class="card-title fw-bold text-primary mb-3">Detail Informasi Akun</h5>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8 fw-bold">{{ $user->name }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Alamat Email</div>
                                <div class="col-lg-9 col-md-8 text-primary">{{ $user->email }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Hak Akses / Peran</div>
                                <div class="col-lg-9 col-md-8">
                                    <span class="badge bg-success">{{ ucfirst($user->role ?? 'User') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Terdaftar Sejak</div>
                                <div class="col-lg-9 col-md-8">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }} WIB</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Pembaruan Terakhir</div>
                                <div class="col-lg-9 col-md-8">{{ $user->updated_at ? $user->updated_at->diffForHumans() : '-' }}</div>
                            </div>
                        </div>

                        <!-- Tab 2: Edit Profil -->
                        <div class="tab-pane fade profile-edit pt-2" id="profile-edit" role="tabpanel">

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-lg-3 col-form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>

                        </div>

                        <!-- Tab 3: Ganti Password -->
                        <div class="tab-pane fade pt-2" id="profile-change-password" role="tabpanel">

                            <form action="{{ route('profile.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-4 col-lg-3 col-form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Masukkan password lama Anda" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-lg-3 col-form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Minimal 6 karakter" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="password_confirmation" class="col-md-4 col-lg-3 col-form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Ketik ulang password baru Anda" required>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-warning text-white">
                                        <i class="bi bi-shield-lock me-1"></i> Perbarui Password
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
