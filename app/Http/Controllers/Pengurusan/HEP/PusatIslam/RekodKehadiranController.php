<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekodKehadiranController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('pages.pengurusan.hep.pusat-islam.rekod-kehadiran.index');
    }
}
