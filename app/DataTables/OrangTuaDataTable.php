<?php

namespace App\DataTables;

use App\Models\OrangTua;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrangTuaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<OrangTua> $query Results from query() method.
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
            ->addColumn('ayah_info', function ($row) {
                $ayah = $row->nama_ayah ?: '-';
                $pekerjaan = $row->pekerjaan_ayah ? '<small class="text-muted d-block">(' . e($row->pekerjaan_ayah) . ')</small>' : '';
                return '<div>' . e($ayah) . $pekerjaan . '</div>';
            })
            ->addColumn('ibu_info', function ($row) {
                $ibu = $row->nama_ibu ?: '-';
                $pekerjaan = $row->pekerjaan_ibu ? '<small class="text-muted d-block">(' . e($row->pekerjaan_ibu) . ')</small>' : '';
                return '<div>' . e($ibu) . $pekerjaan . '</div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('orang-tua.edit', $row->id);
                $deleteUrl = route('orang-tua.destroy', $row->id);
                $mhsName = $row->mahasiswa ? $row->mahasiswa->nama : 'mahasiswa ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Data Orang Tua/Wali">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Orang Tua dari ' . e($mhsName) . '" title="Hapus Data">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['ayah_info', 'ibu_info', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<OrangTua>
     */
    public function query(OrangTua $model): QueryBuilder
    {
        return $model->newQuery()->with('mahasiswa')->select('orang_tuas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orangtua-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1, 'asc')
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data orang tua/wali...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data orang tua/wali tidak ditemukan',
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
                  ->title('NIM Mahasiswa')
                  ->addClass('align-middle fw-semibold'),
            Column::make('mahasiswa_nama')
                  ->data('mahasiswa.nama')
                  ->name('mahasiswa.nama')
                  ->title('Nama Mahasiswa')
                  ->addClass('align-middle'),
            Column::computed('ayah_info')
                  ->title('Data Ayah')
                  ->addClass('align-middle'),
            Column::computed('ibu_info')
                  ->title('Data Ibu')
                  ->addClass('align-middle'),
            Column::make('no_hp')
                  ->title('No. HP / WA')
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
        return 'OrangTua_' . date('YmdHis');
    }
}
