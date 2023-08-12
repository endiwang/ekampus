<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\KeluarMasuk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Pelajar;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;


class RekodKeluarMasukPelajarController extends Controller
{

    protected $baseView = 'pages.pengurusan.hep.pengurusan.keluar_masuk.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Rekod Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Pengurusan" =>  false,
            "Rekod Keluar Masuk" =>  false,
        ];

        $buttons = [
            [
                'title' => "Tambah Rekod",
                'route' => route('pengurusan.hep.pengurusan.keluar_masuk.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = KeluarMasuk::query();
            return DataTables::of($data)
            ->addColumn('nama_pelajar', function($data) {
                if(!empty($data->pelajar)){
                    $data = $data->pelajar->nama;
                }
                else {
                    $data = '';
                }

                return $data;
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
            ->addColumn('tarikh_masuk', function($data) {
                return !empty($data->tarikh_masuk) ? Utils::formatDate($data->tarikh_masuk) : null;
            })

            ->addColumn('masa_masuk', function($data) {
                return !empty($data->waktu_masuk) ? Utils::formatTime($data->waktu_masuk) : null;
            })

            ->addColumn('tarikh_keluar', function($data) {
                return !empty($data->tarikh_keluar) ? Utils::formatDate($data->tarikh_keluar) : null;
            })

            ->addColumn('masa_keluar', function($data) {
                return !empty($data->waktu_masuk) ? Utils::formatTime($data->waktu_masuk) : null;
            })
            ->addColumn('status', function($data) {
                switch ($data->status) {
                    case 0:
                        return '<span class="badge badge-success">Keluar</span>';
                      break;
                    case 1:
                        return '<span class="badge badge-info">Masuk</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-danger">Lewat</span>';
                        break;
                    case 3:
                        return '<span class="badge badge-warning">Lewat Dengan Alasan</span>';
                        default:
                      return '';
                }
            })
            ->addColumn('action', function($data){
                return '
                        <a href="'.route('pengurusan.hep.tetapan.keluar_masuk.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.tetapan.keluar_masuk.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('id', 'desc');
            })
            ->rawColumns(['status','no_ic', 'tarikh_masuk','masa_masuk','tarikh_keluar','masa_keluar','status','action'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable'=> false],
            ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'masa_keluar', 'name' => 'masa_keluar', 'title' => 'Masa Keluar', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh Masuk', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'masa_masuk', 'name' => 'masa_masuk', 'title' => 'Masa Masuk', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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

        $action = route('pengurusan.hep.pengurusan.keluar_masuk.store');
        $page_title = 'Tambah Rekod Keluar Masuk';

        $title = "Rekod Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Pengurusan" =>  false,
            "Keluar Masuk" =>  false,
            "Tambah Rekod" =>  false,
        ];

        $model = new KeluarMasuk();

        $pelajar = Pelajar::where('is_berhenti',0)->get()->pluck('name_ic','id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action','pelajar'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'pelajar_id'=> 'required',
            'tarikh_keluar'=> 'required',
            'masa_keluar'=> 'required',
            'status'=> 'required',
        ],[
            'pelajar_id.required'       => 'Sila pilih pelejar',
            'tarikh_keluar.required'    => 'Sila tarikh keluar',
            'masa_keluar.required'      => 'Sila masa keluar',
            'status.required'           => 'Sila status',
        ]);

        $pelajar = Pelajar::find($request->pelajar_id);

        KeluarMasuk::create([
            'pelajar_id'    => $request->pelajar_id,
            'user_id'       => $pelajar->user_id,
            'tarikh_keluar' => $request->tarikh_keluar,
            'masa_keluar'   => $request->masa_keluar,
            'tarikh_masuk'  => $request->tarikh_masuk,
            'masa_masuk'    => $request->masa_masuk,
            'status'        => $request->status,
        ]);


        Alert::toast('Maklumat keluar masuk berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.hep.pengurusan.keluar_masuk.index');

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
