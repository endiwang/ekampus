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
            "Pelajar" =>  false,
            "Permohonan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $buttons = [
            [
                'title' => "Permohonan Baru",
                'route' => route('pelajar.permohonan.keluar_masuk.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = PermohonanKeluarMasuk::query();
            return DataTables::of($data)
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
                        return 'Baru Diterima';
                    break;

                    case 2 :
                        return 'Dalam Proses';
                    break;

                    case 3 :
                        return 'Lulus';
                    break;

                    case 4 :
                        return 'Tolak';
                    break;
                }
            })
            ->addColumn('action', function($data){
                return '
                        <a href="'.route('pelajar.permohonan.keluar_masuk.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
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
