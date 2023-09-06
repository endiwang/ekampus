<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PusatPengajian;
use App\Models\Sesi;
use App\Models\Syukbah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class CetakanTranskripController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.cetak_transkrip_peperiksaan.';

    protected $baseRoute = 'pengurusan.peperiksaan.cetakan_transkrip_peperiksaan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder)
    {
        try {
            $title = 'Senarai Maklumat Pengajian';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Pengajian' => false,
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('sesi', 'kursus', 'pelajarSemesters', 'syukbah', 'pusat_pengajian')->where('deleted_at', null)->where('is_register', 1);
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }
                if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                }
                if ($request->has('kelas') && $request->kelas != null) {
                    $data->where('kelas_id', $request->kelas);
                }
                if ($request->has('sesi') && $request->sesi != null) {
                    $data->where('sesi_id', $request->sesi);
                }
                if ($request->has('syukbah') && $request->syukbah != null) {
                    $data->where('syukbah_id', $request->syukbah);
                }

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('syukbah_id', function ($data) {
                        return $data->syukbah->nama ?? null;
                    })
                    ->addColumn('pusat_pengajian_id', function ($data) {
                        return $data->pusat_pengajian->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'download_transkrip', $data->pelajar_id_old).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa-solid fa-circle-down"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'pusat_pengajian_id', 'name' => 'pusat_pengajian_id', 'title' => 'Pusat Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'syukbah_id', 'name' => 'syukbah_id', 'title' => 'Syukbah', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $syukbah = Syukbah::where('deleted_at', null)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'campuses', 'syukbah', 'sessions', 'classes'));

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

    public function downloadTranskrip($id)
    {
        // try {
        $pelajar = Pelajar::where('pelajar_id_old', $id)->first();
        $datas = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar',
            'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'sesi')->where('pelajar_id', $id)->get();

        $pangkat = '';

        //get all user semester details
        $semesters = [];
        $pangkat = '';
        $pangkat_code = '';
        $pngk = '';
        foreach ($datas as $data) {
            $sem_text = '';
            if ($data->semester == '1') {
                $sem_text = 'SATU';
            } elseif ($data->semester == '2') {
                $sem_text = 'DUA';
            } elseif ($data->semester == '3') {
                $sem_text = 'TIGA';
            } elseif ($data->semester == '4') {
                $sem_text = 'EMPAT';
            } elseif ($data->semester == '5') {
                $sem_text = 'LIMA';
            } elseif ($data->semester == '6') {
                $sem_text = 'ENAM';
            }
            $semesters[] = [
                'sesi' => $data->sesi->nama,
                'semester' => $sem_text,
                'transcript_datas' => $data->pelajarSemesterDetails,
                'pngs' => number_format($data->png, 2),
                'pngk' => number_format($data->pngk, 2),
            ];

            if ($data->pangkat == 'JJ') {
                $pangkat_desc = 'Jayyid Jiddan';
            } elseif ($data->pangkat == 'J') {
                $pangkat_desc = 'Jayyid';
            } elseif ($data->pangkat == 'MZ' || $data->pangkat == 'M') {
                $pangkat_desc = 'Mumtaz';
            }
            $pangkat = $pangkat_desc;
            $pangkat_code = $data->pangkat;
            $pngk = $data->pngk;
        }

        $export_data = [
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
            // 'pngk' => '' ,number_format($data->pngk,2) ?? null,
            // 'pangkat_code' => $data->pangkat,
            // 'pangkat' => $pangkat,
        ];

        //dd($export_data);
        //generate PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView($this->baseView.'transkrip_pdf', compact('export_data'))->setPaper('a4', 'portrait');

        return $pdf->stream();

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }
}
