<?php

namespace App\DataTables;

use App\Models\InstrumenAsesmen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InstrumenAsesmenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<InstrumenAsesmen> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('kategori_badge', function ($row) {
                $kat = strtolower($row->kategori);
                $badgeClass = 'bg-primary';

                if (str_contains($kat, 'soft')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains($kat, 'hard') || str_contains($kat, 'teknis')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains($kat, 'bahasa')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains($kat, 'leadership') || str_contains($kat, 'kepemimpinan')) {
                    $badgeClass = 'bg-warning text-dark';
                } elseif (str_contains($kat, 'digital')) {
                    $badgeClass = 'bg-dark text-white';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->kategori) . '</span>';
            })
            ->addColumn('status_badge', function ($row) {
                if ($row->status === 'Aktif') {
                    return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                }
                return '<span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('instrumen-asesmen.edit', $row->id);
                $deleteUrl = route('instrumen-asesmen.destroy', $row->id);
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Instrumen Asesmen">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($row->nama_instrumen) . '" title="Hapus Instrumen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['kategori_badge', 'status_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<InstrumenAsesmen>
     */
    public function query(InstrumenAsesmen $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('instrumenasesmen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari instrumen asesmen...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data instrumen asesmen tidak ditemukan',
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
            Column::make('nama_instrumen')
                  ->title('Nama Instrumen Asesmen')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::computed('kategori_badge')
                  ->title('Kategori')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::make('deskripsi')
                  ->title('Deskripsi')
                  ->defaultContent('-')
                  ->addClass('align-middle'),
            Column::computed('status_badge')
                  ->title('Status')
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
        return 'InstrumenAsesmen_' . date('YmdHis');
    }
}
