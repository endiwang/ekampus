<?php

namespace App\DataTables\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithDatatable;
use App\Models\PusatIslam\Aktiviti;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AktivitiDataTable extends DataTable
{
    use InteractsWithDatatable;

    protected string $actionView = 'partials.datatable-action';

    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn(
                'tarikh',
                fn ($data) => view('partials.date', ['date' => data_get($data, 'tarikh')])
            )
            ->addColumn(
                'hari_kebesaran_islam',
                fn ($data) => view('partials.status', [
                    'status' => data_get($data, 'hari_kebesaran_islam') ? true : false,
                ])
            )
            ->addColumn('action', function ($data) {
                return view($this->getActionView(), [
                    'data' => $data,
                    'viewUrl' => $data->getResourceUrl('show'),
                    'updateUrl' => $data->getResourceUrl('edit'),
                    'deleteUrl' => $data->getResourceUrl('destroy'),
                ])->render();
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Aktiviti  $model
     */
    public function query(Aktiviti $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('aktiviti-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
                    //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('nama', 'Nama')->searchable()->orderable(),
            Column::make('tarikh', 'Tarikh')->searchable()->orderable(),
            Column::make('hari_kebesaran_islam', 'Hari Kebesaran Islam')->searchable()->orderable(),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Aktiviti_'.date('YmdHis');
    }
}
