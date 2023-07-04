<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Clo;
use App\Models\CloPlo;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Plo;
use App\Models\Staff;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

use Validator;

class CloPloController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Pemetaan CLO & PLO";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Pemetaan CLO & PLO" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Pemetaan CLO & PLO",
                    'route' => route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = CloPlo::with('subjek', 'kursus', 'clo', 'plo', 'pensyarah', 'kelas');
                if($request->has('program_pengajian') && $request->program_pengajian != NULL)
                {
                    $data->where('program_pengajian_id', $request->program_pengajian);
                }
                if($request->has('kursus') && $request->kursus != NULL)
                {
                    $data->where('kursus_id', $request->kursus);
                }
                if($request->has('kelas') && $request->kelas != NULL)
                {
                    $data->where('kelas_id', $request->kelas);
                }
                if($request->has('clo') && $request->clo != NULL)
                {
                    $data->where('clo_id', $request->clo);
                }
                if($request->has('plo') && $request->plo != NULL)
                {
                    $data->where('plo_id', $request->plo);
                }
                
                return DataTables::of($data)
                ->addColumn('clo', function($data) {
                    return $data->clo->name ?? null;
                })
                ->addColumn('plo', function($data) {
                     return $data->plo->name ?? null;
                })
                ->addColumn('pensyarah', function($data) {
                    return $data->pensyarah->nama ?? null;
                })
                ->addColumn('subjek', function($data) {
                   return $data->subjek->nama ?? null;
                })
                ->addColumn('kursus', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('kelas', function($data) {
                    return $data->kelas->nama ?? null;
                })
                ->addColumn('marks', function($data) {
                    return number_format($data->marks, 2) ?? null;
                })
                ->addColumn('created_at', function($data) {
                    return Utils::formatDate($data->created_at) ?? null;
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'clo', 'name' => 'clo', 'title' => 'CLO', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'plo', 'name' => 'plo', 'title' => 'PLO', 'orderable'=> false],
                ['data' => 'kelas', 'name' => 'kelas', 'title' => 'Kelas', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'subjek', 'name' => 'subjek', 'title' => 'subjek', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Program Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'pensyarah', 'name' => 'pensyarah', 'title' => 'Pensyarah', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'marks', 'name' => 'marks', 'title' => 'Markah (%)', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Rekod Dicipta', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            $courses = Kursus::where('is_deleted', 0)->get()->pluck('nama','id');
            $subjects = Subjek::where('is_deleted', 0)->get()->pluck('nama', 'id');
            $clos = Clo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $plos = Plo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $classes = Kelas::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable','courses', 'subjects', 'clos', 'plos', 'classes'));

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
        try {

            $title = 'Tambah Pemetaan CLO & PLO';
            $action = route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.store');
            $page_title = 'Pemetaan Maklumat CLO & PLO';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Pemetaan CLO & PLO" =>  route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index'),
                "Tambah Pemetaan CLO & PLO" => false,
            ];

            $model = new CloPlo();

            $courses = Kursus::where('deleted_at', NULL)->get()->pluck('nama', 'id');
            $subjects = Subjek::where('is_deleted', 0)->get();
            $clos = Clo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $plos = Plo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $classes = Kelas::where('is_deleted', 0)->get()->pluck('nama', 'id');
            $lecturers = Staff::where('is_pensyarah', 'Y')->where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'courses', 'subjects', 'clos', 'plos', 'classes', 'lecturers'));


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian'     => 'required',
            'subjek'                => 'required',
            'kelas'                 => 'required',
            'pensyarah'             => 'required',
            'clo'                   => 'required',
            'plo'                   => 'required',
            'markah'                => 'required',
        ], [
            'program_pengajian.required'    => 'Sila pilih program pengajian',
            'subjek.required'               => 'Sila pilih subjek',
            'kelas.required'                => 'Sila pilih kelas',
            'pensyarah.required'            => 'Sila pilih pensyarah',
            'clo.required'                  => 'Sila pilih clo',
            'plo.required'                  => 'Sila pilih plo',
            'markah.required'               => 'Sila masukkan markah',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
        
        try {
            $rekod = new CloPlo();
            $rekod->program_pengajian_id    = $request->program_pengajian;
            $rekod->kursus_id               = $request->subjek;
            $rekod->pensyarah_id            = $request->pensyarah;
            $rekod->kelas_id                = $request->kelas;
            $rekod->clo_id                  = $request->clo;
            $rekod->plo_id                  = $request->plo;
            //$rekod->jabatan_id              = $request->status;
            $rekod->marks                   = $request->markah;
            $rekod->status                  = $request->status;
            $rekod->created_by              = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat pemetaan clo & plo berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index');


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

            $title = 'Pinda Pemetaan CLO & PLO';
            $action = route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.update', $id);
            $page_title = 'Pemetaan Maklumat CLO & PLO';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Pemetaan CLO & PLO" =>  route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index'),
                "Pinda Pemetaan CLO & PLO" => false,
            ];

            $model = CloPlo::find($id);

            $courses = Kursus::where('deleted_at', NULL)->get()->pluck('nama', 'id');
            $subjects = Subjek::where('is_deleted', 0)->get();
            $clos = Clo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $plos = Plo::where('is_deleted', 0)->get()->pluck('name', 'id');
            $classes = Kelas::where('is_deleted', 0)->get()->pluck('nama', 'id');
            $lecturers = Staff::where('is_pensyarah', 'Y')->where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'courses', 'subjects', 'clos', 'plos', 'classes', 'lecturers'));


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
        $validator = Validator::make($request->all(), [
            'program_pengajian'     => 'required',
            'subjek'                => 'required',
            'kelas'                 => 'required',
            'pensyarah'             => 'required',
            'clo'                   => 'required',
            'plo'                   => 'required',
            'markah'                => 'required',
        ], [
            'program_pengajian.required'    => 'Sila pilih program pengajian',
            'subjek.required'               => 'Sila pilih subjek',
            'kelas.required'                => 'Sila pilih kelas',
            'pensyarah.required'            => 'Sila pilih pensyarah',
            'clo.required'                  => 'Sila pilih clo',
            'plo.required'                  => 'Sila pilih plo',
            'markah.required'               => 'Sila masukkan markah',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
        
        try {
            $rekod = CloPlo::find($id);
            $rekod->program_pengajian_id    = $request->program_pengajian;
            $rekod->kursus_id               = $request->subjek;
            $rekod->pensyarah_id            = $request->pensyarah;
            $rekod->kelas_id                = $request->kelas;
            $rekod->clo_id                  = $request->clo;
            $rekod->plo_id                  = $request->plo;
            //$rekod->jabatan_id              = $request->status;
            $rekod->marks                   = $request->markah;
            $rekod->status                  = $request->status;
            $rekod->created_by              = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat pemetaan clo & plo berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index');


        } catch (Exception $e) {
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
        try {

            CloPlo::find($id)->delete();

            Alert::toast('Maklumat pemetaan CLO & PLO berjaya dihapuskan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index');


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
