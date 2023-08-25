<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\PelajarSemester;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use App\Models\Syukbah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CetakanKeputusanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.cetakan_keputusan_peperiksaan.';

    protected $baseRoute = 'pengurusan.peperiksaan.cetakan_keputusan_peperiksaan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $title = 'Cetak Keputusan Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Cetak Keputusan Peperiksaan' => false,
            ];

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $syukbah = Syukbah::where('deleted_at', null)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');

            $data = $request->all();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'courses', 'semesters', 'campuses', 'syukbah', 'sessions', 'classes'));

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

    public function getCourses()
    {
        $course = Kursus::where('deleted_at', null)->get();

        return response()->json($course);
    }

    public function getSession(Request $request)
    {

    }

    public function getSyukbah(Request $request)
    {

    }

    public function getClasses(Request $request)
    {

    }

    public function downloadKeputusan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
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
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            $data = $data->get();

            if (! empty($request->tarikh_keputusan)) {
                $date = Utils::formatDate($request->tarikh_keputusan);
            } else {
                $date = Utils::formatDate(now());
            }

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'download_pdf', compact('data', 'date'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
