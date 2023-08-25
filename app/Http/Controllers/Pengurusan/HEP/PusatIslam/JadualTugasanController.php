<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\DataTables\Pengurusan\HEP\PusatIslam\JadualTugasanDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadualTugasanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, JadualTugasanDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.pusat-islam.jadual-tugasan.index');
    }
}
