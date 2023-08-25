<?php

namespace App\Http\Controllers\Pengurusan\HEP\Kaunseling;

use App\Http\Controllers\Controller;
use App\Models\Kaunseling;
use Illuminate\Http\Request;

class BorangKepuasanPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kaunseling = Kaunseling::whereId($id)->firstOrFail();

        return view('pages.pengurusan.hep.kaunseling.borang-kepuasan-pelanggan.show', compact('kaunseling'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kaunseling = Kaunseling::whereId($id)->firstOrFail();

        return view('pages.pengurusan.hep.kaunseling.borang-kepuasan-pelanggan.form', compact('kaunseling'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
