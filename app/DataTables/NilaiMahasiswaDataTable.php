<?php

namespace App\DataTables;

use App\Models\NilaiMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NilaiMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<NilaiMahasiswa> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('mahasiswa_nim', function ($row) {
                return $row->krs && $row->krs->mahasiswa ? $row->krs->mahasiswa->nim : '-';
            })
            ->addColumn('mahasiswa_nama', function ($row) {
                return $row->krs && $row->krs->mahasiswa ? $row->krs->mahasiswa->nama : '-';
            })
            ->addColumn('matkul_detail', function ($row) {
                if (!$row->mataKuliah) return '-';
                return '<strong>' . e($row->mataKuliah->kode_matkul) . '</strong> - ' . e($row->mataKuliah->nama_matkul) . ' <span class="badge bg-secondary">' . $row->mataKuliah->sks . ' SKS</span>';
            })
            ->addColumn('periode', function ($row) {
                if (!$row->krs) return '-';
                return e($row->krs->tahun_akademik) . ' (Sem ' . $row->krs->semester . ')';
            })
            ->addColumn('nilai_angka_formatted', function ($row) {
                return '<span class="fw-bold">' . number_format($row->nilai_angka, 1) . '</span>';
            })
            ->addColumn('nilai_huruf_badge', function ($row) {
                $huruf = strtoupper($row->nilai_huruf ?? 'E');
                $badgeClass = 'bg-secondary';

                if ($huruf === 'A') $badgeClass = 'bg-success';
                elseif (in_array($huruf, ['B+', 'B'])) $badgeClass = 'bg-primary';
                elseif (in_array($huruf, ['C+', 'C'])) $badgeClass = 'bg-warning text-dark';
                elseif ($huruf === 'D') $badgeClass = 'bg-danger';

                return '<span class="badge ' . $badgeClass . ' fs-6 px-2">' . e($huruf) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('nilai-mahasiswa.edit', $row->id);
                $deleteUrl = route('nilai-mahasiswa.destroy', $row->id);
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Nilai">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="Nilai ini" title="Hapus Nilai">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['matkul_detail', 'nilai_angka_formatted', 'nilai_huruf_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<NilaiMahasiswa>
     */
    public function query(NilaiMahasiswa $model): QueryBuilder
    {
        return $model->newQuery()->with(['krs.mahasiswa', 'mataKuliah'])->select('nilai_mahasiswas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('nilaimahasiswa-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orders([])
                    ->parameters([
                        'order' => [],
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari nilai mahasiswa...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data nilai tidak ditemukan',
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
                  ->data('krs.mahasiswa.nim')
                  ->name('krs.mahasiswa.nim')
                  ->title('NIM')
                  ->defaultContent('-')
                  ->addClass('align-middle fw-semibold'),
            Column::make('mahasiswa_nama')
                  ->data('krs.mahasiswa.nama')
                  ->name('krs.mahasiswa.nama')
                  ->title('Nama Mahasiswa')
                  ->defaultContent('-')
                  ->addClass('align-middle'),
            Column::computed('matkul_detail')
                  ->title('Mata Kuliah')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
            Column::computed('periode')
                  ->title('T.A & Semester')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('nilai_angka_formatted')
                  ->title('Nilai Angka')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('nilai_huruf_badge')
                  ->title('Nilai Huruf')
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
        return 'NilaiMahasiswa_' . date('YmdHis');
    }
}
