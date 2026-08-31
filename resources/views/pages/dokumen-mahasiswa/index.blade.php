@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Dokumen Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item active">Dokumen Mahasiswa</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-3 py-2 px-3">
        <i class="bi bi-folder2-open fs-4 text-info me-3"></i>
        <div>
            <strong>Arsip & Berkas Dokumen Mahasiswa:</strong>
            <div class="small text-muted">Kelola berkas identitas, hasil asesmen psikologis, surat keterangan disabilitas/medis, ijazah, dan dokumen pendukung lainnya.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-file-earmark-text me-2 text-primary"></i>Daftar Seluruh Dokumen Mahasiswa
                        </h5>
                        <small class="text-muted">Unduh dan tinjau berkas dokumen terunggah</small>
                    </div>
                    <a href="{{ route('dokumen-mahasiswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Unggah Dokumen Baru
                    </a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'dokumenmahasiswa-table']) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handler Konfirmasi Hapus Data
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const name = $(this).data('name') || 'dokumen ini';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Berkas "${name}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
