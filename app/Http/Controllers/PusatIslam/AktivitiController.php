<?php

namespace App\Http\Controllers\PusatIslam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AktivitiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('pages.pusat-islam.aktiviti.index');
    }
}
