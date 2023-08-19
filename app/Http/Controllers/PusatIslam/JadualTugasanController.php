<?php

namespace App\Http\Controllers\PusatIslam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadualTugasanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('pages.pusat-islam.jadual-tugasan.index');
    }
}
