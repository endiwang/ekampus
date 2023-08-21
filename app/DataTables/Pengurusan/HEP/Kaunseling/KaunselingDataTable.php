<?php

namespace App\DataTables\Pengurusan\HEP\Kaunseling;

use App\Models\Kaunseling;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KaunselingDataTable extends DataTable
{
    protected function getActionView(): string
    {
        if(property_exists($this, 'actionView')) {
            return $this->actionView;
        }
        
        return 'pages.pengurusan.hep.kaunseling.partials.datatable-action';
    }

    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('tarikh_permohonan', function ($data) {
                return view('partials.date', ['date' => $data->tarikh_permohonan])->render();
            })
            ->addColumn('created_at', function ($data) {
                return view('partials.date', ['date' => $data->created_at, 'format' => 'Y-m-d H:i:s'])->render();
            })
            ->addColumn('status', function ($data) {
                return view('pages.pengurusan.hep.kaunseling.partials.datatable-status', compact('data'))->render();
            })
            ->addColumn('action', function ($data) {
                return view($this->getActionView(), compact('data'))->render();
            })
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
                auth()->user()->hasRole('pelajar'),
                fn ($query) => $query->where('user_id', auth()->user()->id)
            )
            ->when($this->request()->get('status'), fn ($query) => $query->where('status', $this->request()->get('status')))
            ->when($this->request()->get('keyword'), fn ($query) => $query->search($this->request()->get('keyword')));
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
            Column::make('status')->addClass('text-center'),
            Column::make('created_at'),
            Column::make('action')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
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
