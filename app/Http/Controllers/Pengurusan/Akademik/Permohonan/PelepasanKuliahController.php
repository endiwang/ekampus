<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\PelepasanKuliah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PelepasanKuliahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.permohonan.pelepasan_kuliah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Pelepasan Kuliah";
            $breadcrumbs = [
                "Pelajar" =>  false,
                "Permohonan" =>  false,
                "Pelepasan Kuliah" =>  false,
            ];

            if (request()->ajax()) {
                $data = PelepasanKuliah::with('pelajar');
                return DataTables::of($data)
                ->addColumn('nama_pelajar', function($data) {
                    return $data->pelajar->nama ?? null;
                })
                ->addColumn('tarikh', function($data) {
                    $tarikh = Utils::formatDate($data->tarikh_mula) . ' - ' . Utils::formatDate($data->tarikh_akhir);

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
                ->addColumn('status_pengesahan_pensyarah', function($data) {
                    switch($data->status)
                    {
                        case 1 :
                            return 'Menunggu Pengesahan Pensyarah';
                        break;

                        case 2 :
                            return 'Lulus';
                        break;

                        case 3 :
                            return 'Tolak';
                        break;

                        default :
                            return 'Tiada Status';
                        break;
                    }
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.permohonan.pelepasan_kuliah.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
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
                ['data' => 'nama_permohonan', 'name' => 'nama_permohonan', 'title' => 'Nama Permohonan', 'orderable'=> false],
                ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pemohon', 'orderable'=> false],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Pelepasan', 'orderable'=> false],
                ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable'=> false],
                ['data' => 'status_pengesahan_pensyarah', 'name' => 'status_pengesahan_pensyarah', 'title' => 'Pengesahan Pensyarah', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
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
        try {

            $title = "Pelepasan Kuliah";
            $page_title = 'Maklumat Permohonan Pelepasan Kuliah';
            $breadcrumbs = [
                "Pelajar" =>  false,
                "Permohonan" =>  false,
                "Pelepasan Kuliah" =>  route('pengurusan.akademik.permohonan.pelepasan_kuliah.index'),
                "Maklumat Permohonan Pelepasan Kuliah" =>  false,
            ];

            $data = PelepasanKuliah::find($id);
    
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
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
