<?php

namespace App\DataTables\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithDatatable;
use App\Models\PusatIslam\JadualTugasan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JadualTugasanDataTable extends DataTable
{
    use InteractsWithDatatable;
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return view($this->getActionView(), [
                    'data' => $data,
                    'viewUrl' => $data->getResourceUrl('show'),
                    'updateUrl' => $data->getResourceUrl('edit'),
                    'deleteUrl' => $data->getResourceUrl('destroy'),
                ])->render();
            })
            ->addColumn('user', function(JadualTugasan $jadualTugasan) {
                return view('pages.pengurusan.hep.pusat-islam.partials.user', compact('jadualTugasan'));
            })
            ->addColumn('jenis_tugasan', function(JadualTugasan $jadualTugasan) {
                return view('pages.pengurusan.hep.pusat-islam.partials.jenis-tugasan', compact('jadualTugasan'));
            })
            ->addColumn('waktu_solat', function(JadualTugasan $jadualTugasan) {
                return view('pages.pengurusan.hep.pusat-islam.partials.waktu-solat', compact('jadualTugasan'));
            })
            ->rawColumns(['user', 'action'])
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
            Column::make('tarikh')->searchable()->orderable(),
            Column::make('jenis_tugasan')->searchable()->orderable(),
            Column::make('waktu_solat')->searchable()->orderable(),
            Column::make('user', 'Petugas'),
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
