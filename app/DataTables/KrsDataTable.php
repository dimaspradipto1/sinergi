<?php

namespace App\DataTables;

use App\Models\Krs;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KrsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Krs> $query Results from query() method.
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
            ->addColumn('tahun_akademik_badge', function ($row) {
                return '<span class="badge bg-primary">' . e($row->tahun_akademik) . '</span>';
            })
            ->addColumn('semester_badge', function ($row) {
                return '<span class="badge bg-info text-dark">Semester ' . e($row->semester) . '</span>';
            })
            ->addColumn('total_matkul', function ($row) {
                return '<span class="badge bg-secondary">' . $row->nilaiMahasiswas->count() . ' Matkul</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('krs.edit', $row->id);
                $deleteUrl = route('krs.destroy', $row->id);
                $mhsName = $row->mahasiswa ? $row->mahasiswa->nama : 'KRS ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit KRS">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="KRS ' . e($mhsName) . '" title="Hapus KRS">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['tahun_akademik_badge', 'semester_badge', 'total_matkul', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Krs>
     */
    public function query(Krs $model): QueryBuilder
    {
        return $model->newQuery()->with(['mahasiswa.programStudi', 'nilaiMahasiswas'])->select('krs.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('krs-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data KRS...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data KRS tidak ditemukan',
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
            Column::computed('tahun_akademik_badge')
                  ->title('Tahun Akademik')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('semester_badge')
                  ->title('Semester')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('total_matkul')
                  ->title('Jumlah Matkul')
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
        return 'Krs_' . date('YmdHis');
    }
}
