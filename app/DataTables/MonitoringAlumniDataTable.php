<?php

namespace App\DataTables;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MonitoringAlumniDataTable extends DataTable
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
            ->addColumn('nim', function ($row) {
                return $row->mahasiswa ? $row->mahasiswa->nim : '-';
            })
            ->addColumn('nama', function ($row) {
                return $row->mahasiswa ? $row->mahasiswa->nama : '-';
            })
            ->addColumn('prodi', function ($row) {
                return $row->mahasiswa && $row->mahasiswa->programStudi ? $row->mahasiswa->programStudi->program_studi : '-';
            })
            ->addColumn('pekerjaan_sekarang', function ($row) {
                return $row->pekerjaan_sekarang ?: '<span class="text-muted fst-italic">Belum Diisi</span>';
            })
            ->addColumn('instansi_tempat_kerja', function ($row) {
                return $row->instansi_tempat_kerja ?: '<span class="text-muted fst-italic">-</span>';
            })
            ->addColumn('status_tracer_badge', function ($row) {
                $hasTracer = $row->tracerStudies()->exists();
                if ($hasTracer) {
                    return '<span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i> Terisi</span>';
                }
                return '<span class="badge bg-secondary"><i class="bi bi-hourglass-split me-1"></i> Belum Isi</span>';
            })
            ->addColumn('kontak_info', function ($row) {
                $hp = $row->no_hp_aktif ? '<a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $row->no_hp_aktif) . '" target="_blank" class="badge bg-success me-1"><i class="bi bi-whatsapp"></i> ' . e($row->no_hp_aktif) . '</a>' : '';
                $email = $row->email_aktif ? '<span class="badge bg-light text-dark border"><i class="bi bi-envelope"></i> ' . e($row->email_aktif) . '</span>' : '';
                return $hp . $email ?: '<span class="text-muted">-</span>';
            })
            ->rawColumns(['pekerjaan_sekarang', 'instansi_tempat_kerja', 'status_tracer_badge', 'kontak_info'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Alumni>
     */
    public function query(Alumni $model): QueryBuilder
    {
        return $model->newQuery()->with(['mahasiswa.programStudi', 'tracerStudies'])->select('alumnis.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('monitoringalumni-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari monitoring alumni...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data monitoring alumni tidak ditemukan',
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
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle fw-semibold'),
            Column::make('nama')
                  ->title('Nama Alumni')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('prodi')
                  ->title('Program Studi')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::make('tahun_lulus')
                  ->title('Tahun Lulus')
                  ->addClass('text-center align-middle fw-semibold'),
            Column::computed('pekerjaan_sekarang')
                  ->title('Pekerjaan Terkini')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('instansi_tempat_kerja')
                  ->title('Instansi / Kantor')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('status_tracer_badge')
                  ->title('Tracer Study')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('kontak_info')
                  ->title('Kontak Alumni')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MonitoringAlumni_' . date('YmdHis');
    }
}
