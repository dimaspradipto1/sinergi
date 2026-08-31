@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Data Alumni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pendataan</li>
            <li class="breadcrumb-item active">Data Alumni</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3 py-2 px-3">
        <i class="bi bi-mortarboard-fill fs-4 text-success me-3"></i>
        <div>
            <strong>Pelacakan Karir & Direktori Alumni (Tracer Study):</strong>
            <div class="small text-muted">Mendata mahasiswa yang telah lulus, tahun kelulusan, kontak aktif, dan perkembangan karir/tempat kerja pasca kampus.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-person-check-fill me-2 text-primary"></i>Daftar Seluruh Data Alumni
                        </h5>
                        <small class="text-muted">Kelola data kelulusan, kontak aktif, dan status pekerjaan alumni</small>
                    </div>
                    <a href="{{ route('alumni.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Data Alumni
                    </a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'alumni-table']) !!}
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
            const name = $(this).data('name') || 'data alumni ini';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `${name} akan dihapus permanen!`,
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
