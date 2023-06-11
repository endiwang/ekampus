<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use App\Models\RayuanPermohonan;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class SenaraiRayuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

            $title = "Senarai Rayuan Permohonan";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Senarai Rayuan	Permohonan" =>  false,
            ];

            $buttons = [
            ];

            if (request()->ajax()) {
                $data = RayuanPermohonan::orderBy('id', 'desc');
                return DataTables::of($data->get())

                ->addColumn('nama', function($data) {


                    if($data->permohonan)
                    {
                        $data = '<p>' . $data->permohonan->nama . '<br/> <span style="font-weight:bold"> [' . $data->permohonan->no_ic . '] </span></p>';
                    }else{
                        $data = 'N/A';
                    }

                    return $data;
                })
                ->addColumn('kursus', function($data) {

                    if($data->permohonan)
                    {
                        return $data->permohonan->kursus->nama;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('sesi', function($data) {

                    if($data->permohonan)
                    {
                        return $data->permohonan->sesi->nama;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('markah_temuduga', function($data) {

                    if($data->permohonan)
                    {
                        return $data->permohonan->temuduga_markah->jumlah.' %';
                    }else{
                        return 'N/A';
                    }
                })



                ->addColumn('action', function($data){

                    $action = '<button class="edit btn btn-icon btn-success btn-sm hover-elevate-up" data-bs-toggle="Terima Ray">
                    <i class="fa fa-check"></i></button>';

                    return $action;
                })

                ->addIndexColumn()
                ->rawColumns(['nama','kursus','sesi','action',])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
                ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pemohon', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kursus',      'name' => 'kursus',           'title' => 'Bidang Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'sesi',     'name' => 'sesi',          'title' => 'Sesi Pengajian', 'orderable'=> false],
                ['data' => 'rayuan',     'name' => 'rayuan',          'title' => 'Rayuan', 'orderable'=> false],
                ['data' => 'markah_temuduga',     'name' => 'markah_temuduga',          'title' => 'Markah Temuduga', 'orderable'=> false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.senarai_rayuan.main', compact('title', 'breadcrumbs', 'dataTable','buttons'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
