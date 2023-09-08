<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\PelajarSemester;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\SemesterSubjek;
use App\Models\SemesterTerkini;
use App\Models\Sesi;
use App\Models\SesiPeperiksaan;
use App\Models\Syukbah;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CetakanKeputusanPenuhController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.cetak_keputusan_penuh.';
    protected $baseRoute = 'pengurusan.peperiksaan.cetak_keputusan_penuh.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $title = 'Cetak Keputusan Penuh';
            $page_title = 'Senarai Cetak Keputusan Penuh';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Cetak Keputusan Penuh' => false,
            ];

            $reports = [
                [
                    'name' => 'Cetak Keputusan Penuh',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_penuh').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Keputusan Penuh">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Keputusan Penuh (Untuk Paparan Pelajar)',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_penuh_pelajar').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Keputusan Penuh (Untuk Paparan Pelajar)">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Keputusan Berdasarkan Pointer',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_pointer').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Keputusan Berdasarkan Pointer">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Keputusan Gred',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_gred').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Keputusan Gred">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Kedudukan PNGK',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_pngk').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kedudukan PNGK">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Kedudukan PNG',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'keputusan_png').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kedudukan PNG">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Cetak Kedudukan Keseluruhan',
                    'action' => '
                            <a href="'.route($this->baseRoute . 'show', 'kedudukan_keseluruhan').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kedudukan Keseluruhan">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
            ];

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'page_title', 'reports'));

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
        $title = 'Keputusan Penuh';

        $type = $id;

        $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
        $exam_sessions = SesiPeperiksaan::where('deleted_at', null)->pluck('nama', 'id');
        $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
        $syukbah = Syukbah::where('deleted_at', null)->pluck('nama', 'id');
        $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');
        $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');
        $genders = [
            'L' => 'Banin',
            'P' => 'Banat'
        ];

        $page_title = '';
        $action = '';
        $breadcrumbs = '';
        switch ($type) {
            case 'keputusan_penuh':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Keputusan Penuh' => false,
                ];

                $page_title = 'Cetak keputusan Penuh';
                $action = route($this->baseRoute . 'export_keputusan_penuh');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses',
                    'exam_sessions', 
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'keputusan_penuh_pelajar':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Keputusan Penuh (Untuk Paparan Pelajar)' => false,
                ];

                $page_title = 'Cetak Keputusan Penuh (Untuk Paparan Pelajar)';
                $action = route($this->baseRoute . 'cetak_keputusan_penuh_paparan_pelajar');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses',
                    'exam_sessions', 
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'keputusan_pointer':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Keputusan Berdasarkan Pointer' => false,
                ];
                $page_title = 'Cetak Keputusan Berdasarkan Pointer';
                $action = route($this->baseRoute . 'cetak_keputusan_pointer');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses',
                    'exam_sessions', 
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'keputusan_gred':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Keputusan Gred' => false,
                ];
                $page_title = 'Cetak Keputusan Gred';
                $action = route($this->baseRoute . 'cetak_keputusan_gred');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses', 
                    'exam_sessions',
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'keputusan_pngk':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Kedudukan PNGK' => false,
                ];
                $page_title = 'Cetak Kedudukan PNGK';
                $action = route($this->baseRoute . 'cetak_kedudukan_pngk');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses',
                    'exam_sessions', 
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'keputusan_png':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Kedudukan PNG' => false,
                ];
                $page_title = 'Cetak Kedudukan PNG';
                $action = route($this->baseRoute . 'cetak_kedudukan_png');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses', 
                    'exam_sessions',
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;

            case 'kedudukan_keseluruhan':
                $breadcrumbs = [
                    'Peperiksaan' => false,
                    'Cetak Kedudukan Keseluruhan' => false,
                ];
                $page_title = 'Cetak Kedudukan Keseluruhan';
                $action = route($this->baseRoute . 'cetak_kedudukan_keseluruhan');

                return view($this->baseView.'show', compact(
                    'title', 
                    'breadcrumbs', 
                    'page_title',
                    'action', 
                    'courses', 
                    'campuses',
                    'exam_sessions', 
                    'semesters', 
                    'syukbah', 
                    'sessions', 
                    'classes',
                    'genders'
                ));
            break;  
        }

        // }catch (Exception $e) {
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

    public function exportCetakKeputusanKeseluruhan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
            'kelas' => 'required'
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
            'kelas.required' => 'Sila pilih kelas',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $semesterSubjects = $this->getSemesterSubjek($request);

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $studentSubjects = [];
            foreach($data as $value)
            {
                $student_result = [];
                $total = 0;
                foreach($value->pelajarSemesterDetails as $detail)
                {
                    $student_result[] = [
                        $detail->subjek->kod_subjek => [
                            'm' => !empty($detail->markah) ? number_format($detail->markah,2) : '0.00',
                            'p' => !empty($detail->pointer) ? number_format($detail->pointer,2) : '0.00',
                            'jp' => !empty($detail->total_pointer) ? number_format($detail->total_pointer,2) : '0.00',
                            'g' => !empty($detail->gred) ? $detail->gred : 'N/A',
                        ]  
                    ];
                }

                $studentSubjects[] = [
                    'nama' => $value->pelajar->nama ?? null,
                    'jantina' => $value->pelajar->jantina ?? null,
                    'no_matrik' => $value->pelajar->no_matrik ?? null,
                    'no_ic' => $value->pelajar->no_ic ?? null,
                    'data' => $student_result,
                    'jk' => !empty($value->jam_kredit) ? number_format($value->jam_kredit,2) : '0.00',
                    'jmk' => !empty($value->jumlah_markah) ? number_format($value->jumlah_markah,2) : '0.00',
                    'png' => !empty($value->png) ? number_format($value->png,2) : '0.00',
                    'jkk' => !empty($value->jam_kredit_keseluruhan) ? number_format($value->jam_kredit_keseluruhan,2) : '0.00',
                    'jmkk' => !empty($value->jumlah_markah_keseluruhan) ? number_format($value->jumlah_markah_keseluruhan,2) : '0.00',
                    'pngk' => !empty($value->pngk) ? number_format($value->pngk,2) : '0.00',
                    'kep' => !empty($value->keputusan) ? $value->keputusan : 'N/A',
                    'pgkt' => !empty($value->pangkat) ? $value->pangkat : 'N/A',
                    'jms' => !empty($value->jumlah_markah_semester) ? number_format($value->jumlah_markah_semester,2) : '0.00',
                    'jks' => !empty($value->jam_kredit_semester) ? number_format($value->jam_kredit_semester,2) : '0',
                ];
            }

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_keputusan_penuh', 
                compact('studentSubjects', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at', 'semesterSubjects'))
                ->setPaper('a1', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportCetakKeputusanPenuhPaparanPelajar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
            'kelas' => 'required'
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
            'kelas.required' => 'Sila pilih kelas',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $semesterSubjects = $this->getSemesterSubjek($request);

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $studentSubjects = [];
            foreach($data as $value)
            {
                $student_result = [];
                $total = 0;
                foreach($value->pelajarSemesterDetails as $detail)
                {
                    $student_result[] = [
                        $detail->subjek->kod_subjek => [
                            'm' => !empty($detail->markah) ? number_format($detail->markah,2) : '0.00',
                            'p' => !empty($detail->pointer) ? number_format($detail->pointer,2) : '0.00',
                            'jp' => !empty($detail->total_pointer) ? number_format($detail->total_pointer,2) : '0.00',
                            'g' => !empty($detail->gred) ? $detail->gred : 'N/A',
                        ]  
                    ];
                }

                $studentSubjects[] = [
                    'nama' => $value->pelajar->nama ?? null,
                    'jantina' => $value->pelajar->jantina ?? null,
                    'no_matrik' => $value->pelajar->no_matrik ?? null,
                    'no_ic' => $value->pelajar->no_ic ?? null,
                    'data' => $student_result,
                    'jk' => !empty($value->jam_kredit) ? number_format($value->jam_kredit,2) : '0.00',
                    'jmk' => !empty($value->jumlah_markah) ? number_format($value->jumlah_markah,2) : '0.00',
                    'png' => !empty($value->png) ? number_format($value->png,2) : '0.00',
                    'jkk' => !empty($value->jam_kredit_keseluruhan) ? number_format($value->jam_kredit_keseluruhan,2) : '0.00',
                    'jmkk' => !empty($value->jumlah_markah_keseluruhan) ? number_format($value->jumlah_markah_keseluruhan,2) : '0.00',
                    'pngk' => !empty($value->pngk) ? number_format($value->pngk,2) : '0.00',
                    'kep' => !empty($value->keputusan) ? $value->keputusan : 'N/A',
                    'pgkt' => !empty($value->pangkat) ? $value->pangkat : 'N/A',
                    'jms' => !empty($value->jumlah_markah_semester) ? number_format($value->jumlah_markah_semester,2) : '0.00',
                    'jks' => !empty($value->jam_kredit_semester) ? number_format($value->jam_kredit_semester,2) : '0',
                ];
            }

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_keputusan_penuh', 
                compact('studentSubjects', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at', 'semesterSubjects'))
                ->setPaper('a1', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportCetakKeputusanPointer(Request $request)
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
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $semesterSubjects = $this->getSemesterSubjek($request);

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $studentSubjects = [];
            foreach($data as $value)
            {
                $student_result = [];
                $total = 0;
                foreach($value->pelajarSemesterDetails as $detail)
                {
                    $student_result[] = [
                        $detail->subjek->kod_subjek => [
                            'm' => !empty($detail->markah) ? number_format($detail->markah,2) : '0.00',
                            'p' => !empty($detail->pointer) ? number_format($detail->pointer,2) : '0.00',
                            'jp' => !empty($detail->total_pointer) ? number_format($detail->total_pointer,2) : '0.00',
                            'g' => !empty($detail->gred) ? $detail->gred : 'N/A',
                        ]  
                    ];
                }

                $studentSubjects[] = [
                    'nama' => $value->pelajar->nama ?? null,
                    'jantina' => $value->pelajar->jantina ?? null,
                    'no_matrik' => $value->pelajar->no_matrik ?? null,
                    'no_ic' => $value->pelajar->no_ic ?? null,
                    'data' => $student_result,
                    'jk' => !empty($value->jam_kredit) ? number_format($value->jam_kredit,2) : '0.00',
                    'jmk' => !empty($value->jumlah_markah) ? number_format($value->jumlah_markah,2) : '0.00',
                    'png' => !empty($value->png) ? number_format($value->png,2) : '0.00',
                    'jkk' => !empty($value->jam_kredit_keseluruhan) ? number_format($value->jam_kredit_keseluruhan,2) : '0.00',
                    'jmkk' => !empty($value->jumlah_markah_keseluruhan) ? number_format($value->jumlah_markah_keseluruhan,2) : '0.00',
                    'pngk' => !empty($value->pngk) ? number_format($value->pngk,2) : '0.00',
                    'kep' => !empty($value->keputusan) ? $value->keputusan : 'N/A',
                    'pgkt' => !empty($value->pangkat) ? $value->pangkat : 'N/A',
                    'jms' => !empty($value->jumlah_markah_semester) ? number_format($value->jumlah_markah_semester,2) : '0.00',
                    'jks' => !empty($value->jam_kredit_semester) ? number_format($value->jam_kredit_semester,2) : '0',
                ];
            }

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_keputusan_penuh', 
                compact('studentSubjects', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at', 'semesterSubjects'))
                ->setPaper('a1', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
                    'dur_subjek' => 'A'
                ];
        }

        return $subject_code;
    }

    public function exportCetakKeputusanGred(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
            'kelas' => 'required'
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
            'kelas.required' => 'Sila pilih kelas',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_keputusan_gred', 
                compact('data', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at'))
                ->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportCetakKedudukanPngk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
            'kelas' => 'required'
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
            'kelas.required' => 'Sila pilih kelas',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->orderBy('pngk', 'desc')->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_kedudukan', 
                compact('data', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at'))
                ->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportCetakKedudukanPng(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_pengajian' => 'required',
            'pusat_pengajian' => 'required',
            'semester_pengajian' => 'required',
            'kelas' => 'required'
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'semester_pengajian.required' => 'Sila pilih semester',
            'kelas.required' => 'Sila pilih kelas',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->first());

            return redirect()->back()->withInput();
        }

        try {
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->orderBy('pngk', 'desc')->get()->take(10);

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_kedudukan', 
                compact('data', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at'))
                ->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportCetakKedudukanKeseluruhan(Request $request)
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
            $data = PelajarSemester::with('pelajarSemesterDetails', 'pelajarSemesterDetails.subjek', 'pelajar', 'pelajar.sesi', 'pelajar.kursus', 'pelajar.syukbah', 'semesterDetail', 'sesi');
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
            if ($request->has('sesi_peperiksaan') && $request->sesi_peperiksaan != null) {
                $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('syukbah') && $request->syukbah != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('syukbah_id', $request->syukbah);
                });
            }
            if ($request->has('jantina') && $request->jantina != null) {
                $data = $data->whereHas('pelajar', function ($data) use ($request) {
                    $data->where('jantina', $request->jantina);
                });
            }
            $data = $data->where('is_gantung', 0)->where('is_deleted', 0);
            $data = $data->orderBy('pngk', 'desc')->get();

            $pusat_pengajian = PusatPengajian::select('nama')->find($request->pusat_pengajian);
            $pusat_pengajian = $pusat_pengajian->nama ?? null;

            $program_pengajian = Kursus::select('nama')->find($request->program_pengjian);
            $program_pengajian = $program_pengajian->nama ?? null;

            $syukbah = Syukbah::select('nama')->find($request->syukbah);
            $syukbah = $syukbah->nama ?? null;

            $semester = '';
            if(!empty($request->semester_pengajian))
            {
                $semester = 'Semester' . $request->semester_pengajian;
            }

            $sesi = '';
            if(!empty($request->sesi_peperiksaan))
            {
                $sesi = SesiPeperiksaan::selct('nama')->find($request->sesi_peperiksaan);
                $sesi = $sesi->nama ?? null;
            }

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'export_kedudukan_keseluruhan', 
                compact('data', 'program_pengajian', 'pusat_pengajian', 'syukbah', 'semester', 'sesi', 'generated_at'))
                ->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
