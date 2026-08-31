<?php

namespace App\DataTables;

use App\Models\DokumenLulusan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DokumenLulusanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<DokumenLulusan> $query Results from query() method.
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
            ->addColumn('jenis_dokumen_badge', function ($row) {
                return '<span class="badge bg-primary">' . e($row->jenis_dokumen) . '</span>';
            })
            ->addColumn('tanggal_terbit_formatted', function ($row) {
                return $row->tanggal_terbit ? $row->tanggal_terbit->format('d/m/Y') : '-';
            })
            ->addColumn('file_preview', function ($row) {
                if ($row->file) {
                    $url = asset('storage/' . $row->file);
                    return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Berkas Dokumen">
                                <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Dokumen
                            </a>';
                }
                return '<span class="badge bg-light text-secondary border">Tidak Ada Berkas</span>';
            })
            ->addColumn('status_verifikasi_badge', function ($row) {
                $status = $row->status_verifikasi;
                $badgeClass = 'bg-secondary';

                if ($status === 'Terverifikasi') $badgeClass = 'bg-success';
                elseif ($status === 'Menunggu Verifikasi') $badgeClass = 'bg-warning text-dark';
                elseif ($status === 'Ditolak') $badgeClass = 'bg-danger';

                return '<span class="badge ' . $badgeClass . '">' . e($status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('dokumen-lulusan.edit', $row->id);
                $deleteUrl = route('dokumen-lulusan.destroy', $row->id);
                $name = $row->jenis_dokumen;
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
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($name) . '" title="Hapus Dokumen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['jenis_dokumen_badge', 'file_preview', 'status_verifikasi_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<DokumenLulusan>
     */
    public function query(DokumenLulusan $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa')->select('dokumen_lulusans.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dokumenlulusan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari dokumen kelulusan...',
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
            Column::computed('jenis_dokumen_badge')
                  ->title('Jenis Dokumen')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('nomor_dokumen')
                  ->title('Nomor Dokumen')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::computed('tanggal_terbit_formatted')
                  ->title('Tanggal Terbit')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('file_preview')
                  ->title('Berkas')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('status_verifikasi_badge')
                  ->title('Verifikasi')
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
        return 'DokumenLulusan_' . date('YmdHis');
    }
}
