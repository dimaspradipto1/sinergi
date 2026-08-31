<?php

namespace App\DataTables;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AlumniDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Alumni> $query Results from query() method.
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
            ->addColumn('prodi_info', function ($row) {
                return $row->mahasiswa && $row->mahasiswa->programStudi ? $row->mahasiswa->programStudi->program_studi : '-';
            })
            ->addColumn('tahun_badge', function ($row) {
                return '<span class="badge bg-primary fs-6">' . e($row->tahun_lulus) . '</span>';
            })
            ->addColumn('kontak_info', function ($row) {
                $email = $row->email_aktif ? '<div><i class="bi bi-envelope text-primary me-1"></i>' . e($row->email_aktif) . '</div>' : '';
                $hp = $row->no_hp_aktif ? '<div><i class="bi bi-whatsapp text-success me-1"></i>' . e($row->no_hp_aktif) . '</div>' : '';
                return $email || $hp ? $email . $hp : '<span class="text-muted small">-</span>';
            })
            ->addColumn('karir_info', function ($row) {
                $pekerjaan = $row->pekerjaan_sekarang ?: 'Belum Bekerja / Wirausaha';
                $instansi = $row->instansi_tempat_kerja ? '<small class="text-muted d-block">' . e($row->instansi_tempat_kerja) . '</small>' : '';
                return '<div>' . e($pekerjaan) . $instansi . '</div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('alumni.edit', $row->id);
                $deleteUrl = route('alumni.destroy', $row->id);
                $mhsName = $row->mahasiswa ? $row->mahasiswa->nama : 'alumni ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Data Alumni">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Alumni ' . e($mhsName) . '" title="Hapus Data Alumni">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['tahun_badge', 'kontak_info', 'karir_info', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Alumni>
     */
    public function query(Alumni $model): QueryBuilder
    {
        return $model->newQuery()->with(['mahasiswa', 'mahasiswa.programStudi'])->select('alumnis.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('alumni-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari data alumni...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data alumni tidak ditemukan',
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
                  ->title('Nama Alumni')
                  ->defaultContent('-')
                  ->addClass('align-middle'),
            Column::make('prodi_info')
                  ->title('Program Studi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('tahun_badge')
                  ->title('Tahun Lulus')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('kontak_info')
                  ->title('Kontak')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('karir_info')
                  ->title('Pekerjaan / Instansi')
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
        return 'Alumni_' . date('YmdHis');
    }
}
