@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Instrumen Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item active">Instrumen Asesmen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-3 py-2 px-3">
        <i class="bi bi-card-checklist fs-4 text-info me-3"></i>
        <div>
            <strong>Katalog Instrumen Asesmen Kompetensi:</strong>
            <div class="small text-muted">Kelola jenis-jenis instrumen pengujian kompetensi seperti Soft Skill, Leadership, Digital Skill, Bahasa Inggris, dan keahlian lainnya.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-clipboard2-check me-2 text-primary"></i>Daftar Instrumen Asesmen
                        </h5>
                        <small class="text-muted">Master instrumen untuk pembuatan bank soal dan pelaksanaan ujian asesmen</small>
                    </div>
                    <a href="{{ route('instrumen-asesmen.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Instrumen Asesmen
                    </a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'instrumenasesmen-table']) !!}
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
            const name = $(this).data('name') || 'instrumen ini';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Instrumen "${name}" akan dihapus permanen!`,
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
