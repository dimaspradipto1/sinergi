<?php

namespace App\DataTables;

use App\Models\DokumenMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DokumenMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<DokumenMahasiswa> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('mahasiswa_nim', function ($row) {
                return $row->mahasiswa ? $row->mahasiswa->nim : '-';
            })
            ->addColumn('mahasiswa_nama', function ($row) {
                return $row->mahasiswa ? $row->mahasiswa->nama : '-';
            })
            ->addColumn('jenis_badge', function ($row) {
                $jenis = strtolower($row->jenis_dokumen);
                $badgeClass = 'bg-secondary';

                if (str_contains($jenis, 'disabilitas') || str_contains($jenis, 'medis') || str_contains($jenis, 'psikolog')) {
                    $badgeClass = 'bg-danger';
                } elseif (str_contains($jenis, 'identitas') || str_contains($jenis, 'ktp') || str_contains($jenis, 'kk')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains($jenis, 'akademik') || str_contains($jenis, 'ijazah') || str_contains($jenis, 'transkrip')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains($jenis, 'rekomendasi')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains($jenis, 'prestasi') || str_contains($jenis, 'sertifikat')) {
                    $badgeClass = 'bg-warning text-dark';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->jenis_dokumen) . '</span>';
            })
            ->addColumn('file_preview', function ($row) {
                if ($row->file_dokumen && file_exists(public_path('storage/' . $row->file_dokumen))) {
                    $url = asset('storage/' . $row->file_dokumen);
                    $ext = strtolower(pathinfo($row->file_dokumen, PATHINFO_EXTENSION));
                    $icon = $ext === 'pdf' ? 'bi-file-earmark-pdf text-danger' : 'bi-file-earmark-image text-primary';

                    return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-secondary" title="Buka Dokumen">
                                <i class="bi ' . $icon . ' me-1"></i> Lihat Berkas
                            </a>';
                }
                return '<span class="text-muted small">Tidak ada berkas</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('dokumen-mahasiswa.edit', $row->id);
                $deleteUrl = route('dokumen-mahasiswa.destroy', $row->id);
                $docName = $row->nama_dokumen ?: 'dokumen ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Dokumen">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($docName) . '" title="Hapus Dokumen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['jenis_badge', 'file_preview', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<DokumenMahasiswa>
     */
    public function query(DokumenMahasiswa $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa')->select('dokumen_mahasiswas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dokumenmahasiswa-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari dokumen...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data dokumen tidak ditemukan',
                            'paginate' => [
                                'first' => 'Awal',
                                'last' => 'Akhir',
                                'next' => 'Berikutnya',
                                'previous' => 'Sebelumnya',
                            ],
                        ],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                  ->title('No')
                  ->searchable(false)
                  ->orderable(false)
                  ->width(50)
                  ->addClass('text-center align-middle'),
            Column::make('mahasiswa_nim')
                  ->data('mahasiswa.nim')
                  ->name('mahasiswa.nim')
                  ->title('NIM')
                  ->defaultContent('-')
                  ->addClass('align-middle fw-semibold'),
            Column::make('mahasiswa_nama')
                  ->data('mahasiswa.nama')
                  ->name('mahasiswa.nama')
                  ->title('Nama Mahasiswa')
                  ->defaultContent('-')
                  ->addClass('align-middle'),
            Column::make('nama_dokumen')
                  ->data('nama_dokumen')
                  ->name('nama_dokumen')
                  ->title('Nama Dokumen')
                  ->addClass('align-middle'),
            Column::computed('jenis_badge')
                  ->title('Kategori / Jenis')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('file_preview')
                  ->title('Berkas')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DokumenMahasiswa_' . date('YmdHis');
    }
}
