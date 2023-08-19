<?php

namespace App\Http\Controllers\Kaunseling;

use App\DataTables\KaunselingDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, KaunselingDataTable $dataTable)
    {
        return $dataTable->render('pages.kaunseling.dashboard.index');
    }
}
