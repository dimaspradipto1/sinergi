<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PenggunaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('role_badge', function ($user) {
                if ($user->role === 'superadmin') {
                    return '<span class="badge bg-danger">Super Admin</span>';
                } elseif ($user->role === 'admin') {
                    return '<span class="badge bg-primary">Admin</span>';
                } elseif ($user->role === 'pimpinan') {
                    return '<span class="badge bg-success">Pimpinan</span>';
                } else {
                    return '<span class="badge bg-secondary">' . ucfirst($user->role ?? 'User') . '</span>';
                }
            })
            ->addColumn('formatted_created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d M Y H:i') : '-';
            })
            ->addColumn('action', function ($user) {
                $editUrl = route('pengguna.edit', $user->id);
                $deleteUrl = route('pengguna.destroy', $user->id);
                $csrf = csrf_field();
                $methodDelete = method_field('DELETE');

                return '
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white" title="Edit Data Pengguna">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-info text-white btn-change-password" data-id="' . $user->id . '" data-name="' . e($user->name) . '" title="Ganti Password">
                        <i class="bi bi-key-fill"></i>
                    </button>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                        ' . $csrf . '
                        ' . $methodDelete . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="' . e($user->name) . '" title="Hapus Pengguna">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->rawColumns(['role_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->select('users.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengguna-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1, 'asc')
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'search' => '_INPUT_',
                            'searchPlaceholder' => 'Cari pengguna...',
                            'lengthMenu' => '_MENU_ data per halaman',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 data',
                            'infoFiltered' => '(disaring dari _MAX_ total data)',
                            'zeroRecords' => 'Data pengguna tidak ditemukan',
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
            Column::make('name')
                  ->title('Nama Pengguna')
                  ->addClass('align-middle'),
            Column::make('email')
                  ->title('Email')
                  ->addClass('align-middle'),
            Column::computed('role_badge')
                  ->title('Role')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('text-center align-middle'),
            Column::computed('formatted_created_at')
                  ->title('Terdaftar Pada')
                  ->searchable(false)
                  ->orderable(false)
                  ->addClass('align-middle'),
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
        return 'Pengguna_' . date('YmdHis');
    }
}
