<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Pelajar;


class CetakSijilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

            $title = "Cetakkan Sijil-Sijil";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Cetakkan Sijil-Sijil" =>  false,
            ];

            $buttons = [
                
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('kursus', 'kelas')->where('kelas_id', NULL)->where('is_register', 1)->where('no_matrik', '!=', NULL);
                return DataTables::of($data)
                ->addColumn('no_ic', function($data) {
                    if(!empty($data->no_matrik)){
                        $data = '<p style="text-align:center">' . $data->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->no_matrik . '] </span></p>';
                    }
                    else {
                        $data = '<p style="text-align:center">' . $data->no_ic . '</p>';
                    }

                    return $data;
                })
                ->addColumn('kursus_id', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('sesi_id', function($data) {
                    if($data->sesi)
                    {
                        return '<p style="text-align:center">' . $data->sesi->nama . '</p>';
                    }else {
                        return '';
                    }

                })
                ->addColumn('action', function($data){
                    $option = '';
                    if($data->mata_akhir == NULL)
                    {
                        $cgpa = '0.00';
                    }
                    else{
                        $cgpa = $data->mata_akhir;
                    }

                    if($data->kursus->id == 1 || $data->kursus->id == 29)
                    {
                        $option .= "<option>Sijil Asas Tahfiz</option>";
                    }elseif($data->kursus->id == 12)
                    {
                        $option .= "<option>Sijil Tahfiz</option>";
                    }
                    elseif($data->kursus->id == 25)
                    {
                        $option .= "<option>Sijil DKM</option>";
                    }

                    if($data->kursus->kod == 'D')
                    {
                        $option .= "<option>Surat Tamat Pengajian</option>";
                        $option .= "<option>Sijil Diploma</option>";
                    }

                    if($data->kursus->kod == 'S' && ($data->kursus->id == 23 || $data->kursus->id == 29))
                    {
                        $option .= "<option>Sijil Asas Al-Quran</option>";
                    }elseif($data->kursus->kod == 'S' || $data->kursus->kod == 'ST')
                    {
                        $option .= "<option>Sijil Tahfiz Al-Quran</option>";
                    }

                    return '<p style="font-weight:bold; text-align:center; margin-bottom:unset !important">CGPA : '.$cgpa.'</p>
                            <select class="form-select form-select-sm" data-kt-select2="true" data-dropdown-parent="#kt_menu_633f0a63606af" data-allow-clear="true">
                                <option>Sila Pilih</option>
                                '.$option.'
                            </select>';
                })

                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['no_ic','status', 'action','sesi_id'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Pengajian', 'orderable'=> false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable'=> false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Syukbah', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.cetak_sijil.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
