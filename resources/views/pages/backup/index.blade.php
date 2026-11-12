@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 style="color: #1b5e20; font-weight: 700; font-size: 24px;">Backup Database & Storage</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan Sistem</li>
            <li class="breadcrumb-item active">Backup Database & Storage</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section mt-4">
    <div class="row g-4">
        <!-- 1. Ekspor & Impor Database -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Header Card -->
                        <div class="d-flex align-items-start mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                                style="width: 54px; height: 54px; background-color: #285430; color: #ffffff;">
                                <i class="bi bi-database" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #1c252e; font-size: 18px;">Ekspor & Impor Database</h5>
                                <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.45;">
                                    Unduh atau pulihkan struktur tabel dan data database aplikasi sebagai berkas SQL.
                                </p>
                            </div>
                        </div>

                        <!-- Data List -->
                        <div class="mb-4" style="font-size: 14px;">
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Koneksi</div>
                                <div class="col-8">
                                    <span class="badge px-2 py-1"
                                        style="background-color: #f1f3f5; color: #495057; border: 1px solid #ced4da; font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">
                                        MYSQL
                                    </span>
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Database</div>
                                <div class="col-8">
                                    <span style="color: #c2185b; font-family: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size: 14px;">
                                        {{ $databaseName }}
                                    </span>
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Isi backup</div>
                                <div class="col-8" style="color: #212529;">
                                    Struktur dan data semua tabel MySQL ({{ $totalTables }} tabel)
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="mb-4 d-flex align-items-start"
                            style="background-color: #e7f5ff; border: 1px solid #d0ebff; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #1971c2;">
                            <i class="bi bi-shield-fill-check me-2 flex-shrink-0 mt-1" style="font-size: 16px; color: #0b7285;"></i>
                            <div style="line-height: 1.45;">
                                <strong>Hanya administrator yang dapat mengunduh dan memulihkan database.</strong> Simpan berkas SQL di lokasi aman karena berisi seluruh data aplikasi.
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <a href="{{ route('backup.database.download') }}" class="btn d-inline-flex align-items-center"
                            style="background-color: #285430; color: #ffffff; border-radius: 6px; padding: 8px 18px; font-weight: 500; font-size: 14px; text-decoration: none;">
                            <i class="bi bi-download me-2"></i> Unduh Backup SQL
                        </a>
                        <button type="button" class="btn d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalImportDatabase"
                            style="background-color: #ffffff; color: #285430; border: 1px solid #285430; border-radius: 6px; padding: 8px 18px; font-weight: 500; font-size: 14px;">
                            <i class="bi bi-upload me-2"></i> Import / Pulihkan Database
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Backup & Impor Storage Public -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Header Card -->
                        <div class="d-flex align-items-start mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                                style="width: 54px; height: 54px; background-color: #e8f5e9; color: #285430;">
                                <i class="bi bi-folder-symlink" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #1c252e; font-size: 18px;">Backup & Impor Storage Public</h5>
                                <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.45;">
                                    Arsipkan atau pulihkan semua file pada folder <span style="color: #c2185b; font-family: monospace;">storage/app/public</span> ke dalam berkas ZIP.
                                </p>
                            </div>
                        </div>

                        <!-- Data List -->
                        <div class="mb-4" style="font-size: 14px;">
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Direktori</div>
                                <div class="col-8">
                                    <span style="color: #c2185b; font-family: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size: 14px;">
                                        storage/app/public
                                    </span>
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Total Berkas</div>
                                <div class="col-8" style="color: #212529;">
                                    {{ $totalStorageFiles }} berkas ({{ $totalStorageSizeFormatted }})
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-4 text-muted">Format Arsip</div>
                                <div class="col-8" style="color: #212529;">
                                    ZIP Archive (<span style="color: #c2185b; font-family: monospace;">.zip</span>)
                                </div>
                            </div>
                        </div>

                        <!-- Warning Box -->
                        <div class="mb-4 d-flex align-items-start"
                            style="background-color: #fff9db; border: 1px solid #ffec99; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #7f5f02;">
                            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0 mt-1" style="font-size: 16px; color: #f59f00;"></i>
                            <div style="line-height: 1.45;">
                                <strong>Backup storage memuat seluruh berkas lampiran, gambar, foto pimpinan, berita, dan dokumen publik aplikasi.</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <a href="{{ route('backup.storage.download') }}" class="btn d-inline-flex align-items-center"
                            style="background-color: #285430; color: #ffffff; border-radius: 6px; padding: 8px 18px; font-weight: 500; font-size: 14px; text-decoration: none;">
                            <i class="bi bi-download me-2"></i> Unduh Backup Storage ZIP
                        </a>
                        <button type="button" class="btn d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalImportStorage"
                            style="background-color: #ffffff; color: #285430; border: 1px solid #285430; border-radius: 6px; padding: 8px 18px; font-weight: 500; font-size: 14px;">
                            <i class="bi bi-upload me-2"></i> Import / Pulihkan Storage
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Import Database -->
<div class="modal fade" id="modalImportDatabase" tabindex="-1" aria-labelledby="modalImportDatabaseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalImportDatabaseLabel" style="color: #285430;">
                    <i class="bi bi-database-up me-2"></i>Import / Pulihkan Database
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backup.database.restore') }}" method="POST" enctype="multipart/form-data" id="formRestoreDatabase">
                @csrf
                <div class="modal-body py-3">
                    <div class="alert alert-warning d-flex align-items-start mb-3" style="font-size: 13px;">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>Peringatan!</strong> Proses ini akan mengeksekusi perintah SQL dan dapat menggantikan struktur atau data tabel yang ada saat ini. Pastikan Anda telah mengunduh backup terkini sebelum melanjutkan.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sql_file" class="form-label fw-semibold" style="font-size: 14px;">Pilih Berkas SQL (.sql)</label>
                        <input class="form-control" type="file" id="sql_file" name="sql_file" accept=".sql,.txt" required>
                        <div class="form-text" style="font-size: 12px;">Format berkas yang didukung: <code>.sql</code>. Ukuran maksimal 100 MB.</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-success" style="background-color: #285430; border-color: #285430; border-radius: 6px;" id="btnSubmitRestoreDb">
                        <i class="bi bi-check2-circle me-1"></i> Mulai Pulihkan Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Storage -->
<div class="modal fade" id="modalImportStorage" tabindex="-1" aria-labelledby="modalImportStorageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalImportStorageLabel" style="color: #285430;">
                    <i class="bi bi-folder-symlink me-2"></i>Import / Pulihkan Storage Public
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backup.storage.restore') }}" method="POST" enctype="multipart/form-data" id="formRestoreStorage">
                @csrf
                <div class="modal-body py-3">
                    <div class="alert alert-warning d-flex align-items-start mb-3" style="font-size: 13px;">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>Peringatan!</strong> Berkas di dalam arsip ZIP akan diekstrak langsung ke folder <code>storage/app/public</code> dan menimpa berkas yang bernama sama.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="zip_file" class="form-label fw-semibold" style="font-size: 14px;">Pilih Berkas Arsip (.zip)</label>
                        <input class="form-control" type="file" id="zip_file" name="zip_file" accept=".zip" required>
                        <div class="form-text" style="font-size: 12px;">Format berkas yang didukung: <code>.zip</code>. Ukuran maksimal 200 MB.</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-success" style="background-color: #285430; border-color: #285430; border-radius: 6px;" id="btnSubmitRestoreStorage">
                        <i class="bi bi-check2-circle me-1"></i> Mulai Ekstrak & Pulihkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formRestoreDatabase')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Konfirmasi Pemulihan Database',
            text: 'Apakah Anda yakin ingin memulihkan database? Seluruh struktur dan data saat ini akan disinkronkan dengan berkas SQL yang Anda pilih.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#285430',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Pulihkan Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Pemulihan...',
                    text: 'Mohon tunggu beberapa saat, sistem sedang mengeksekusi berkas SQL.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });

    document.getElementById('formRestoreStorage')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Konfirmasi Pemulihan Storage',
            text: 'Apakah Anda yakin ingin memulihkan berkas storage? Berkas ZIP akan diekstrak ke direktori publik sistem.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#285430',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ekstrak Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengekstrak Berkas...',
                    text: 'Mohon tunggu, sistem sedang mengekstrak arsip ZIP.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
</script>
@endpush

