<?php

namespace App\DataTables\Pengurusan\HEP\PusatIslam;

use App\Models\PusatIslam\KelasOrangAwam;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KelasOrangAwamDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'kelasorangawam.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\KelasOrangAwam  $model
     */
    public function query(KelasOrangAwam $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kelasorangawam-table')
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
            Column::make('Name')->searchable()->orderable(),
            Column::make('Tarikh')->searchable()->orderable(),
            Column::make('Status')->searchable()->orderable(),
            Column::make('Guru')
                ->render('pages.pengurusan.hep.pusat-islam.partials.guru')
                ->searchable()->orderable(),
            Column::make('Pendaftaran Dibuka?')
                ->render('pages.pengurusan.hep.pusat-islam.partials.status-pendaftaran')
                ->searchable()->orderable(),
            Column::make('Had Pelajar', 'had_jumlah_pelajar')->searchable()->orderable(),
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
        return 'KelasOrangAwam_'.date('YmdHis');
    }
}
