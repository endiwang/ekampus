<?php

namespace App\DataTables\Pengurusan\HEP\Kaunseling;

use App\Models\Kaunseling;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class LaporanKaunselingDataTable extends KaunselingDataTable
{
    protected string $actionView = 'pages.pengurusan.hep.kaunseling.partials.datatable-action-laporan-kaunseling';

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
            ->where('status', Kaunseling::STATUS_SELESAI);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'RekodKaunseling_' . date('YmdHis');
    }
}
