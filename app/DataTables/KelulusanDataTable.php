<?php

namespace App\DataTables;

use App\Models\Kelulusan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KelulusanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Kelulusan> $query Results from query() method.
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
            ->addColumn('prodi_nama', function ($row) {
                return $row->mahasiswa && $row->mahasiswa->programStudi ? $row->mahasiswa->programStudi->program_studi : '-';
            })
            ->addColumn('tanggal_lulus_formatted', function ($row) {
                return $row->tanggal_lulus ? $row->tanggal_lulus->format('d/m/Y') : '-';
            })
            ->addColumn('ipk_badge', function ($row) {
                return '<span class="badge bg-primary fs-6 fw-bold">' . number_format($row->ipk_kelulusan, 2) . '</span>';
            })
            ->addColumn('predikat_badge', function ($row) {
                $pred = strtolower($row->predikat);
                $badgeClass = 'bg-secondary';

                if (str_contains($pred, 'pujian') || str_contains($pred, 'cumlaude')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains($pred, 'sangat memuaskan')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains($pred, 'memuaskan')) {
                    $badgeClass = 'bg-info text-dark';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->predikat) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('data-kelulusan.edit', $row->id);
                $deleteUrl = route('data-kelulusan.destroy', $row->id);
                $name = $row->mahasiswa ? $row->mahasiswa->nama : 'Data kelulusan';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Kelulusan">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Kelulusan ' . e($name) . '" title="Hapus Kelulusan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['ipk_badge', 'predikat_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Kelulusan>
     */
    public function query(Kelulusan $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa.programStudi')->select('kelulusans.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kelulusan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data kelulusan...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data kelulusan tidak ditemukan',
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
            Column::make('prodi_nama')
                  ->title('Program Studi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('nomor_sk_yudisium')
                  ->title('Nomor SK Yudisium')
                  ->addClass('align-middle'),
            Column::computed('ipk_badge')
                  ->title('IPK')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('predikat_badge')
                  ->title('Predikat')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('tanggal_lulus_formatted')
                  ->title('Tanggal Lulus')
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
        return 'Kelulusan_' . date('YmdHis');
    }
}
