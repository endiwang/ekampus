<?php

namespace App\Http\Controllers\Pengurusan\Pembangunan;

use App\Http\Controllers\Controller;
use App\Models\AduanPenyelenggaraan;
use Illuminate\Http\Request;

class MainPembangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Pembangunan';
        $data['breadcrumbs'] = [
            'Pembangunan' => false,
        ];

        $data['aduan_all'] = AduanPenyelenggaraan::count();
        $data['aduan_new'] = AduanPenyelenggaraan::where('status', 1)->count();
        $data['aduan_to_process'] = AduanPenyelenggaraan::where('status', 3)->count();
        $data['aduan_complete'] = AduanPenyelenggaraan::where('status', 4)->count();
        return view('pages.pengurusan.pembangunan.dashboard.main')->with($data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
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
