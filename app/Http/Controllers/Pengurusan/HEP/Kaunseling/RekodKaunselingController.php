<?php

namespace App\Http\Controllers\Pengurusan\HEP\Kaunseling;

use App\DataTables\Pengurusan\HEP\Kaunseling\RekodKaunselingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kaunseling;
use Illuminate\Http\Request;

class RekodKaunselingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RekodKaunselingDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.hep.kaunseling.rekod-kaunseling.index');
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
    public function show(Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kaunseling $kaunseling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kaunseling $kaunseling)
    {
        //
    }
}
