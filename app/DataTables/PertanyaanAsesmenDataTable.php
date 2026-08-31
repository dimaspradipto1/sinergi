<?php

namespace App\DataTables;

use App\Models\PertanyaanAsesmen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PertanyaanAsesmenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PertanyaanAsesmen> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('instrumen_nama', function ($row) {
                return $row->instrumenAsesmen ? $row->instrumenAsesmen->nama_instrumen : '-';
            })
            ->addColumn('tipe_badge', function ($row) {
                $tipe = strtolower($row->tipe_jawaban);
                $badgeClass = 'bg-primary';

                if (str_contains($tipe, 'likert') || str_contains($tipe, 'skala')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains($tipe, 'ganda') || str_contains($tipe, 'pilihan')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains($tipe, 'esai') || str_contains($tipe, 'teks')) {
                    $badgeClass = 'bg-warning text-dark';
                } elseif (str_contains($tipe, 'ya') || str_contains($tipe, 'boolean')) {
                    $badgeClass = 'bg-secondary';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->tipe_jawaban) . '</span>';
            })
            ->addColumn('bobot_badge', function ($row) {
                return '<span class="badge bg-dark">' . e($row->bobot) . ' Poin</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('pertanyaan-asesmen.edit', $row->id);
                $deleteUrl = route('pertanyaan-asesmen.destroy', $row->id);
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Pertanyaan">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Pertanyaan ini" title="Hapus Pertanyaan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['tipe_badge', 'bobot_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PertanyaanAsesmen>
     */
    public function query(PertanyaanAsesmen $model): QueryBuilder
    {
        return $model->newQuery()->with('instrumenAsesmen')->select('pertanyaan_asesmens.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pertanyaanasesmen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari pertanyaan asesmen...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data pertanyaan tidak ditemukan',
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
            Column::make('instrumen_nama')
                  ->data('instrumen_asesmen.nama_instrumen')
                  ->name('instrumenAsesmen.nama_instrumen')
                  ->title('Instrumen')
                  ->defaultContent('-')
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::make('pertanyaan')
                  ->title('Butir Pertanyaan Asesmen')
                  ->addClass('align-middle'),
            Column::computed('tipe_badge')
                  ->title('Tipe Jawaban')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('bobot_badge')
                  ->title('Bobot')
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
        return 'PertanyaanAsesmen_' . date('YmdHis');
    }
}
