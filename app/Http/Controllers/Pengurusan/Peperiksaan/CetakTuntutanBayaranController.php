<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\CajPeperiksaan;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PelajarSemesterDetail;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\SemesterKursus;
use App\Models\SemesterSubjek;
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
            $subject_codes = $this->getSemesterSubjek($request);
            $size_subject = sizeof($subject_codes);
            $pusat_peperiksaan = PusatPengajian::select('nama')->find($request->program_pengajian);
            $pusat_peperiksaan = $pusat_peperiksaan->nama;
            $semester = Semester::select('nama')->find($request->semester_pengajian);
            $semester = $semester->nama;

            switch($type)
            {
                case 1 :
                    $subject_datas = $this->getStudentDataWithRateBefore($request);
                    $overall_total = $this->overallTotal($subject_datas);
                    $overall_col_size = 6 + $size_subject;
                   
                    //generate PDF
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView($this->baseView.'tuntutan_sebelum_pdf', 
                        compact('subject_codes', 
                                'subject_datas', 
                                'generated_at', 
                                'pusat_peperiksaan',
                                'semester',
                                'size_subject',
                                'overall_total',
                                'overall_col_size'))
                        ->setPaper('a4', 'landscape');

                    return $pdf->stream();
                break;

                case 2 :
                    $subject_datas = $this->getStudentDataWithRate($request);
                    $overall_total = $this->overallTotal($subject_datas);
                    $overall_col_size = 5 + $size_subject;
                
                    //generate PDF
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView($this->baseView.'tuntutan_pdf', 
                        compact('subject_codes', 
                                'subject_datas', 
                                'generated_at', 
                                'pusat_peperiksaan',
                                'semester',
                                'size_subject',
                                'overall_total',
                                'overall_col_size'))
                        ->setPaper('a4', 'landscape');
                    
                    return $pdf->stream();
                break;
            }

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    private function getSemesterSubjek($request)
    {
        $subjects = SemesterSubjek::with('subjek')
                    ->where('semester_id', $request->semester_pengajian)
                    ->where('kursus_id', $request->program_pengajian)
                    ->orderBy('id', 'asc')
                    ->get();

        $subject_code = [];
        foreach($subjects as $data)
        {
            $subject_code[] =[
                    'kod' => $data->subjek->kod_subjek,
                    'nama' => $data->subjek->nama,
                    'jam_kredit' => $data->subjek->kredit,
                ];
        }

        return $subject_code;
    }

    private function getStudentDataWithRateBefore($request)
    {
        $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajarSemesterDetails.subjek.cajPeperiksaan');
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
        $datas = $data->get()->take(10);

        $studentSubject = [];

        $pengurusan_peperiksaan = CajPeperiksaan::select('jumlah')->where('description', 'pengurusan_peperiksaan')->first();

        foreach($datas as $data)
        {
            $subject_rate = [];
            $total = 0;
            foreach($data->pelajarSemesterDetails as $detail)
            {
                $subject_rate[] = [
                    $detail->subjek->kod_subjek => !empty($detail->subjek->cajPeperiksaan->jumlah) ? number_format($detail->subjek->cajPeperiksaan->jumlah, 2) : '0.00'
                ];

                $total += $detail->cajPeperiksaan->jumlah;
            }

            $student_total = $total + 15;
            $studentSubject[] = [
                'nama' => $data->pelajar->nama ?? null,
                'jantina' => $data->pelajar->jantina ?? null,
                'no_matrik' => $data->pelajar->no_matrik ?? null,
                'no_ic' => $data->pelajar->no_ic ?? null,
                'data' => $subject_rate,
                'jumlah' => number_format($student_total,2),
                'pengurusan_peperiksaan' => !empty($pengurusan_peperiksaan->jumlah) ? number_format($pengurusan_peperiksaan->jumlah,2) : '0.00',
            ];
        }

        return $studentSubject;
    }

    public function overallTotal($datas)
    {
        $overall_total = 0;
        foreach($datas as $total)
        {
            $overall_total += $total['jumlah'];
        }

        return number_format($overall_total, 2);
    }

    private function getStudentDataWithRate($request)
    {
        $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajarSemesterDetails.subjek.cajPeperiksaan');
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
        $datas = $data->get()->take(10);

        $studentSubject = [];

        $pengurusan_peperiksaan = CajPeperiksaan::select('jumlah')->where('description', 'pengurusan_peperiksaan')->first();

        foreach($datas as $data)
        {
            $subject_rate = [];
            $total = 0;
            foreach($data->pelajarSemesterDetails as $detail)
            {
                $subject_rate[] = [
                    $detail->subjek->kod_subjek => !empty($detail->subjek->cajPeperiksaan->jumlah) ? number_format($detail->subjek->cajPeperiksaan->jumlah, 2) : '0.00'
                ];

                $total += $detail->cajPeperiksaan->jumlah;
            }

            $studentSubject[] = [
                'nama' => $data->pelajar->nama ?? null,
                'jantina' => $data->pelajar->jantina ?? null,
                'no_matrik' => $data->pelajar->no_matrik ?? null,
                'no_ic' => $data->pelajar->no_ic ?? null,
                'data' => $subject_rate,
                'jumlah' => number_format($total,2),
            ];
        }

        return $studentSubject;
    }
}
