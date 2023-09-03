<?php

namespace App\Http\Controllers\KemahiranInsaniah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PilihanRayaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('pages.kemahiran-insaniah.pilihan-raya.index');
    }
}
