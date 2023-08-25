<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\DataTables\Pengurusan\HEP\PusatIslam\KelasOrangAwamDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrangAwamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, KelasOrangAwamDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.pusat-islam.orang-awam.index');
    }
}
