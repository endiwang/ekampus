<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianPensyarahController extends Controller
{
    protected $baseView = 'pages.pelajar.penilaian_pensyarah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Penilaian Pensyarah";
            $breadcrumbs = [
                "Pelajar" =>  false,
                "Penilaian Pensyarah" =>  false,
            ];

            $getClassId = Pelajar::select('kelas_id')->where('user_id', 7189)->first();
            $getJadualId = JadualWaktu::where('kelas_id', $getClassId->kelas_id)->where('status_pengajian', 1)->first();

            if (request()->ajax()) {
                $data = JadualWaktuDetail::where('jadual_waktu_id', $getJadualId->id);
                return DataTables::of($data)
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
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pelajar.permohonan.pelepasan_kuliah.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.pelepasan_kuliah.destroy', $data->id).'" method="POST">
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
                ['data' => 'nama_permohonan', 'name' => 'nama_permohonan', 'title' => 'Nama Permohonan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Pelepasan', 'orderable'=> false],
                ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable'=> false],
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
