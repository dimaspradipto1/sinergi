<?php

namespace App\DataTables;

use App\Models\Wisuda;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WisudaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Wisuda> $query Results from query() method.
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
            ->addColumn('tanggal_wisuda_formatted', function ($row) {
                return $row->tanggal_wisuda ? $row->tanggal_wisuda->format('d/m/Y') : '-';
            })
            ->addColumn('status_kehadiran_badge', function ($row) {
                $status = $row->status_kehadiran;
                $badgeClass = 'bg-secondary';

                if ($status === 'Hadir') $badgeClass = 'bg-success';
                elseif ($status === 'Terdaftar') $badgeClass = 'bg-primary';
                elseif ($status === 'Tidak Hadir') $badgeClass = 'bg-danger';

                return '<span class="badge ' . $badgeClass . '">' . e($status) . '</span>';
            })
            ->addColumn('kursi_badge', function ($row) {
                return $row->nomor_kursi ? '<span class="badge bg-dark">' . e($row->nomor_kursi) . '</span>' : '<span class="text-muted">-</span>';
            })
            ->addColumn('kebutuhan_khusus_wisuda', function ($row) {
                return $row->kebutuhan_khusus_wisuda ? e($row->kebutuhan_khusus_wisuda) : '<span class="text-muted fst-italic">Standar</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('wisuda.edit', $row->id);
                $deleteUrl = route('wisuda.destroy', $row->id);
                $name = $row->mahasiswa ? $row->mahasiswa->nama : 'Wisuda ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Wisuda">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Wisuda ' . e($name) . '" title="Hapus Wisuda">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['status_kehadiran_badge', 'kursi_badge', 'kebutuhan_khusus_wisuda', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Wisuda>
     */
    public function query(Wisuda $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa')->select('wisudas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('wisuda-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data wisuda...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data wisuda tidak ditemukan',
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
            Column::make('periode_wisuda')
                  ->title('Periode Wisuda')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::computed('tanggal_wisuda_formatted')
                  ->title('Tanggal Wisuda')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('kursi_badge')
                  ->title('No Kursi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('status_kehadiran_badge')
                  ->title('Status')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('kebutuhan_khusus_wisuda')
                  ->title('Aksesibilitas / Kebutuhan Wisuda')
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
        return 'Wisuda_' . date('YmdHis');
    }
}
