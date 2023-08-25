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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kaunseling = Kaunseling::whereId($id)->firstOrFail();

        return view('pages.pengurusan.hep.kaunseling.laporan-kaunseling.show', compact('kaunseling'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kaunseling = Kaunseling::whereId($id)->firstOrFail();

        return view('pages.pengurusan.hep.kaunseling.laporan-kaunseling.form', compact('kaunseling'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
