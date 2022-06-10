<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $printPreview = 'users.prints';
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('status', function (User $model) {
                if ($model->status == 1) {
                    $status = '<i class="fas fa-toggle-on" style="color: green;"></i>';
                } else {
                    $status = '<i class="fas fa-toggle-off" style="color: red;"></i>';
                }
                return $status;
            })
            ->addColumn('action', 'users.action')
            ->rawColumns(['action', 'status', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $model = User::query();
        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');


        if (\request('start_date') & \request('end_date')) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $model = User::query()
            ->whereRaw("date(users.created_at) >= '" . $start_date . "' AND date(users.created_at) <= '" .$end_date . "'");
        }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(4)
            ->parameters([
                'responsive' => 'true',
                'serverSide' => 'true',
                'processing' => 'true',
                'deferRender' => 'true',
                'bSortClasses' => 'false',

                'paginate' => 'true',
                'pagingType' => 'simple',
                'language' => [
                    // 'url' => 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json',
                    'emptyTable' => 'Tidak ada data yang tersedia',
                    'info' => ' _START_ sampai _END_ dari _TOTAL_ data',
                    'paginate' => [
                        'next' => '<i class="fas fa-arrow-right"></i>',
                        'previous' => '<i class="fas fa-arrow-left"></i>',
                    ],
                    'search' => 'Cari:',

                ],
                'buttons' =>
                [
                    [
                        'extend' => 'create',
                        'text' => '<i class="fas fa-plus"></i> ' . 'Add',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'export',
                        'text' => '<i class="fas fa-download"></i> ' . 'Download',
                        'className' => 'btn btn-dark',
                        'buttons' =>
                        [
                            [
                                'extend' => 'csv',
                                'text' => '<i class="fas fa-file-csv"></i> ' . 'CSV',
                                'className' => 'btn btn-dark',
                            ],
                            [
                                'extend' => 'excel',
                                'text' => '<i class="fas fa-file-excel"></i> ' . 'EXCEL',
                                'className' => 'btn btn-dark',
                            ],
                            [
                                'extend' => 'pdf',
                                'text' => '<i class="fas fa-file-pdf"></i> ' . 'PDF',
                                'className' => 'btn btn-dark',
                            ],
                        ],
                    ],
                    // [
                    //     'extend' => 'print',
                    //     'text' => '<i class="fas fa-print"></i> ' . 'Print',
                    //     'className' => 'btn btn-dark',
                    //     'exportOptions' =>
                    //     [
                    //         'columns' => ':visible',
                    //     ],


                    // ],
                    [
                        'extend' => 'reset',
                        'text' => '<i class="fas fa-undo"></i> ' . 'Reset',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'reload',
                        'text' => '<i class="fas fa-sync-alt"></i> ' . 'Reload',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'colvis',
                        'text' => '<i class="fas fa-columns"></i> ' . 'Hide',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'pageLength',
                        'text' => '<i class="fas fa-list-ol"></i> ' . 'Rows',
                        'className' => 'btn btn-dark',
                    ],

                    [
                        'extend' => 'copy',
                        'text' => '<i class="fas fa-copy"></i> ' . 'Copy',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'selectAll',
                        'text' => '<i class="fas fa-copy"></i> ' . 'selectAll',
                        'className' => 'btn btn-dark',
                    ],
                    [
                        'extend' => 'selectNone',
                        'text' => '<i class="fas fa-copy"></i> ' . 'selectNone',
                        'className' => 'btn btn-dark',
                    ],
                    'print',



                ],
                'select' => 'true'
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('status'),
            Column::make('email'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
