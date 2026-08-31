<?php

namespace App\DataTables;

use App\Models\KebutuhanInklusif;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KebutuhanInklusifDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<KebutuhanInklusif> $query Results from query() method.
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
            ->addColumn('kategori_badge', function ($row) {
                $kategori = strtolower($row->kategori);
                $badgeClass = 'bg-secondary';

                if (str_contains($kategori, 'sensorik') || str_contains($kategori, 'netra') || str_contains($kategori, 'rungu')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains($kategori, 'fisik') || str_contains($kategori, 'daksa')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains($kategori, 'intelektual') || str_contains($kategori, 'belajar')) {
                    $badgeClass = 'bg-warning text-dark';
                } elseif (str_contains($kategori, 'mental') || str_contains($kategori, 'psikososial')) {
                    $badgeClass = 'bg-purple text-white';
                } elseif (str_contains($kategori, 'ganda') || str_contains($kategori, 'kombinasi')) {
                    $badgeClass = 'bg-danger';
                } else {
                    $badgeClass = 'bg-success';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->kategori) . '</span>';
            })
            ->addColumn('layanan_info', function ($row) {
                return $row->layanan_pendukung ? nl2br(e($row->layanan_pendukung)) : '<span class="text-muted small">Belum ada layanan</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('kebutuhan-inklusif.edit', $row->id);
                $deleteUrl = route('kebutuhan-inklusif.destroy', $row->id);
                $mhsName = $row->mahasiswa ? $row->mahasiswa->nama : 'mahasiswa ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Data Kebutuhan Inklusif">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Kebutuhan Inklusif ' . e($mhsName) . '" title="Hapus Data">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['kategori_badge', 'layanan_info', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<KebutuhanInklusif>
     */
    public function query(KebutuhanInklusif $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa')->select('kebutuhan_inklusifs.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kebutuhaninklusif-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari kebutuhan inklusif...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data kebutuhan inklusif tidak ditemukan',
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
            Column::make('kebutuhan')
                  ->title('Ragam Kebutuhan Khusus')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::computed('kategori_badge')
                  ->title('Kategori')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('layanan_info')
                  ->title('Layanan & Akomodasi Pendukung')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
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
        return 'KebutuhanInklusif_' . date('YmdHis');
    }
}
