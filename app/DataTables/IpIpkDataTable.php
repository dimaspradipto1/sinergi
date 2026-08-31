<?php

namespace App\DataTables;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IpIpkDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Mahasiswa> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('prodi_nama', function ($row) {
                return $row->programStudi ? $row->programStudi->program_studi : '-';
            })
            ->addColumn('total_sks', function ($row) {
                $totalSks = 0;
                foreach ($row->krs as $krsItem) {
                    foreach ($krsItem->nilaiMahasiswas as $nilai) {
                        if ($nilai->mataKuliah) {
                            $totalSks += $nilai->mataKuliah->sks;
                        }
                    }
                }
                return '<span class="badge bg-secondary">' . $totalSks . ' SKS</span>';
            })
            ->addColumn('ipk_badge', function ($row) {
                $totalMutu = 0;
                $totalSks = 0;

                foreach ($row->krs as $krsItem) {
                    foreach ($krsItem->nilaiMahasiswas as $nilai) {
                        if ($nilai->mataKuliah) {
                            $sks = $nilai->mataKuliah->sks;
                            $bobot = $nilai->bobot;
                            $totalMutu += ($sks * $bobot);
                            $totalSks += $sks;
                        }
                    }
                }

                $ipk = $totalSks > 0 ? round($totalMutu / $totalSks, 2) : 0.00;
                $badgeClass = 'bg-secondary';

                if ($ipk >= 3.5) $badgeClass = 'bg-success';
                elseif ($ipk >= 3.0) $badgeClass = 'bg-primary';
                elseif ($ipk >= 2.5) $badgeClass = 'bg-info text-dark';
                elseif ($ipk >= 2.0) $badgeClass = 'bg-warning text-dark';
                elseif ($ipk > 0) $badgeClass = 'bg-danger';

                return '<span class="badge ' . $badgeClass . ' fs-6 fw-bold">' . number_format($ipk, 2) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('ip-ipk.show', $row->id);

                return '
                <div class="d-flex justify-content-center align-items-center">
                    <a href="' . $showUrl . '" class="btn btn-sm btn-primary" title="Lihat Rekap Transkrip Nilai">
                        <i class="bi bi-file-earmark-text me-1"></i> Rincian IP / IPK
                    </a>
                </div>';
            })
            ->rawColumns(['total_sks', 'ipk_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Mahasiswa>
     */
    public function query(Mahasiswa $model): QueryBuilder
    {
        return $model->newQuery()->with(['programStudi', 'krs.nilaiMahasiswas.mataKuliah'])->select('mahasiswas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('ipipk-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari mahasiswa...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data tidak ditemukan',
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
            Column::make('nim')
                  ->title('NIM')
                  ->addClass('align-middle fw-semibold'),
            Column::make('nama')
                  ->title('Nama Mahasiswa')
                  ->addClass('align-middle'),
            Column::make('prodi_nama')
                  ->title('Program Studi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('total_sks')
                  ->title('Total SKS Diambil')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('ipk_badge')
                  ->title('IPK Kumulatif')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'IpIpk_' . date('YmdHis');
    }
}
