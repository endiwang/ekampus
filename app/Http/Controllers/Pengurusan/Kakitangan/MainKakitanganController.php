<?php

namespace App\Http\Controllers\Pengurusan\Kakitangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Staff;
use Yajra\DataTables\Html\Builder;


class MainKakitanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // return $dataTable->render('pages.pengurusan.kakitangan.dashboard.main');

        if (request()->ajax()) {
            $data = Staff::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('Pusat Pengajian', function ($data) {
            })
            ->toJson();
        }

        $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $html = $builder
        ->parameters([
            'language' => '{ "lengthMenu": "Show _MENU_", }',
            'dom' => $dom_setting,
        ])
        ->columns([
            ['data' => 'DT_RowIndex', 'name' => 'index', 'title' => 'No'],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama'],
            ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. K/P'],
            ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred'],
            ['data' => 'jawatan', 'name' => 'jawatan', 'title' => 'Jabatan'],
            ['data' => 'gred', 'name' => 'gred', 'title' => 'Jawatan'],
            ['data' => 'pusat_pengajian_id', 'name' => 'pusat_pengajian_id', 'title' => 'Pusat Pengajian'],
        ]);

        return view('pages.pengurusan.kakitangan.dashboard.main',compact('html'));
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
