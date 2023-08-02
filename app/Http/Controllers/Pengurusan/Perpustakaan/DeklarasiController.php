<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelajar;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\KeahlianPerpustakaan;
use App\Models\PinjamanPerpustakaan;
use App\Helpers\Utils;

class DeklarasiController extends Controller
{
    protected $baseView = 'pages.pengurusan.perpustakaan.deklarasi.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $title = "Deklarasi Pelajar";
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Deklarasi Pelajar" =>  false,
            ];

            $action = route('pengurusan.perpustakaan.deklarasi.semakan');

            $buttons = [
            ];

            $pelajar = Pelajar::where('is_berhenti',0)->get()->pluck('name_ic','id');


            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons','pelajar','action'));
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

    public function semakan(Builder $builder, Request $request)
    {
            $pelajar = Pelajar::find($request->pelajar_id);
            $model = KeahlianPerpustakaan::where('user_id',$pelajar->user_id)->first();
            $title = 'Keahlian Perpustakaan';
            $page_title = 'Keahlian Perpustakaan';
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Keahlian" =>  false,
            ];

            if (request()->ajax()) {
                $data = PinjamanPerpustakaan::where('keahlian_id',$model->id);
                return DataTables::of($data)
                ->addColumn('nama_bahan', function($data) {
                    if($data->bahan)
                    {
                        return $data->bahan->nama;
                    }else{
                        return 'N/A';
                    }

                })
                ->addColumn('tarikh_pinjam', function($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pinjaman);
                    return $tarikh;
                })
                ->addColumn('tarikh_pulang', function($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pulang);
                    return $tarikh;
                })
                ->addColumn('status_pinjaman', function($data) {
                    switch($data->status)
                {
                    case 0 :
                        return '<span class="badge badge-primary">Dipinjam</span>';
                    break;

                    case 1 :
                        return '<span class="badge badge-info">Dipulang</span>';
                    break;
                }
                })
                ->addColumn('denda', function($data) {
                    return 'ok';
                })
                ->addColumn('status_denda', function($data) {
                    return 'ok';
                })
                ->addColumn('action', function($data){
                    return '
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
                ->rawColumns(['status_pinjaman','action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama_bahan', 'name' => 'nama_bahan', 'title' => 'Nama Buku/Bahan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_pinjam', 'name' => 'tarikh_pinjam', 'title' => 'Tarikh Pinjaman', 'orderable'=> false],
                ['data' => 'tarikh_pulang', 'name' => 'tarikh_pulang', 'title' => 'Tarikh Pulang', 'orderable'=> false],
                ['data' => 'status_pinjaman', 'name' => 'status_pinjaman', 'title' => 'Status Pinjaman', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

            return view($this->baseView.'semak', compact('model', 'title', 'breadcrumbs', 'page_title', 'dataTable'));
    }
}
