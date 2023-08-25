<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\DataTables\Pengurusan\HEP\PusatIslam\SuratRasmiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratRasmiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, SuratRasmiDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.pusat-islam.surat-rasmi.index');
    }
}
