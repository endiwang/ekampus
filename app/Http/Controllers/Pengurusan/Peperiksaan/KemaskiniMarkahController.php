<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\CloPlo;
use App\Models\CloPloMark;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\Semester;
use App\Models\Sesi;
use App\Models\Subjek;
use App\Models\Syukbah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniMarkahController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.kemaskini_markah.';
    protected $baseRoute = 'pengurusan.peperiksaan.kemaskini_markah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Kemaskini Markah';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini Markah' => false,
            ];

            if (request()->ajax()) {
                $data = CloPlo::with('clo', 'plo', 'kursus', 'subjek', 'kelas');
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('program_pengajian_id', $request->program_pengajian);
                }
                if ($request->has('kursus') && $request->kursus != null) {
                    $data->where('kursus_id', $request->kursus);
                }

                return DataTables::of($data)
                    ->addColumn('program_pengajian_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('kod_kursus', function ($data) {
                        return $data->subjek->kod_subjek ?? null;
                    })
                    ->addColumn('clo', function ($data) {
                        return $data->clo->name ?? null;
                    })
                    ->addColumn('plo', function ($data) {
                        return $data->plo->name ?? null;
                    })
                    ->addColumn('kelas_id', function ($data) {
                        return $data->kelas->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute . 'show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'program_pengajian_id', 'name' => 'program_pengajian_id', 'title' => 'Program Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kod_kursus', 'name' => 'kod_kursus', 'title' => 'Kod Kursus', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kod_kursus', 'name' => 'kod_kursus', 'title' => 'Kod Kursus', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'clo', 'name' => 'clo', 'title' => 'CLO', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'plo', 'name' => 'plo', 'title' => 'PLO', 'orderable' => false],
                    ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses    = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');
            $syukbah    = Syukbah::where('deleted_at', NULL)->pluck('nama', 'id');
            $semesters  = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $subjects   = Subjek::where('deleted_at', NULL)->pluck('kod_subjek', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'syukbah', 'semesters', 'subjects'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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
        //dd($request->all());
        try {
            
            CloPloMark::updateOrCreate([
                'clo_plo_id'            => $request->id,
                'pelajar_id'            => $request->pelajar_id,
                'kursus_id'             => $request->kursus_id,
                'semester_terkini_id'   => $request->semester_terkini,
            ],[
                'clo_marks'    => $request->markah_clo,
                'plo_marks'    => $request->markah_plo
            ]);

            Alert::toast('Markah CLO PLO berjaya dikemaskini berjaya dikemaskini!', 'success');

            return redirect()->back();

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
    public function show($id, Builder $builder, Request $request)
    {
        // try {
            $title = 'Kemaskini Markah';
            $page_title = 'Kemaskini Markah Pelajar';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini Markah' => route($this->baseRoute.'index'),
            ];

            //get all class related to the clo plo
            $kelas = CloPlo::select('kelas_id')->find($id);

            if (request()->ajax()) {
                $data = Pelajar::with('cloPloMark')->where('kelas_id', $kelas->kelas_id);
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%' . $request->nama . '%');
                }
                if ($request->has('no_ic') && $request->no_ic != null) {
                    $data->where('no_ic', 'LIKE', '%' . $request->no_ic . '%');
                }
                if ($request->has('no_matrik') && $request->no_matrik != null) {
                    $data->where('no_matrik', 'LIKE', '%' . $request->no_matrik . '%');
                }
                
                return DataTables::of($data)
                    ->addColumn('markah_clo', function ($data) {
                        return !empty($data->cloPloMark->clo_marks) ? number_format($data->cloPloMark->clo_marks,2) :  '0.00';
                    })
                    ->addColumn('markah_plo', function ($data) {
                        return !empty($data->cloPloMark->plo_marks) ? number_format($data->cloPloMark->plo_marks,2) :  '0.00';
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '<button type="button" data-id='.$data->id.' cloplo-id='.$id.' id="buttonMaklumatPelajar" onclick="getMaklumatPelajar(this);" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                    <i class="fa fa-user-check"></i>
                                </button>
                                ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'asc');
                    })
                    ->rawColumns(['no_ic', 'penilaian', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. KP', 'orderable' => false],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'markah_clo', 'name' => 'markah_clo', 'title' => 'markah CLO', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'markah_plo', 'name' => 'syukbah_id', 'title' => 'markah PLO', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'page_title', 'id'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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

    public function getMaklumatPelajar(Request $request)
    {
        $pelajar = Pelajar::with('sesi')->find($request->id_pelajar);
        $cloplo = CloPlo::with('clo', 'plo', 'cloPloMark')->find($request->id_cloplo);
        $current_sem = Utils::getCurrenSemester($cloplo->program_pengajian_id);

        $response = "<div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NAMA PELAJAR </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$pelajar->nama."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NO. KP </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$pelajar->no_ic."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NO. MATRIK </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$pelajar->no_matrik."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>CLO </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$cloplo->clo->name."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>PLO </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$cloplo->plo->name."</span>
                        </div>
                    </div>
                    <form id='kemaskini_markah' action=".route('pengurusan.peperiksaan.kemaskini_markah.store')." method='POST'>
                        <input type='hidden' name='_token' value=".csrf_token().">
                        <input type='hidden' name='id' value=".$request->id_cloplo.">
                        <input type='hidden' name='pelajar_id' value=".$pelajar->id.">
                        <input type='hidden' name='kelas_id' value=".$cloplo->kelas_id.">
                        <input type='hidden' name='kursus_id' value=".$cloplo->kursus_id.">
                        <input type='hidden' name='semester_terkini' value=".$current_sem->semester_no.">
                        <div class='row mb-2'>
                            <label class='col-lg-4 fw-semibold'>Markah CLO % </label>
                            <div class='col-lg-8'>
                                <input type='text' class='form-control form-control-sm' name='markah_clo'/>
                            </div>
                        </div>
                        <div class='row mb-2'>
                            <label class='col-lg-4 fw-semibold'>Markah PLO % </label>
                            <div class='col-lg-8'>
                                <input type='text' class='form-control form-control-sm' name='markah_plo'/>
                            </div>
                        </div>
                    </form>";

        return $response;
    }
}
