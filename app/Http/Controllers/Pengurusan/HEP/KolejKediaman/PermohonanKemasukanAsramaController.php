<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use App\Models\KemasukanAsrama;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\BilikAsrama;


class PermohonanKemasukanAsramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.permohonan.kemasukan_asrama.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Kemasukan Ke Asrama';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Permohonan' => false,
            'Kemasukan Ke Asrama' => false,
        ];
        $buttons = [];

        if (request()->ajax()) {
            $data = KemasukanAsrama::query();

            return DataTables::of($data)
                ->addColumn('nama_pelajar', function ($data) {
                    if (! empty($data->pelajar)) {
                        $data = $data->pelajar->nama;
                    } else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('no_ic', function ($data) {
                    if (! empty($data->pelajar)) {
                        $data = '<p style="text-align:center">'.$data->pelajar->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->pelajar->no_matrik.'] </span></p>';
                    } else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('status_profile', function ($data) {
                    switch ($data->status_profile) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Kemaskini</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Sudah Dikemaskini</span>';
                            break;
                    }
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Diproses</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Diterima</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-danger">Ditolak</span>';
                            break;
                    }
                })
                ->addColumn('bilik', function ($data) {
                    if($data->bilik)
                    {
                        return $data->bilik->no_bilik;
                    }else{
                        return 'N/A';
                    }

                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    $tarikh = Utils::formatDate($data->created_at);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.kolej_kediaman.permohonan.kemasukan_asrama.edit', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                                <i class="fa fa-eye"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'tarikh_permohonan','nama_pelajar','no_ic','status_profile'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable' => false],
                ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'status_profile', 'name' => 'status_profile', 'title' => 'Status Profil', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Permohonan', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
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
        $title = 'Permohonan Kemasukan Ke Asrama';
        $page_title = 'Permohonan Kemasukan Ke Asrama';
        $action = route('pengurusan.kolej_kediaman.permohonan.kemasukan_asrama.update', $id);
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Permohonan' => false,
            'Kemasukan Ke Asrama' => false,
        ];
        $data = KemasukanAsrama::find($id);

        $bilik = BilikAsrama::where('is_deleted',0)->whereNotNull('jenis_bilik')->where('kekosongan','>',0)->pluck('no_bilik','id');

        return view($this->baseView.'edit', compact('title', 'breadcrumbs', 'data', 'page_title', 'action','bilik'));
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
        $data = KemasukanAsrama::find($id);
        $data->status = $request->status;
        $data->bilik_asrama_id = $request->bilik_asrama_id;
        $data->save();

        $bilik_asrama = BilikAsrama::find($request->bilik_asrama_id);
        $bilik_asrama->kekosongan = $bilik_asrama->kekosongan - 1;
        $bilik_asrama->save();


        return redirect()->route('pengurusan.kolej_kediaman.permohonan.kemasukan_asrama.index');
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
