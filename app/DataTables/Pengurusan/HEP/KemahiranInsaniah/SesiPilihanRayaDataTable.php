<?php

namespace App\DataTables\Pengurusan\HEP\KemahiranInsaniah;

use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SesiPilihanRayaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'sesipilihanraya.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Sesi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sesipilihanraya-table')
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
            Column::make('semester'),
            Column::make('jenis'),
            Column::make('tarikh_penamaan_calon'),
            Column::make('tarikh_mengundi'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'SesiPilihanRaya_'.date('YmdHis');
    }
}
