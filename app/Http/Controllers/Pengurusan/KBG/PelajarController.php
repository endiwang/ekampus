<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Staff;
use Yajra\DataTables\Html\Builder;
use App\Models\Pelajar;
use App\Models\User;
use App\Models\Sesi;

class PelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        if (request()->ajax()) {
            $data = Pelajar::query();
            return DataTables::of($data)
            ->addColumn('sesi_kemasukan', function($data) {
                if($data->sesi == NULL)
                {
                    return '';
                }else{
                    return $data->sesi->nama;
                }
            })
            ->addColumn('pusat_pengajian', function($data) {
                if($data->pusat_pengajian == NULL)
                {
                    return '';
                }else{
                    return $data->pusat_pengajian->nama;
                }
            })
            ->addColumn('kursus', function($data) {
                if($data->kursus == NULL)
                {
                    return '';
                }else{
                    return $data->kursus->nama;
                }
            })
            ->addIndexColumn()
            ->rawColumns(['no_kp_no_matrik','sesi_kemasukan','pusat_pengajian'])
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
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil', 'render'=> null, 'orderable'=> false, 'searchable'=> false, 'exportable'=> false, 'printable'=> true, 'footer'=> '',],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama'],
            ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No K/P'],
            ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik'],
            ['data' => 'sesi_kemasukan', 'name' => 'sesi_kemasukan', 'title' => 'Sesi Kemasukan'],
            ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus'],
            // ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred'],
            // ['data' => 'jawatan', 'name' => 'jawatan', 'title' => 'Jabatan'],
            // ['data' => 'gred', 'name' => 'gred', 'title' => 'Jawatan'],
            // ['data' => 'intro', 'name' => 'intro', 'title' => 'Intro'],
            ['data' => 'pusat_pengajian', 'name' => 'pusat_pengajian', 'title' => 'Pusat Pengajian'],
        ])
        ->minifiedAjax();

        return view('pages.pengurusan.kbg.pelajar.main', compact('html'));
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
