@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Data Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item active">Pengguna</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-people-fill me-2 text-primary"></i>Daftar Pengguna Sistem
                    </h5>
                    <a href="{{ route('pengguna.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
                    </a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle', 'id' => 'pengguna-table']) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Modal Ganti Password -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formChangePassword" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fs-6 fw-bold" id="modalChangePasswordLabel">
                        <i class="bi bi-key-fill text-info me-2"></i>Ganti Password Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3 text-muted">Ubah password untuk pengguna: <strong id="modalUserName" class="text-dark"></strong></p>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password" title="Lihat/Sembunyikan Password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle Show / Hide Password
        $(document).on('click', '.toggle-password', function() {
            const target = $($(this).data('target'));
            const icon = $(this).find('i');
            if (target.attr('type') === 'password') {
                target.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                target.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Handler Modal Ganti Password
        $(document).on('click', '.btn-change-password', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const url = "{{ url('pengguna') }}/" + userId + "/password";

            $('#formChangePassword').attr('action', url);
            $('#modalUserName').text(userName);
            $('#new_password').val('').attr('type', 'password');
            $('#modalChangePassword .toggle-password i').removeClass('bi-eye-slash').addClass('bi-eye');
            $('#modalChangePassword').modal('show');
        });

        // Handler Konfirmasi Hapus Data
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const name = $(this).data('name') || 'pengguna ini';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data pengguna "${name}" akan dihapus permanen!`,
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
