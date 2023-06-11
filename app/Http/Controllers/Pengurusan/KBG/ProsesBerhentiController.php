<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Pelajar;
use App\Models\SebabBerhenti;
use Illuminate\Support\Facades\URL;
use Collective\Html\FormFacade;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;

class ProsesBerhentiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

            $title = "Proses Berhenti";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Berhenti" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Pendaftaran Pelajar",
                    'route' => route('pengurusan.akademik.semester.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('kursus', 'kelas')->where('kelas_id', NULL)->where('is_register', 1)->where('is_berhenti', 0);
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
                    return '
                            <button type="button" data-id='.$data->id.' id="buttonMaklumatPelajar" onclick="getMaklumatPelajar(this);" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-user-check"></i>
                            </button>
                            <a href="'.route('pengurusan.akademik.kelas_pelajar.edit',$data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-close"></i>
                            </a>
                            ';
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
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Jenis Permohonan', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.proses_berhenti.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable','buttons'));

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
        $pelajar = Pelajar::find($request->id);
        $pelajar->is_berhenti = 1;
        $pelajar->tarikh_berhenti = Carbon::parse($request->tarikh_berhenti)->toDateString();
        $pelajar->sebab_berhenti = $request->sebab_berhenti;
        $pelajar->kod_berhenti = $request->kod_berhenti;
        $pelajar->save();
        Alert::toast('Proses berhenti bejaya', 'success');

        return redirect()->route('pengurusan.kbg.pengurusan.proses_berhenti.index');
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

    public function getMaklumatPelajar(Request $request)
    {
        $data = Pelajar::find($request->id_pelajar);

        if($data->sesi)
        {
            $sesi = $data->sesi->nama;
        }else {
            $sesi = '';
        }

        if($data->negeri)
        {
            $negeri = $data->negeri->nama;
        }else {
            $negeri = '';
        }

        $sebab_berhenti = SebabBerhenti::where('berhenti_status',0)->get()->pluck('berhenti','id');

        $response = "<div class='mb-10'>
                        <div class='fs-3 fw-bold text-gray-800 text-center mb-1'>
                            <span class='me-2'>Proses Pendaftaran Pemberhentian Pelajar</span> <br><br>
                            <div class='symbol symbol-100px symbol-lg-160px symbol-fixed position-relative'>
                                <img src='".URL::asset('assets/media/avatars/300-1.jpg')."' alt='image'>
                            </div>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NAMA PENUH </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->nama."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NO. KAD PENGENALAN </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->no_ic."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>SESI PENGAJIAN </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$sesi."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>ALAMAT RUMAH </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->alamat."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>POSKOD </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->poskod."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NEGERI </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$negeri."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NO. TELEFON </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->no_tel."</span>
                        </div>
                    </div>
                    <form id='berhenti' action=".route('pengurusan.kbg.proses_berhenti.store')." method='POST'>
                    <input type='hidden' name='_token' value=".csrf_token().">
                    <input type='hidden' name='id' value=".$data->id.">
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Tarikh Berhenti </label>
                        <div class='col-lg-8'>
                            ".FormFacade::date('tarikh_berhenti','',['class' => 'form-control form-control-sm ', 'id' =>'tarikh_berhenti','onkeydown' =>'return false','autocomplete' => 'off'])."
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Sebab Berhenti </label>
                        <div class='col-lg-8'>
                            ".FormFacade::select('kod_berhenti', $sebab_berhenti , NULL , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '])."
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Kenyataan </label>
                        <div class='col-lg-8'>
                            <input type='text' class='form-control form-control-sm' name='sebab_berhenti'/>
                        </div>
                    </div>
                    </form>";

        return $response;
    }
}
