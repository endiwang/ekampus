<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PelajarBerhenti;
use App\Models\SebabBerhenti;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RayuanPengajianController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.permohonan.rayuan_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Rayuan Pengajian';
            $breadcrumbs = [
                'Akademik' => false,
                'Permohonan' => false,
                'Rayuan Pengajian' => false,
            ];

            if (request()->ajax()) {
                $data = PelajarBerhenti::with('pelajarOld')->where('kod_berhenti', 4)->where('kod_berhenti', '!=', null);

                return DataTables::of($data)
                    ->addColumn('nama_pelajar', function ($data) {
                        if (! empty($data->pelajar->name)) {
                            return $data->pelajar->nama;
                        } else {
                            return $data->pelajarOld->nama ?? null;
                        }
                    })
                    ->addColumn('no_ic', function ($data) {
                        $student = '';
                        if (! empty($data->pelajar->name)) {
                            $no_ic = $data->pelajar->no_ic;
                            $no_matrik = $data->pelajar->no_matrik;
                            $student = nl2br($no_ic."\n".' ['.$no_matrik.']');
                        } else {
                            $no_ic = $data->pelajarOld->no_ic;
                            $no_matrik = $data->pelajarOld->no_matrik;
                            $student = nl2br($no_ic."\n".' ['.$no_matrik.']');
                        }

                        return $student;
                    })
                    ->addColumn('sesi_kemasukan', function ($data) {
                        if (! empty($data->pelajar->name)) {
                            return $data->pelajar->sesi->nama;
                        } else {
                            return $data->pelajarOld->sesi->nama ?? null;
                        }
                    })
                    ->addColumn('program_pengajian', function ($data) {
                        if (! empty($data->pelajar->name)) {
                            return $data->pelajar->kursus->nama;
                        } else {
                            return $data->pelajarOld->kursus->nama ?? null;
                        }
                    })
                    ->addColumn('kod_berhenti', function ($data) {
                        $deskripsi_kod = SebabBerhenti::find($data->kod_berhenti);

                        return $deskripsi_kod->berhenti ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.permohonan.rayuan_pengajian.update_status', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Klik untuk aktifkan pelajar">
                                <i class="fa-solid fa-check"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['no_ic', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No Kp / [No Matrik]', 'orderable' => false],
                    ['data' => 'sesi_kemasukan', 'name' => 'sesi_kemasukan', 'title' => 'Sesi Kemasukan', 'orderable' => false],
                    ['data' => 'program_pengajian', 'name' => 'program_pengajian', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'kod_berhenti', 'name' => 'kod_berhenti', 'title' => 'Kod Berhenti', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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

    public function updateStatus($id)
    {
        try {

            //update status
            $update = PelajarBerhenti::find($id);
            $update->kod_berhenti = null;
            $update->save();

            //to do to update status pengajian in table pelajar
            //to recconfirm which column to update
            Pelajar::where('id', $update->old_pelajar_berhenti_id)->update([
                'is_gantung' => 0,
            ]);

            Alert::toast('Status pelajar berjaya dipinda!', 'success');

            return redirect()->route('pengurusan.akademik.permohonan.rayuan_pengajian.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
