<?php

namespace App\DataTables;

use App\Models\Kaunseling;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KaunselingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'kaunseling.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Kaunseling $model): QueryBuilder
    {
        return $model
            ->newQuery()
            ->when(
                auth()->user()->role('pelajar'),
                fn ($query) => $query->where('user_id', auth()->user()->id)
            );
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kaunseling-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('no_permohonan'),
            Column::make('tarikh_permohonan'),
            Column::make('jenis_fasiliti'),
            Column::make('status')->addClass('text-center'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Kaunseling_'.date('YmdHis');
    }
}
