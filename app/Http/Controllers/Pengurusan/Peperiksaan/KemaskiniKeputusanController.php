<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PelajarSemesterDetail;
use App\Models\Semester;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniKeputusanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.kemaskini_keputusan.';
    protected $baseRoute = 'pengurusan.peperiksaan.kemaskini_keputusan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Kemaskini Keputusan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini Keputusan' => false,
            ];

            if (request()->ajax()) {
                $data = Pelajar::with( 'kursus', 'sesi', 'syukbah', 'pusat_pengajian')->where('is_deleted', 0)->where('is_register', 1);
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }
                if ($request->has('sesi') && $request->sesi != null) {
                    $data->where('sesi_id', $request->sesi);
                }
                if ($request->has('semester_pengajian') && $request->semester_pengajian != null) {
                    $data->where('semester', $request->semester_pengajian);
                }
                if ($request->has('nama_pelajar') && $request->nama_pelajar != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama_pelajar.'%');
                }

                return DataTables::of($data)
                    ->addColumn('no_ic', function ($data) {
                        if (! empty($data->no_matrik)) {
                            $data = '<p>'.$data->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik.'] </span></p>';
                        } else {
                            $data = $data->no_ic;
                        }

                        return $data;
                    })
                    ->addColumn('semester_id', function ($data) {
                        return $data->semester ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        
                        $data = '<p><span style="font-weight:bold">'
                                    .$data->kursus->nama.'</span><br/>['. $data->pusat_pengajian->nama .']<br/> 
                                    <span style="font-weight:bold"> [ Semester '.$data->semester.'] </span>
                                </p>';
                       
                        return $data ?? null;
                    })
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('syukbah_id', function ($data) {
                        return $data->syukbah->nama ?? null;
                    })
                    ->addColumn('action', function ($data) use ($request) {
                        return '<a href="'.route($this->baseRoute.'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat Pelajar">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['kursus_id', 'no_ic', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. K/P [No.Matrik]', 'orderable' => false],
                    ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Kemasukan', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'syukbah_id', 'name' => 'syukbah_id', 'title' => 'Syukbah', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'sessions','semesters'));

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
        try {

            $pointer = Utils::getPointer($request->markah);
  
            $store = PelajarSemesterDetail::find($request->id);
            $store->markah_40   = $request->markah_40 ?? null;
            $store->markah_60   = $request->markah_60 ?? null;
            $store->pointer     = $pointer ?? '0.00';
            $store->markah      = $request->markah ?? null;
            $store->gred        = $request->gred ?? null;
            $store->save();
  
            Alert::toast('Maklumat subjek peperiksaan berjaya dikemaskini!', 'success');
  
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
    public function show($id, Builder $builder)
    {
        try {
            $title = 'Kemaskini Keputusan';
            $page_title = 'Maklumat Pelajar';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini Keputusan' => route($this->baseRoute.'index'),
                'Maklumat Pelajar' => false,
            ];

            $model = Pelajar::with('kursus', 'sesi', 'kelas')->find($id);
            $current_sem_detail = PelajarSemester::with('pelajarSemesterDetails')->where('pelajar_id', $model->pelajar_id_old)
                                ->where('semester',  $model->semester)->first();
            $all_semesters = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek')->where('pelajar_id', $model->pelajar_id_old)
                                ->where('semester', '!=', $model->semester)->get();

            if (request()->ajax()) {
              $data = PelajarSemesterDetail::with('subjek', 'sesi')->where('pelajar_semester_id', $current_sem_detail->id);

              return DataTables::of($data)
                  ->addColumn('subjek', function ($data) {
                      return $data->subjek->nama ?? null;
                  })
                  ->addColumn('kod_subjek', function ($data) {
                      return $data->subjek->kod_subjek ?? null;
                  })
                  ->addColumn('jam_kredit', function ($data) {
                      return $data->subjek->kredit ?? null;
                  })
                  ->addColumn('mata', function ($data) {
                    return !empty($data->pointer) ? number_format($data->pointer, 2) : null;
                  })
                  ->addColumn('markah', function ($data) {
                    return !empty($data->markah) ? number_format($data->markah, 2) : null;
                  })
                  ->addColumn('action', function ($data) use ($model) {
                      return '<button type="button" data-id='.$data->id.' pelajar-id='.$model->id.' id="buttonMaklumatSubjekPelajar" onclick="getMaklumatSubjekPelajar(this);" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                                <i class="fa fa-pencil-alt"></i>
                            </button>
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
                  ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable' => false],
                  ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable' => false],
                  ['data' => 'jam_kredit', 'name' => 'jam_kredit', 'title' => 'Jam Kredit', 'orderable' => false, 'class' => 'text-bold'],
                  ['data' => 'mata', 'name' => 'mata', 'title' => 'Mata', 'orderable' => false],
                  ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred', 'orderable' => false],
                  ['data' => 'markah', 'name' => 'markah', 'title' => 'Markah', 'orderable' => false],
                  ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

              ])
              ->minifiedAjax();

            return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'dataTable', 'all_semesters'));

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

    public function getMaklumatSubjekPelajar(Request $request)
    {
        $data = PelajarSemesterDetail::with('subjek')->find($request->id_data);
        $pelajar = Pelajar::with('sesi')->find($request->id_pelajar);
        $current_sem = Utils::getCurrenSemester($pelajar->kursus_id);

        $response = "<div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>NAMA PELAJAR </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$pelajar->nama."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>SESI KEMASUKAN </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$pelajar->no_ic."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>SEMESTER PENGAJIAN </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: Semester ".$current_sem->semester_no."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>SUBJEK </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->subjek->nama."</span>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>JAM KREDIT </label>
                        <div class='col-lg-8'>
                            <span class='fw-bold fs-7 text-gray-800'>: ".$data->subjek->kredit."</span>
                        </div>
                    </div>
                    <form id='tamat_pengajian' action=".route($this->baseRoute . 'store')." method='POST'>
                    <input type='hidden' name='_token' value=".csrf_token().">
                    <input type='hidden' name='id' value=".$data->id.">
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Markah 40% <i>(Markah peperiksaan 40%)</i></label>
                        <div class='col-lg-8'>
                            <input type='number' class='form-control form-control-sm' name='markah_40'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Markah 60% <i>(Markah peperiksaan akhir 60%)</i></label>
                        <div class='col-lg-8'>
                            <input type='number' class='form-control form-control-sm' name='markah_60'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Markah </label>
                        <div class='col-lg-8'>
                            <input type='number' class='form-control form-control-sm' name='markah'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Gred </label>
                        <div class='col-lg-8'>
                            <input type='text' class='form-control form-control-sm' name='gred'/>
                        </div>
                    </div>
                    </form>";

        return $response;
    }

    public function cetakTranskrip($id)
    {
        try {    
            $pelajar = Pelajar::where('pelajar_id_old', $id)->first();
            $datas = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 
                        'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'sesi')->where('pelajar_id', $id)->get();
        
            $pangkat = '';
            
            //get all user semester details
            $semesters = [];
            $pangkat = '';
            $pangkat_code = '';
            $pngk = '';
            foreach($datas as $data)
            {
                $sem_text = '';
                if($data->semester == '1')
                {
                    $sem_text = 'SATU';
                }
                elseif($data->semester == '2')
                {
                    $sem_text = 'DUA';
                }
                elseif($data->semester == '3')
                {
                    $sem_text = 'TIGA';
                }
                elseif($data->semester == '4')
                {
                    $sem_text = 'EMPAT';
                }
                elseif($data->semester == '5')
                {
                    $sem_text = 'LIMA';
                }
                elseif($data->semester == '6')
                {
                    $sem_text = 'ENAM';
                }
                $semesters[] = [
                    'sesi' => $data->sesi->nama,
                    'semester' => $sem_text,
                    'transcript_datas' => $data->pelajarSemesterDetails,
                    'pngs' => number_format($data->png,2),
                    'pngk' => number_format($data->pngk,2),
                ]; 

                if($data->pangkat == 'JJ')
                {
                    $pangkat_desc = 'Jayyid Jiddan';
                }
                else if($data->pangkat == 'J')
                {
                    $pangkat_desc = 'Jayyid';
                }
                else if($data->pangkat == 'MZ' || $data->pangkat == 'M')
                {
                    $pangkat_desc = 'Mumtaz';
                }
                $pangkat = $pangkat_desc;
                $pangkat_code = $data->pangkat;
                $pngk = $data->pngk;
            }

            $export_data  = [
                'nama' => $pelajar->nama ?? null,
                'ic_no' => $pelajar->no_ic ?? null,
                'no_matrik' => $pelajar->no_matrik ?? null,
                'program' => $pelajar->kursus->nama ?? null,
                'syukbah' => $pelajar->syukbah->nama ?? null,
                'sesi' => $pelajar->sesi->nama ?? null,
                'data' => $semesters,
                'pngk' => $pngk,
                'pangkat_code' => $pangkat_code,
                'pangkat' => $pangkat,
            ];

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'transkrip_pdf', compact('export_data'))->setPaper('a4', 'portrait');
    
            return $pdf->stream();
    
        } catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
    
            return redirect()->back();
        }
    }
}
