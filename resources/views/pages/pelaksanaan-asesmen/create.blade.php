@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pelaksanaan Asesmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Asesmen Kompetensi</li>
            <li class="breadcrumb-item"><a href="{{ route('pelaksanaan-asesmen.index') }}">Pelaksanaan Asesmen</a></li>
            <li class="breadcrumb-item active">Input Asesmen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 p-0 fs-6 fw-bold">
                        <i class="bi bi-ui-checks-grid me-2 text-primary"></i>Form Pengujian / Input Nilai Asesmen Kompetensi
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('pelaksanaan-asesmen.store') }}" method="POST" id="form-asesmen">
                        @csrf

                        <div class="row mb-4">
                            <!-- Pilihan Mahasiswa -->
                            <div class="col-md-5 mb-3">
                                <label for="mahasiswa_id" class="form-label fw-semibold">Pilih Mahasiswa <span class="text-danger">*</span></label>
                                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select select2 @error('mahasiswa_id') is-invalid @enderror" data-placeholder="-- Cari NIM atau Nama Mahasiswa --" required>
                                    <option value="" disabled {{ old('mahasiswa_id') ? '' : 'selected' }}>-- Cari NIM atau Nama Mahasiswa --</option>
                                    @foreach($mahasiswa as $mhs)
                                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                            {{ $mhs->nim }} - {{ $mhs->nama }} ({{ $mhs->programStudi->program_studi ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilihan Instrumen Asesmen -->
                            <div class="col-md-4 mb-3">
                                <label for="instrumen_asesmen_id" class="form-label fw-semibold">Instrumen Asesmen <span class="text-danger">*</span></label>
                                <select name="instrumen_asesmen_id" id="instrumen_asesmen_id" class="form-select @error('instrumen_asesmen_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('instrumen_asesmen_id') ? '' : 'selected' }}>-- Pilih Instrumen Asesmen --</option>
                                    @foreach($instrumen as $ins)
                                        <option value="{{ $ins->id }}" {{ old('instrumen_asesmen_id') == $ins->id ? 'selected' : '' }}>
                                            {{ $ins->nama_instrumen }} (Kategori: {{ $ins->kategori }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('instrumen_asesmen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pelaksanaan -->
                            <div class="col-md-3 mb-3">
                                <label for="tanggal" class="form-label fw-semibold">Tanggal Asesmen <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Area Butir Pertanyaan Dinamis -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-dark">
                                    <i class="bi bi-list-task me-2 text-primary"></i>Daftar Pertanyaan & Input Penilaian Asesmen
                                </h6>
                                <span class="badge bg-primary" id="total-soal-badge">0 Butir Soal</span>
                            </div>
                            <div class="card-body p-3" id="container-pertanyaan">
                                <div class="text-center py-4 text-muted" id="placeholder-pertanyaan">
                                    <i class="bi bi-arrow-up-circle fs-3 text-secondary d-block mb-2"></i>
                                    Silakan pilih <strong>Instrumen Asesmen</strong> di atas untuk memuat butir-butir pertanyaan.
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Asesor -->
                        <div class="mb-4">
                            <label for="catatan_asesor" class="form-label fw-semibold">Catatan / Rekomendasi Asesor (Opsional)</label>
                            <textarea name="catatan_asesor" id="catatan_asesor" rows="3" class="form-control @error('catatan_asesor') is-invalid @enderror" placeholder="Catatan hasil observasi, kelebihan, atau rekomendasi tindak lanjut bagi mahasiswa...">{{ old('catatan_asesor') }}</textarea>
                            @error('catatan_asesor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pelaksanaan-asesmen.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" id="btn-submit-asesmen">
                                <i class="bi bi-check-circle me-1"></i> Simpan & Hitung Hasil Asesmen
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Event saat instrumen asesmen dipilih
        $('#instrumen_asesmen_id').on('change', function() {
            const instrumenId = $(this).val();
            if (!instrumenId) return;

            $('#container-pertanyaan').html(`
                <div class="text-center py-4 text-muted">
                    <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                    Memuat butir pertanyaan asesmen...
                </div>
            `);

            $.ajax({
                url: "{{ route('pelaksanaan-asesmen.get-pertanyaan') }}",
                type: "GET",
                data: { instrumen_id: instrumenId },
                success: function(data) {
                    if (data.length === 0) {
                        $('#total-soal-badge').text('0 Butir Soal');
                        $('#container-pertanyaan').html(`
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>Belum ada pertanyaan pada instrumen ini. Silakan tambahkan pertanyaan pada menu <strong>Bank Pertanyaan</strong> terlebih dahulu.
                            </div>
                        `);
                        return;
                    }

                    $('#total-soal-badge').text(`${data.length} Butir Soal`);

                    let html = '<div class="accordion" id="accordionPertanyaan">';
                    data.forEach(function(item, index) {
                        const no = index + 1;
                        let inputHtml = '';

                        const tipe = (item.tipe_jawaban || '').toLowerCase();

                        if (tipe.includes('likert')) {
                            inputHtml = `
                                <div class="row align-items-center mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Skala Penilaian (1 = Sangat Kurang, 5 = Sangat Baik):</label>
                                        <select name="skor[${item.id}]" class="form-select form-select-sm skor-input" required>
                                            <option value="5">5 - Sangat Baik / Mahir</option>
                                            <option value="4" selected>4 - Baik / Kompeten</option>
                                            <option value="3">3 - Cukup / Rata-rata</option>
                                            <option value="2">2 - Kurang</option>
                                            <option value="1">1 - Sangat Kurang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Catatan / Jawaban Deskriptif (Opsional):</label>
                                        <input type="text" name="jawaban[${item.id}]" class="form-control form-control-sm" placeholder="Catatan observasi butir ini">
                                    </div>
                                </div>
                            `;
                        } else if (tipe.includes('ya') || tipe.includes('boolean')) {
                            inputHtml = `
                                <div class="row align-items-center mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Pilihan Jawaban:</label>
                                        <select name="jawaban[${item.id}]" class="form-select form-select-sm" required>
                                            <option value="Ya" selected>Ya (Memenuhi)</option>
                                            <option value="Tidak">Tidak (Belum Memenuhi)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Skor Poin:</label>
                                        <input type="number" name="skor[${item.id}]" class="form-control form-control-sm skor-input" value="${item.bobot || 1}" min="0" required>
                                    </div>
                                </div>
                            `;
                        } else {
                            inputHtml = `
                                <div class="row align-items-center mt-2">
                                    <div class="col-md-7">
                                        <label class="form-label small text-muted mb-1">Jawaban / Respon Mahasiswa:</label>
                                        <textarea name="jawaban[${item.id}]" rows="2" class="form-control form-control-sm" placeholder="Tuliskan jawaban atau hasil tes"></textarea>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small text-muted mb-1">Skor Penilaian (Bobot Max: ${item.bobot || 10}):</label>
                                        <input type="number" name="skor[${item.id}]" class="form-control form-control-sm skor-input" value="${item.bobot || 10}" min="0" required>
                                    </div>
                                </div>
                            `;
                        }

                        html += `
                            <div class="border rounded p-3 mb-3 bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary me-2">No. ${no}</span>
                                        <span class="fw-semibold text-dark">${item.pertanyaan}</span>
                                    </div>
                                    <span class="badge bg-secondary">${item.tipe_jawaban}</span>
                                </div>
                                ${inputHtml}
                            </div>
                        `;
                    });

                    html += '</div>';
                    $('#container-pertanyaan').html(html);
                },
                error: function() {
                    $('#container-pertanyaan').html(`
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle me-2"></i>Gagal memuat pertanyaan. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        });

        // Trigger change if old value exists
        if ($('#instrumen_asesmen_id').val()) {
            $('#instrumen_asesmen_id').trigger('change');
        }
    });
</script>
@endpush
