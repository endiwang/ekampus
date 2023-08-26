<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PelajarSemesterDetail;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SenaraiCalonPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.calon_peperiksaan.';
    protected $baseRoute = 'pengurusan.peperiksaan.calon_peperiksaan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Senarai Calon Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Senarai Calon Peperiksaan' => false,
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('sesi', 'kursus', 'syukbah', 'kelas')->where('is_deleted', 0)->where('is_register', 1)->where('is_berhenti', 1);
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }
                if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                }
                if ($request->has('sesi_kemasukan') && $request->sesi_kemasukan != null) {
                    $data->where('sesi_id', $request->sesi_kemasukan);
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
                            $data = '<p style="text-align:center">'.$data->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik.'] </span></p>';
                        } else {
                            $data = $data->no_ic;
                        }

                        return $data;
                    })
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('syukbah_id', function ($data) {
                        return $data->syukbah->nama ?? null;
                    })
                    ->addColumn('penilaian', function ($data) {
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Belum Membuat Penilaian</span>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['no_ic', 'penilaian', 'action'])
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
                    ['data' => 'penilaian', 'name' => 'penilaian', 'title' => 'Penilaian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $intake_sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'campuses', 'intake_sessions', 'semesters'));

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

            $store = PelajarSemesterDetail::find($request->id);
            $store->kehadiran   = $request->kehadiran;
            $store->markah_30   = $request->markah_30;
            $store->markah_40   = $request->markah_40;
            $store->status      = $request->status;
            $store->komen_staff = $request->catatan;
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
            $title = 'Senarai Calon Peperiksaan';
            $page_title = 'Maklumat Subjek Pelajar';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Senarai Calon Peperiksaan' => route($this->baseRoute.'index'),
                'Maklumat subjek' => false,
            ];

            $model = Pelajar::with('kursus', 'sesi', 'kelas')->find($id);
            $current_sem = Utils::getCurrenSemester($model->kursus_id);
            $pelajar_semester = PelajarSemester::where('pelajar_id', $model->pelajar_id_old)->where('semester', $current_sem->semester_no)->first();

            if (request()->ajax()) {
                $data = PelajarSemesterDetail::with('subjek')->where('pelajar_semester_id', $pelajar_semester->id);
                
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
                    ->addColumn('kehadiran', function ($data) {
                        return $data->kehadiran ??  0 . '%';
                    })
                    ->addColumn('markah', function ($data) {
                        return $data->markah_30 ??  0 . '%';
                    })
                    ->addColumn('jumlah_markah', function ($data) {
                        return $data->markah_40 ??  0 . '%';
                    })
                    ->addColumn('status', function ($data) {
                        return $data->status ?? null;
                    })
                    ->addColumn('catatan', function ($data) {
                        return $data->komen_staff ?? null;
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '<button type="button" data-id='.$data->id.' pelajar-id='.$id.' id="buttonMaklumatSubjekPelajar" onclick="getMaklumatSubjekPelajar(this);" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
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
                    ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Nama Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kod_subjek', 'name' => 'no_ic', 'title' => 'Kod Subjek', 'orderable' => false],
                    ['data' => 'jam_kredit', 'name' => 'sesi_id', 'title' => 'Jam Kredit', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kehadiran', 'name' => 'kursus_id', 'title' => 'Kehadiran 10%', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'markah', 'name' => 'syukbah_id', 'title' => 'Markah 30%', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'jumlah_markah', 'name' => 'penilaian', 'title' => 'Jumlah Markah 40%', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'status', 'name' => 'penilaian', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'catatan', 'name' => 'penilaian', 'title' => 'Catatan', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'dataTable', 'page_title', 'current_sem'));

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
                    <form id='no_matrik' action=".route('pengurusan.peperiksaan.calon_peperiksaan.store')." method='POST'>
                    <input type='hidden' name='_token' value=".csrf_token().">
                    <input type='hidden' name='id' value=".$data->id.">
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Kehadiran 10% </label>
                        <div class='col-lg-8'>
                            <input type='text' class='form-control form-control-sm' name='kehadiran'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Markah 30% </label>
                        <div class='col-lg-8'>
                            <input type='text' class='form-control form-control-sm' name='markah_30'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Markah 40% </label>
                        <div class='col-lg-8'>
                            <input type='text' class='form-control form-control-sm' name='markah_40'/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Status </label>
                        <div class='col-lg-8'>
                            <select class='form-control form-select form-select-sm' data-control='select2' name='status' id='status'>
                                <option value=''>Pilih Status</option>
                                <option value='Layak'>Layak</option>
                                <option value='Tidak Layak'>Tidak Layak</option>
                            </select>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <label class='col-lg-4 fw-semibold'>Nota Catatan </label>
                        <div class='col-lg-8'>
                            <select class='form-control form-select form-select-sm' data-control='select2' name='catatan' id='catatan'>
                                <option value=''>Pilih Nota Catatan</option>
                                <option value='Dihalang kerana tidak cukup muqarrar hafazan'>Dihalang kerana tidak cukup muqarrar hafazan</option>
                                <option value='Dihalang kerana tidak cukup kehadiran'>Dihalang kerana tidak cukup kehadiran</option>
                                <option value='Tidak Lengkap'>Tidak Lengkap</option>
                                <option value='Tarik Diri'>Tarik Diri</option>
                                <option value='Tidak Hadir Tanpa Kebenaran'>idak Hadir Tanpa Kebenaran</option>
                                <option value='Tidak Hadir dengan kebenaran atau sakit'>Tidak Hadir dengan kebenaran atau sakit</option>
                                <option value='Tangguh Peperiksaan'>Tangguh Peperiksaan</option>
                            </select>
                        </div>
                    </div>
                    </form>";

        return $response;
    }

    public function downloadSlip($pelajar_id)
    {
        try {
    
            $model = Pelajar::with('kursus', 'sesi', 'syukbah')->where('user_id', $pelajar_id)->first();
            $current_sem = Utils::getCurrenSemester($model->kursus_id);
            $pelajar_semester = PelajarSemester::where('pelajar_id', $model->pelajar_id_old)->where('semester', $current_sem->semester_no)->first();

            $slip_data = PelajarSemesterDetail::with('subjek')->where('pelajar_semester_id', $pelajar_semester->id)->where('status', 'Layak')->get();

            $generated_at = Utils::formatDate(now());

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'slip_pdf', compact('slip_data', 'generated_at', 'model', 'current_sem'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
