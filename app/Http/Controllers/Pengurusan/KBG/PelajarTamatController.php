<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Pelajar;

class PelajarTamatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

            $title = "Senarai Maklumat Pelajar ( BERHENTI @ TAMAT PENGAJIAN )";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Pelajar Tamat" =>  false,
            ];



            if (request()->ajax()) {
                $data = Pelajar::with('kursus', 'kelas')->where('is_deleted', 0)->where('is_register', 1)->where('is_berhenti', 1);
                return DataTables::of($data)
                ->addColumn('nama_edit', function($data) {
                    $data = '<p style="margin-bottom:unset !important">' . $data->nama . '<br/><p style="margin-bottom:unset !important">' . $data->no_ic . '<span style="font-weight:bold">&nbsp[' . $data->no_matrik . '] </span></p>';
                    return $data;
                })
                ->addColumn('kursus_id', function($data) {

                    $data = '<p style="text-align:center">' . $data->kursus->nama . '</p>';
                    return $data;

                })
                ->addColumn('sesi_id', function($data) {
                    if($data->sesi)
                    {
                        return '<p style="text-align:center">' . $data->sesi->nama . '</p>';
                    }else {
                        return '';
                    }

                })
                ->addColumn('tarikh', function($data) {
                    $data = '<p style="text-align:center; margin-bottom:unset !important">' . $data->tarikh_daftar.'<br/><p style="text-align:center; margin-bottom:unset !important">-</p><p style="text-align:center; margin-bottom:unset !important">' . $data->tarikh_berhenti .'</p>';
                    return $data;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.kelas_pelajar.edit',$data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['nama_edit','status', 'action','sesi_id','kursus_id','tarikh'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama_edit', 'name' => 'nama_edit', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable'=> false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Kemasukan', 'orderable'=> false],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Daftar - Tamat', 'orderable'=> false],
                ['data' => 'sebab_berhenti', 'name' => 'sebab_berhenti', 'title' => 'Status Pembelajaran', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.pelajar_tamat.main', compact('title', 'breadcrumbs', 'dataTable'));

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
