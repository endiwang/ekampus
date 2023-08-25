<?php

namespace App\DataTables\Pengurusan\HEP\PusatIslam;

use App\Models\PusatIslam\JadualTugasan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JadualTugasanDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'jadualtugasan.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\JadualTugasan  $model
     */
    public function query(JadualTugasan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jadualtugasan-table')
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
            Column::make('Tarikh')->searchable()->orderable(),
            Column::make('Waktu Solat', 'waktu_solat')->searchable()->orderable(),
            Column::make('Imam')
                ->render('pages.pengurusan.hep.pusat-islam.partials.imam'),
            Column::make('Bilal')
                ->render('pages.pengurusan.hep.pusat-islam.partials.bilal'),
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
        return 'JadualTugasan_'.date('YmdHis');
    }
}
