<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniNamaPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.terjemahan_nama_pelajar.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Senarai Nama Pelajar - Terjemahan Bahasa Jawi";
            $breadcrumbs = [
                "Peperiksaan" =>  false,
                "Kemaskini" =>  false,
                "Senarai Nama Pelajar" =>  false,
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('sesi', 'kursus', 'syukbah');
                if($request->has('program_pengajian') && $request->program_pengajian != NULL)
                {
                    $data->where('kursus_id', $request->program_pengajian);
                }
                if($request->has('pusat_pengajian') && $request->pusat_pengajian != NULL)
                {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                }
                if($request->has('sesi_kemasukan') && $request->sesi_kemasukan != NULL)
                {
                    $data->where('sesi_id', $request->sesi_kemasukan);
                }
                if($request->has('semester_pengajian') && $request->semester_pengajian != NULL)
                {
                    $data->where('semester', $request->semester_pengajian);
                }
                if($request->has('nama_pelajar') && $request->nama_pelajar != NULL)
                {
                    $data->where('nama', 'LIKE', '%' . $request->nama_pelajar . '%');
                }
                
                return DataTables::of($data)
                ->addColumn('nama', function($data) {
                    if(!empty($data->nama_arab)){
                        $data = '<p>' . $data->nama . '<br/> <span style="font-weight:bold">'  . $data->nama_arab . ' </span></p>';
                    }
                    else {
                        $data = $data->nama;
                    }
                    
                    return $data;
                })
                ->addColumn('no_ic', function($data) {
                    if(!empty($data->no_matrik)){
                        $data = '<p style="text-align:center">' . $data->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->no_matrik . '] </span></p>';
                    }
                    else {
                        $data = $data->no_ic;
                    }
                    
                    return $data;
                })
                ->addColumn('sesi_id', function($data) {
                    return $data->sesi->nama ?? null;
                })
                ->addColumn('kursus_id', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('syukbah_id', function($data) {
                    return $data->syukbah->nama ?? null;
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.peperiksaan.kemaskini.nama_pelajar.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['nama', 'no_ic', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. K/P [No.Matrik]', 'orderable'=> false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Kemasukan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'syukbah_id', 'name' => 'syukbah_id', 'title' => 'Syukbah', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            $courses = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');
            $campuses = PusatPengajian::where('deleted_at', NULL)->pluck('nama', 'id');
            $intake_sessions = Sesi::where('deleted_at', NULL)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'campuses', 'intake_sessions', 'semesters'));

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
        try {

            $title = 'Kemaskini Terjemahan Nama Pelajar';
            $action = route('pengurusan.peperiksaan.kemaskini.nama_pelajar.update', $id);
            $page_title = 'Kemaskini Nama Pelajar';
            $breadcrumbs = [
                "Peperiksaan" =>  false,
                "Kemaskini" =>  false,
                "Senarai Nama Pelajar - Terjemhan Bahasa Jawi" =>  route('pengurusan.peperiksaan.kemaskini.nama_pelajar.index'),
                "Kemaskini Nama Pelajar" =>  false,
            ];

            $model = Pelajar::find($id);

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
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
        try {
            
            $update = Pelajar::find($id);
            $update->nama_arab       = $request->description;
            $update->save();
            
            Alert::toast('Maklumat terjemahan nama pelajar berjaya dikemaskini!', 'success');
            return redirect()->route('pengurusan.peperiksaan.kemaskini.nama_pelajar.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
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
