<?php

namespace App\DataTables;

use App\Models\TracerStudy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TracerStudyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<TracerStudy> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('alumni_nim', function ($row) {
                return $row->alumni && $row->alumni->mahasiswa ? $row->alumni->mahasiswa->nim : '-';
            })
            ->addColumn('alumni_nama', function ($row) {
                return $row->alumni && $row->alumni->mahasiswa ? $row->alumni->mahasiswa->nama : '-';
            })
            ->addColumn('prodi_nama', function ($row) {
                return $row->alumni && $row->alumni->mahasiswa && $row->alumni->mahasiswa->programStudi
                    ? $row->alumni->mahasiswa->programStudi->program_studi
                    : '-';
            })
            ->addColumn('status_pekerjaan_badge', function ($row) {
                $status = $row->status_pekerjaan;
                $badgeClass = 'bg-secondary';

                if (str_contains(strtolower($status), 'full-time') || str_contains(strtolower($status), 'tetap')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains(strtolower($status), 'part-time') || str_contains(strtolower($status), 'wirausaha') || str_contains(strtolower($status), 'mandiri')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains(strtolower($status), 'studi')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains(strtolower($status), 'mencari') || str_contains(strtolower($status), 'belum')) {
                    $badgeClass = 'bg-warning text-dark';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($status) . '</span>';
            })
            ->addColumn('waktu_tunggu_formatted', function ($row) {
                return '<span class="badge bg-light text-dark border">' . $row->waktu_tunggu . ' Bulan</span>';
            })
            ->addColumn('relevansi_badge', function ($row) {
                $rel = $row->relevansi_bidang;
                $color = $rel >= 75 ? 'bg-success' : ($rel >= 50 ? 'bg-primary' : 'bg-secondary');
                return '<span class="badge ' . $color . '">' . $rel . '%</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('tracer-study.edit', $row->id);
                $deleteUrl = route('tracer-study.destroy', $row->id);
                $name = $row->alumni && $row->alumni->mahasiswa ? $row->alumni->mahasiswa->nama : 'Tracer Study ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Tracer Study">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Tracer Study ' . e($name) . '" title="Hapus Tracer Study">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['status_pekerjaan_badge', 'waktu_tunggu_formatted', 'relevansi_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<TracerStudy>
     */
    public function query(TracerStudy $model): QueryBuilder
    {
        return $model->newQuery()->with(['alumni.mahasiswa.programStudi'])->select('tracer_studies.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tracerstudy-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data tracer study...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data tracer study tidak ditemukan',
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
            Column::make('alumni_nim')
                  ->title('NIM')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle fw-semibold'),
            Column::make('alumni_nama')
                  ->title('Nama Alumni')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('prodi_nama')
                  ->title('Program Studi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('tahun_survey')
                  ->title('Tahun Survey')
                  ->addClass('text-center align-middle fw-semibold'),
            Column::computed('status_pekerjaan_badge')
                  ->title('Status Pekerjaan')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('waktu_tunggu_formatted')
                  ->title('Masa Tunggu')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('relevansi_badge')
                  ->title('Relevansi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::make('pendapatan')
                  ->title('Pendapatan')
                  ->addClass('align-middle text-primary fw-semibold'),
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
        return 'TracerStudy_' . date('YmdHis');
    }
}
