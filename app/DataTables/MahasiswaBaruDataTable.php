<?php

namespace App\DataTables;

use App\Models\MahasiswaBaru;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MahasiswaBaruDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MahasiswaBaru> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('foto_preview', function ($row) {
                if ($row->foto && file_exists(public_path('storage/' . $row->foto))) {
                    return '<img src="' . asset('storage/' . $row->foto) . '" alt="Foto" class="rounded-circle" width="40" height="40" style="object-fit: cover;">';
                }
                return '<div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto text-secondary" style="width: 40px; height: 40px;"><i class="bi bi-person fs-5"></i></div>';
            })
            ->addColumn('prodi_nama', function ($row) {
                return $row->programStudi ? $row->programStudi->program_studi : '-';
            })
            ->addColumn('kelulusan_badge', function ($row) {
                return match ($row->status_kelulusan) {
                    'Diterima'       => '<span class="badge bg-success">Diterima</span>',
                    'Cadangan'       => '<span class="badge bg-warning text-dark">Cadangan</span>',
                    'Proses Seleksi' => '<span class="badge bg-info text-dark">Proses Seleksi</span>',
                    'Tidak Lulus'    => '<span class="badge bg-danger">Tidak Lulus</span>',
                    default          => '<span class="badge bg-secondary">' . e($row->status_kelulusan) . '</span>',
                };
            })
            ->addColumn('registrasi_badge', function ($row) {
                return match ($row->status_registrasi) {
                    'Registrasi Ulang'            => '<span class="badge bg-primary">Registrasi Ulang</span>',
                    'Belum Registrasi'            => '<span class="badge bg-warning text-dark">Belum Registrasi</span>',
                    'Batal / Mengundurkan Diri'   => '<span class="badge bg-danger">Batal</span>',
                    default                       => '<span class="badge bg-secondary">' . e($row->status_registrasi) . '</span>',
                };
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('mahasiswa-baru.edit', $row->id);
                $deleteUrl = route('mahasiswa-baru.destroy', $row->id);
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Mahasiswa Baru">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($row->nama_lengkap) . '" title="Hapus Mahasiswa Baru">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['foto_preview', 'kelulusan_badge', 'registrasi_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MahasiswaBaru>
     */
    public function query(MahasiswaBaru $model): QueryBuilder
    {
        return $model->newQuery()->with(['programStudi', 'tahunAkademik'])->select('mahasiswa_barus.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('mahasiswabaru-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2, 'desc')
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari mahasiswa baru...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data mahasiswa baru tidak ditemukan',
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
            Column::computed('foto_preview')
                  ->title('Foto')
                  ->searchable(false)
                  ->orderable(false)
                  ->width(60)
                  ->addClass('text-center align-middle'),
            Column::make('no_pendaftaran')
                  ->title('No. Pendaftaran')
                  ->addClass('align-middle fw-semibold'),
            Column::make('nama_lengkap')
                  ->title('Nama Lengkap')
                  ->addClass('align-middle'),
            Column::make('prodi_nama')
                  ->data('program_studi.program_studi')
                  ->name('programStudi.program_studi')
                  ->title('Pilihan Prodi')
                  ->addClass('align-middle'),
            Column::make('jalur_pendaftaran')
                  ->title('Jalur')
                  ->addClass('align-middle'),
            Column::computed('kelulusan_badge')
                  ->title('Status Seleksi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('registrasi_badge')
                  ->title('Status Registrasi')
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
        return 'MahasiswaBaru_' . date('YmdHis');
    }
}
