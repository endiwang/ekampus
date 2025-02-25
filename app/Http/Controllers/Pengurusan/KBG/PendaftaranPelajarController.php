<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PendaftaranPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

        $title = 'Pendaftaran Pelajar';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Pendaftaran Pelajar' => false,
        ];

        $buttons = [
            [
                'title' => 'Pendaftaran Pelajar',
                'route' => route('pengurusan.akademik.semester.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = Pelajar::with('kursus')->where('is_berhenti', 0)->where('is_register', 0)->where('is_deleted', 0);

            return DataTables::of($data)
                ->addColumn('no_ic', function ($data) {
                    if (! empty($data->no_matrik)) {
                        $data = '<p style="text-align:center">'.$data->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik.'] </span></p>';
                    } else {
                        $data = '<p style="text-align:center">'.$data->no_ic.'</p>';
                    }

                    return $data;
                })
                ->addColumn('kursus_id', function ($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('sesi_id', function ($data) {
                    if ($data->sesi) {
                        return '<p style="text-align:center">'.$data->sesi->nama.'</p>';
                    } else {
                        return '';
                    }

                })
                ->addColumn('action', function ($data) {
                    return '
                            <button type="button" data-id='.$data->id.' id="buttonMaklumatPelajar" onclick="getMaklumatPelajar(this);" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-user-check"></i>
                            </button>
                            <a href="'.route('pengurusan.akademik.kelas_pelajar.edit', $data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-close"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['no_ic', 'status', 'action', 'sesi_id'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan', 'orderable' => false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Pengajian', 'orderable' => false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Jenis Permohonan', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.kbg.pendaftaran_pelajar.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'buttons'));

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pelajar = Pelajar::find($request->id);
        $pelajar->is_register = 1;
        $pelajar->tarikh_daftar = Carbon::now()->format('Y-m-d');
        $pelajar->save();
        Alert::toast('Pelajar berjaya didaftarkan', 'success');

        return redirect()->route('pengurusan.kbg.pengurusan.pendaftaran_pelajar.index');

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

    public function getMaklumatPelajar(Request $request)
    {
        $data = Pelajar::find($request->id_pelajar);

        if ($data->sesi) {
            $sesi = $data->sesi->nama;
        } else {
            $sesi = '';
        }

        if ($data->negeri) {
            $negeri = $data->negeri->nama;
        } else {
            $negeri = '';
        }

        $response = "<div class='mb-10'>
                        <div class='fs-3 fw-bold text-gray-800 text-center mb-1'>
                            <span class='me-2'>Pendaftaran Pelajar</span> <br><br>
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
                    <form id='pilih' action=".route('pengurusan.kbg.pendaftaran_pelajar.store')." method='POST'>
                    <input type='hidden' name='_token' value=".csrf_token().">
                    <input type='hidden' name='id' value=".$data->id.'>
                    </form>';

        return $response;
    }
}
