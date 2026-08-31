<?php

namespace App\DataTables;

use App\Models\AsesmenMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PelaksanaanAsesmenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<AsesmenMahasiswa> $query Results from query() method.
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
            ->addColumn('instrumen_nama', function ($row) {
                return $row->instrumenAsesmen ? $row->instrumenAsesmen->nama_instrumen : '-';
            })
            ->addColumn('tanggal_formatted', function ($row) {
                return $row->tanggal ? $row->tanggal->format('d/m/Y') : '-';
            })
            ->addColumn('nilai_total_badge', function ($row) {
                return '<span class="badge bg-primary fs-6 fw-bold">' . number_format($row->nilai_total, 1) . '</span>';
            })
            ->addColumn('kategori_badge', function ($row) {
                $kat = strtolower($row->kategori ?? '');
                $badgeClass = 'bg-secondary';

                if (str_contains($kat, 'sangat') || str_contains($kat, 'mahir') || str_contains($kat, 'a')) {
                    $badgeClass = 'bg-success';
                } elseif (str_contains($kat, 'kompeten') || str_contains($kat, 'baik') || str_contains($kat, 'b')) {
                    $badgeClass = 'bg-info text-dark';
                } elseif (str_contains($kat, 'cukup') || str_contains($kat, 'c')) {
                    $badgeClass = 'bg-warning text-dark';
                } elseif (str_contains($kat, 'perlu') || str_contains($kat, 'kurang') || str_contains($kat, 'd')) {
                    $badgeClass = 'bg-danger';
                }

                return '<span class="badge ' . $badgeClass . '">' . e($row->kategori ?: 'Belum Dinilai') . '</span>';
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('hasil-asesmen.show', $row->id);
                $editUrl = route('pelaksanaan-asesmen.edit', $row->id);
                $deleteUrl = route('pelaksanaan-asesmen.destroy', $row->id);
                $mhsName = $row->mahasiswa ? $row->mahasiswa->nama : 'asesmen ini';
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $showUrl . '" class="btn btn-sm btn-info text-white" title="Lihat Hasil & Rapor Asesmen">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Jawaban / Skor">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Asesmen ' . e($mhsName) . '" title="Hapus Asesmen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['nilai_total_badge', 'kategori_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<AsesmenMahasiswa>
     */
    public function query(AsesmenMahasiswa $model): QueryBuilder
    {
        return $model->newQuery()->with(['mahasiswa', 'instrumenAsesmen'])->select('asesmen_mahasiswas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pelaksanaanasesmen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari pelaksanaan asesmen...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data pelaksanaan asesmen tidak ditemukan',
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
            Column::make('instrumen_nama')
                  ->data('instrumen_asesmen.nama_instrumen')
                  ->name('instrumenAsesmen.nama_instrumen')
                  ->title('Instrumen Asesmen')
                  ->defaultContent('-')
                  ->addClass('align-middle text-primary fw-semibold'),
            Column::computed('tanggal_formatted')
                  ->title('Tanggal Asesmen')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('nilai_total_badge')
                  ->title('Skor Akhir')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('kategori_badge')
                  ->title('Kategori Capaian')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(140)
                  ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PelaksanaanAsesmen_' . date('YmdHis');
    }
}
