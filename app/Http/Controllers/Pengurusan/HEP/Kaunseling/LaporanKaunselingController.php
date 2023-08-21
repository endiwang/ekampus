<?php

namespace App\Http\Controllers\Pengurusan\HEP\Kaunseling;

use App\DataTables\Pengurusan\HEP\Kaunseling\LaporanKaunselingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kaunseling;
use Illuminate\Http\Request;

class LaporanKaunselingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanKaunselingDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.kaunseling.laporan-kaunseling.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function show(Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function edit(Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kaunseling $kaunseling)
    {
        //
    }
}
