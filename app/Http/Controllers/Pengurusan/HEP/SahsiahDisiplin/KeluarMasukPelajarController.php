<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\PelepasanKuliah;
use App\Models\PermohonanKeluarMasuk;
use Carbon\Carbon;

class KeluarMasukPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.hep.permohonan.keluar_masuk.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Permohonan Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Permohonan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $buttons = [
        ];

        if (request()->ajax()) {
            $data = PermohonanKeluarMasuk::query();
            return DataTables::of($data)
            ->addColumn('nama_pelajar', function($data) {
                $tarikh = Utils::formatDate($data->tarikh_keluar);

                return $data->pelajar->nama;
            })
            ->addColumn('no_ic', function($data) {
                if(!empty($data->pelajar)){
                    $data = '<p style="text-align:center">' . $data->pelajar->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->pelajar->no_matrik . '] </span></p>';
                }
                else {
                    $data = '';
                }

                return $data;
            })
            ->addColumn('tarikh_keluar', function($data) {
                $tarikh = Utils::formatDate($data->tarikh_keluar);

                return $tarikh;
            })
            ->addColumn('tarikh_masuk', function($data) {
                $tarikh = Utils::formatDate($data->tarikh_masuk);

                return $tarikh;
            })
            ->addColumn('status', function($data) {
                switch($data->status)
                {
                    case 1 :
                        return '<span class="badge badge-primary">Baru Diterima</span>';
                    break;

                    case 2 :
                        return '<span class="badge badge-info">Dalam Proses</span>';
                    break;

                    case 3 :
                        return  '<span class="badge badge-success">Lulus</span>';
                    break;

                    case 4 :
                        return  '<span class="badge badge-danger">Ditolak</span>';
                    break;
                }
            })

            ->addColumn('action', function($data){
                return '
                        <a href="'.route('pengurusan.hep.permohonan.keluar_masuk.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.keluar_masuk.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('id', 'desc');
            })
            ->rawColumns(['no_ic','status', 'action'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pemohon', 'orderable'=> false],
            ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable'=> false],
            ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable'=> false],
            ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh Masuk', 'orderable'=> false],
            ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable'=> false],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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
        $page_title = 'Maklumat Permohonan Keluar Masuk';
        $action = route('pengurusan.hep.permohonan.keluar_masuk.update', $id);

        $title = "Maklumat Permohonan Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Permohonan" =>  false,
            "Keluar Masuk" =>  false,
            "Maklumat Permohonan" =>  false,
        ];

        $buttons = [
            // [
            //     'title' => "Biodata Pelajar",
            //     'route' => route('pengurusan.akademik.pengurusan.aktiviti_pdp.create'),
            //     'button_class' => "btn btn-sm btn-primary fw-bold",
            //     'icon_class' => "fa-solid fa-circle-info"
            // ],
        ];

        $data = PermohonanKeluarMasuk::find($id);

        $statuses = [
            1 => 'Baru Diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'action', 'data', 'buttons', 'statuses'));
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
        $validation = $request->validate([
            'status_permohonan'=> 'required',
        ],[
            'status_permohonan.required'         => 'Sila pilih status permohonan',
        ]);

        $data = PermohonanKeluarMasuk::find($id);


            $data->status   = $request->status_permohonan;
            $data->komen    = $request->komen;
            $data->save();

        Alert::toast('Maklumat permohonan keluar masuk berjaya diproses!', 'success');
        return redirect()->route('pengurusan.hep.permohonan.keluar_masuk.index');
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
