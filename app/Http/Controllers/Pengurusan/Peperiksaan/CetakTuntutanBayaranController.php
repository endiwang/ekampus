<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PelajarSemesterDetail;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CetakTuntutanBayaranController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.cetak_tuntutan_bayaran.';
    protected $baseRoute = 'pengurusan.peperiksaan.cetak_tuntutan_bayaran.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title = 'Cetak Tuntutan Bayaran';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Cetak Tuntutan Bayaran' => false,
            ];

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'courses', 'semesters', 'campuses', 'sessions', 'classes'));

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

    public function downloadDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian'     => 'required',
            'pusat_pengajian'       => 'required',
            'semester_pengajian'    => 'required',
            'sesi'                  => 'required',
        ], [
            'program_pengajian.required'    => 'Sila pilih program pengajian',
            'pusat_pengajian.required'      => 'Sila pilih pusat pengajian',
            'semester_pengajian.required'   => 'Sila pilih semester',
            'sesi.required'                 => 'Sila pilih sesi',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        //dd($request->all());
        // try {
            $type = $request->jenis;
            $data = $request->all();

            $generated_at = Utils::formatDate(now());
            switch($type)
            {
                case 1 :
                    //generate PDF
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView($this->baseView.'tuntutan_pdf', compact('data', 'generated_at'))->setPaper('a4', 'landscape');

                    return $pdf->stream();
                break;

                case 2 :
                    //generate PDF
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView($this->baseView.'tuntutan_sebelum_pdf', compact('data', 'generated_at'))->setPaper('a4', 'landscape');

                    return $pdf->stream();
                break;
            }

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    private function getSubject($request)
    {
        $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semester', 'sesi');
            if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('kursus_id', $request->program_pengajian);
                });
            }
            if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                });
            }
            if ($request->has('semester_pengajian') && $request->semester_pengajian != null) {
                $data->where('semester', $request->semester_pengajian);
            }
            if ($request->has('kelas') && $request->kelas != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('kelas_id', $request->kelas);
                });
            }
            if ($request->has('sesi') && $request->sesi != null) {
                $data->where('sesi_id', $request->sesi);
            }
        $datas = $data->get();

        $subjects = [];

        foreach($datas as $data)
        {
            foreach($data->pelajarSemesterDetails as $detail)
            {
                
            }
        }
    }

    public function tuntutanBayaran($data)
    {
        // $pelajar = Pelajar::
    }

    public function getRateBayaran($subjek_id)
    {

    }
}
