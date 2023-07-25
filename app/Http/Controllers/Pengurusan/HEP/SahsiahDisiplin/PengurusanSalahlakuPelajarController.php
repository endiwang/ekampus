<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\AduanSalahlakuPelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Kelas;


class PengurusanSalahlakuPelajarController extends Controller
{

    protected $baseView = 'pages.pengurusan.hep.pengurusan.salahlaku_pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Salahlaku Pelajar";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Pengurusan" =>  false,
            "Salahlaku Pelajar" =>  false,
        ];

        $buttons = [

        ];

        if (request()->ajax()) {
            $data = AduanSalahlakuPelajar::query();
            return DataTables::of($data)
            ->addColumn('nama_pengadu', function($data) {
                if(!empty($data->pengadu))
                {
                    if($data->pengadu->is_staff = 1)
                    {
                        return $data->pengadu->staff->nama;
                    }else{
                        return $data->pengadu->pelajar->nama;
                    }

                }else {
                    return 'N/A';
                }
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('pengurusan.pentadbir_sistem.kakitangan.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kehadiran">
                            <i class="fa fa-print"></i>
                        </a>
                        <a href="'.route('pengurusan.akademik.kelas.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kelas.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('id', 'desc');
            })
            ->rawColumns(['nama_pengadu','action'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama_pengadu', 'name' => 'nama_pengadu', 'title' => 'Nama Pengadu', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'nama_pelaku', 'name' => 'nama_pelaku', 'title' => 'Nama Pelaku', 'orderable'=> false, 'class'=>'text-bold'],
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
