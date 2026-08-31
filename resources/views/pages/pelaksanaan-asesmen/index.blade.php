@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pelaksanaan Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item active">Pelaksanaan Asesmen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Info Banner Penjelas Modul -->
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-3 py-2 px-3">
        <i class="bi bi-ui-checks-grid fs-4 text-info me-3"></i>
        <div>
            <strong>Pelaksanaan & Input Nilai Asesmen:</strong>
            <div class="small text-muted">Lakukan pengujian atau pencatatan asesmen kompetensi mahasiswa berdasarkan instrumen dan butir pertanyaan yang telah dikonfigurasi.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Riwayat Pelaksanaan Asesmen Mahasiswa
                        </h5>
                        <small class="text-muted">Kelola sesi pengujian asesmen dan perbarui skor/jawaban butir soal</small>
                    </div>
                    <a href="{{ route('pelaksanaan-asesmen.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Input Pelaksanaan Asesmen Baru
                    </a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'pelaksanaanasesmen-table']) !!}
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
            const name = $(this).data('name') || 'asesmen ini';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data "${name}" akan dihapus beserta seluruh rincian jawabannya!`,
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
