<?php

namespace App\DataTables;

use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PerusahaanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Perusahaan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('bidang_badge', function ($row) {
                return '<span class="badge bg-info text-dark">' . e($row->bidang) . '</span>';
            })
            ->addColumn('total_alumni_badge', function ($row) {
                $count = $row->karier_alumnis_count ?? $row->karierAlumnis()->count();
                return '<span class="badge bg-primary fs-6">' . $count . ' Alumni</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('perusahaan-mitra.edit', $row->id);
                $deleteUrl = route('perusahaan-mitra.destroy', $row->id);
                $name = $row->nama_perusahaan;
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Perusahaan">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($name) . '" title="Hapus Perusahaan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['bidang_badge', 'total_alumni_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Perusahaan>
     */
    public function query(Perusahaan $model): QueryBuilder
    {
        return $model->newQuery()->withCount('karierAlumnis')->select('perusahaans.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('perusahaan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari mitra perusahaan...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data perusahaan tidak ditemukan',
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
            Column::make('nama_perusahaan')
                  ->title('Nama Perusahaan / Instansi')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::computed('bidang_badge')
                  ->title('Bidang Industri')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('alamat')
                  ->title('Alamat Kantor')
                  ->addClass('align-middle'),
            Column::make('kontak')
                  ->title('Kontak / Narahubung')
                  ->addClass('align-middle'),
            Column::computed('total_alumni_badge')
                  ->title('Alumni Bekerja')
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
        return 'Perusahaan_' . date('YmdHis');
    }
}
