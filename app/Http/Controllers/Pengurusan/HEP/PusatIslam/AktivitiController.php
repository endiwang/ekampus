<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\DataTables\Pengurusan\HEP\PusatIslam\AktivitiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AktivitiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, AktivitiDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.pusat-islam.aktiviti.index');
    }
}
