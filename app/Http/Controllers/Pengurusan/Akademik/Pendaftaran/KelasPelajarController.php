<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KelasPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pendaftaran.kelas_pelajar.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Pendaftaran Kelas Pelajar";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pendaftaran" =>  false,
                "Kelas Pelajar" =>  false,
            ];

            $buttons = [];

            if (request()->ajax()) {
                $data = Pelajar::with('kursus', 'kelas')->where('kelas_id', NULL)->where('is_register', 1)->where('is_berhenti', 0);
                return DataTables::of($data)
                ->addColumn('no_ic', function($data) {
                    if(!empty($data->no_matrik)){
                        $data = '<p style="text-align:center">' . $data->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->no_matrik . '] </span></p>';
                    }
                    else {
                        $data = $data->no_ic;
                    }
                    
                    return $data;
                })
                ->addColumn('kursus_id', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.kelas_pelajar.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
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
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable'=> false],
                ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable'=> false],
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
        try {
            //check if kelas kapasiti has exceeded
            $kelas = Kelas::find($request->kelas)->first();
            $new_capacity = $kelas->jumlah_pelajar + 1;

            if($new_capacity > $kelas->kapasiti_pelajar)
            {
                Alert::toast('Jumlah Pelajar telah melebihi kapasiti yang ditetapkan!', 'error');
                return redirect()->back();
            }

            //if not over capacity add count jumlah pelajar
            Kelas::find($request->kelas)->update([
                'jumlah_pelajar' => $new_capacity
            ]);

            //update column kelas id in table pelajar
            Pelajar::find($request->id_pelajar)->update([
                'kelas_id'  => $request->kelas
            ]);

            Alert::toast('Maklumat kelas pelajar berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.akademik.kelas_pelajar.index');

        }catch (Exception $e) {
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
        // try {

            $title = 'Pendaftaran Kelas Pelajar';
            $action = route('pengurusan.akademik.kelas_pelajar.store');
            $page_title = 'Daftar Kelas Pelajar';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pendaftaran" =>  false,
                "Daftar Kelas" =>  false,
            ];

            $model = Pelajar::with('sesi', 'kursus', 'syukbah')->find($id);

            $classes = Kelas::where('deleted_at', NULL)->get()->pluck('class_capacity', 'id');

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'classes'));

        // }catch (Exception $e) {
        //     report($e);
    
        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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

    public function updateClass(Request $request, $id)
    {
        dd($request->all());
        try {


            Alert::toast('Maklumat guru tasmik berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.guru_tasmik.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
