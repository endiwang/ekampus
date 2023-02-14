<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\Syukbah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SyukbahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pendaftaran.syukbah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Pendaftaran Syukbah Pelajar";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pendaftaran" =>  false,
                "Syukbah Pelajar" =>  false,
            ];

            $buttons = [];

            if (request()->ajax()) {
                $data = Pelajar::with('kursus', 'sesi')->where('syukbah_id', NULL)->orWhere('syukbah_id', 0)->where('is_register', 1)->where('is_berhenti', 0);
                return DataTables::of($data)
                ->addColumn('no_ic', function($data) {
                    if(!empty($data->no_matrik)){
                        $data = '<p style="text-align:center">' . $data->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->no_matrik . '] </span></p>';
                    }
                    else {
                        $data = '<p style="text-align:center">' . $data->no_ic . '</p>';
                    }
                    
                    return $data;
                })
                ->addColumn('sesi_id', function($data) {
                    return $data->sesi->nama ?? null;
                })
                ->addColumn('kursus_id', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.syukbah_pelajar.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
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
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan [No. Matrik]', 'orderable'=> false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Kemasukan', 'orderable'=> false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
        $validation = $request->validate([
            'syukbah'          => 'required',
        ],[
            'syukbah.required' => 'Sila pilih syukbah',
        ]);

        try {

            //check for syukbah kuota
            $count_student_in_syukbah = Pelajar::where('sesi_id', $request->sesi_id)->where('syukbah_id', $request->syukbah)->count();

            //get syukbah quota
            $syukbah = Syukbah::where('kursus_id', $request->kursus_id)->first();

            if($count_student_in_syukbah > $syukbah->kuota_pelajar)
            {
                Alert::toast('Jumlah Pelajar bagi syukbah telah melebihi kapasiti yang ditetapkan!', 'error');
                return redirect()->back();
            }

            $update_syukbah = Pelajar::find($request->id_pelajar)->update([
                'syukbah_id' => $request->syukbah
            ]);

            Alert::toast('Maklumat syukbah pelajar berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.akademik.kelas_pelajar.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
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
        try {

            $title = 'Pendaftaran Syukbah Pelajar';
            $action = route('pengurusan.akademik.syukbah_pelajar.store');
            $page_title = 'Daftar Syukbah Pelajar';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pendaftaran" =>  false,
                "Daftar Syukbah" =>  false,
            ];

            $model = Pelajar::with('sesi', 'kursus', 'syukbah')->find($id);

            $syukbah = Syukbah::where('deleted_at', NULL)->where('kursus_id', $model->kursus_id)->pluck('nama', 'id');

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'syukbah'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
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
