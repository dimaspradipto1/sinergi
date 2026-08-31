<?php

namespace App\DataTables;

use App\Models\KarierAlumni;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KarierAlumniDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<KarierAlumni> $query Results from query() method.
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
            ->addColumn('nama_perusahaan', function ($row) {
                return $row->perusahaan ? $row->perusahaan->nama_perusahaan : '-';
            })
            ->addColumn('status_kerja_badge', function ($row) {
                $status = $row->status_kerja;
                $badgeClass = 'bg-secondary';

                if (str_contains(strtolower($status), 'tetap')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains(strtolower($status), 'kontrak')) {
                    $badgeClass = 'bg-primary';
                } elseif (str_contains(strtolower($status), 'freelance') || str_contains(strtolower($status), 'paruh')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains(strtolower($status), 'owner') || str_contains(strtolower($status), 'founder')) {
                    $badgeClass = 'bg-dark';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($status) . '</span>';
            })
            ->addColumn('tanggal_mulai_formatted', function ($row) {
                return $row->tanggal_mulai ? $row->tanggal_mulai->format('d/m/Y') : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('riwayat-karier.edit', $row->id);
                $deleteUrl = route('riwayat-karier.destroy', $row->id);
                $name = $row->alumni && $row->alumni->mahasiswa ? $row->alumni->mahasiswa->nama : 'Karier ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Riwayat Karier">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Karier ' . e($name) . '" title="Hapus Riwayat Karier">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['status_kerja_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<KarierAlumni>
     */
    public function query(KarierAlumni $model): QueryBuilder
    {
        return $model->newQuery()->with(['alumni.mahasiswa.programStudi', 'perusahaan'])->select('karier_alumnis.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('karieralumni-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari riwayat karier alumni...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data riwayat karier tidak ditemukan',
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
            Column::make('nama_perusahaan')
                  ->title('Perusahaan / Instansi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle fw-semibold text-primary'),
            Column::make('jabatan')
                  ->title('Jabatan / Posisi')
                  ->addClass('align-middle'),
            Column::computed('status_kerja_badge')
                  ->title('Status Kerja')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('tanggal_mulai_formatted')
                  ->title('Tanggal Mulai')
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
        return 'KarierAlumni_' . date('YmdHis');
    }
}
