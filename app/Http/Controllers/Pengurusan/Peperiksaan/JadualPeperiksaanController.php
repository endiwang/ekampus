<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Constants\Generic;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Libraries\BilLibrary;
use App\Models\Bilik;
use App\Models\CajPeperiksaan;
use App\Models\JadualPeperiksaan;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PelajarSemester;
use App\Models\PelajarSemesterDetail;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\SesiPeperiksaan;
use App\Models\Subjek;
use App\Models\Syukbah;
use App\Models\TetapanPeperiksaan;
use App\Models\Yuran;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use DB;

class JadualPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.jadual_peperiksaan.';
    protected $baseRoute = 'pengurusan.peperiksaan.jadual_peperiksaan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Penetapan Jadual Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Jadual Peperiksaan' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah',
                    'route' => route($this->baseRoute.'create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = TetapanPeperiksaan::with('sesi', 'pusat_pengajian', 'kursus', 'syukbah', 'semester');
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%'. $request->nama  . '%');
                }
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('pusat_pengajian', function ($data) {
                        return $data->pusat_pengajian->nama ?? null;
                    })
                    ->addColumn('sesi_peperiksaan', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('semester_id', function ($data) {
                        return $data->semester->nama ?? null;
                    })
                    ->addColumn('syukbah_id', function ($data) {
                        return $data->syukbah->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-'.$data->id.'" action="'.route($this->baseRoute.'destroy', $data->id).'" method="POST">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
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
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'pusat_pengajian', 'name' => 'pusat_pengajian', 'title' => 'Pusat Pengajian', 'orderable' => false],
                    ['data' => 'sesi_peperiksaan', 'name' => 'sesi_peperiksaan', 'title' => 'Sesi Peperiksaan', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'semester_id', 'name' => 'semester_id', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'syukbah_id', 'name' => 'syukbah_id', 'title' => 'Syukbah', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $syukbah = Syukbah::where('deleted_at', NULL)->pluck('nama', 'id');
            $sesi_peperiksaan = SesiPeperiksaan::pluck('nama', 'id');
            $pusat_pengajian = PusatPengajian::where('deleted_at', NULL)->pluck('nama', 'id');
            $program_pengajian = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');
            $semester = Semester::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact(
                'title', 
                'breadcrumbs', 
                'dataTable', 
                'buttons', 
                'program_pengajian',
                'sesi_peperiksaan',
                'pusat_pengajian',
                'semester',
                'syukbah'
            ));

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

            $title = 'Jadual Peperiksaan';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Tambah Jadual Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Jadual Peperiksaan' => route($this->baseRoute . 'index'),
                'Tambah Jadual Peperiksaan' => false,
            ];

            $model = new TetapanPeperiksaan();

            $syukbah = Syukbah::where('deleted_at', NULL)->pluck('nama', 'id');
            $sesi_peperiksaan = SesiPeperiksaan::pluck('nama', 'id');
            $pusat_pengajian = PusatPengajian::where('deleted_at', NULL)->pluck('nama', 'id');
            $program_pengajian = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');
            $semester = Semester::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'create', compact('model', 
                'title', 
                'breadcrumbs', 
                'page_title', 
                'action', 
                'program_pengajian',
                'sesi_peperiksaan',
                'pusat_pengajian',
                'semester',
                'syukbah'
            ));

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
        $validation = $request->validate([
            'pusat_pengajian' => 'required',
            'program_pengajian' => 'required',
            'sesi' => 'required',
            'semester' => 'required',
            'syukbah' => 'required',
        ], [
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'sesi.required' => 'Sila pilih sesi',
            'semester.required' => 'Sila pilih psemester',
            'syukbah.required' => 'Sila pilih syukbah',
        ]);

        try {

            $tetapan = TetapanPeperiksaan::create([
                'pusat_pengajian_id' => $request->pusat_pengajian,
                'kursus_id' => $request->program_pengajian,
                'sesi_id' => $request->sesi,
                'semester_id' => $request->semester,
                'syukbah_id' => $request->syukbah
            ]);

            Alert::toast('Maklumat sesi peperiksaan berjaya ditambah!', 'success');

            return redirect()->route($this->baseRoute . 'edit', $tetapan->id);

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
    public function edit($id, Builder $builder)
    {
        // try {
            $tetapan_peperiksaan = TetapanPeperiksaan::find($id);
            $timetable = JadualPeperiksaan::select('id')->where('tetapan_peperiksaan_id', $id)->first();

            $title = 'Jadual Peperiksaan';
            $action = route($this->baseRoute . 'update', $id);
            $page_title = 'Tambah Subjek Jadual Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Jadual Peperiksaan' => route($this->baseRoute . 'index'),
                'Tambah Subjek Jadual Peperiksaan' => false,
            ];

            if (request()->ajax()) {
                if (! empty($timetable->id)) {
                    $data = JadualPeperiksaan::with('subjek', 'lokasi')->where('tetapan_peperiksaan_id', $id);
                } else {
                    $data = [];
                }

                return DataTables::of($data)
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        return Utils::formatDate($data->tarikh) ?? null;
                    })
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime2($data->masa).' - '.Utils::formatTime2($data->masa_akhir);
                    })
                    ->addColumn('lokasi', function ($data) {
                        return $data->lokasi ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.jadual.jadual_kelas.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('tarikh', 'asc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'subjek_id', 'name' => 'file_name', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Peperiksaan', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'bilangan_calon', 'name' => 'bilangan_calon', 'title' => 'Bilangan Calon', 'orderable' => false],
                    ['data' => 'lokasi', 'name' => 'created_at', 'title' => 'Lokasi', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ])
                ->minifiedAjax();

            $syukbah = Syukbah::where('deleted_at', NULL)->pluck('nama', 'id');
            $sesi_peperiksaan = SesiPeperiksaan::pluck('nama', 'id');
            $pusat_pengajian = PusatPengajian::where('deleted_at', NULL)->pluck('nama', 'id');
            $program_pengajian = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');
            $semester = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');
            $locations = Bilik::where('is_deleted', 0)->get()->pluck('nama_bilik', 'id');

            return view($this->baseView.'create_subject', compact(
                'title',
                'breadcrumbs',
                'dataTable',
                'page_title',
                'action',
                'tetapan_peperiksaan',
                'subjects',
                'locations',
                'timetable',
                'id',
                'program_pengajian',
                'sesi_peperiksaan',
                'pusat_pengajian',
                'semester',
                'syukbah'
            ));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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

            $update = TetapanPeperiksaan::find($id);
            $update->pusat_pengajian_id = $request->pusat_pengajian;
            $update->kursus_id = $request->program_pengajian;
            $update->sesi_id = $request->sesi;
            $update->semester_id = $request->semester;
            $update->syukbah_id = $request->syukbah;
            $update->save();
            
            Alert::toast('Maklumat utama jadual peperiksaan berjaya dikemaskini!', 'success');

            return redirect()->back();

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
            TetapanPeperiksaan::find($id)->delete();
            JadualPeperiksaan::where('tetapan_peperiksaan_id', $id)->delete();

            Alert::toast('Maklumat jadual peperiksaan berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function addSubject(Request $request, $id)
    {
        $validation = $request->validate([
            'subjek' => 'required',
            'tarikh' => 'required',
            'masa_mula' => 'required',
            'masa_tamat' => 'required',
            'lokasi' => 'required',
        ], [
            'subjek.required' => 'Sila pilih subjek',
            'tarikh.required' => 'Sila pilih tarikh',
            'masa_mula.required' => 'Sila pilih masa mula',
            'masa_tamat.required' => 'Sila pilih masa akhir',
            'lokasi.required' => 'Sila pilih lokasi',
        ]);

        try {
            $lokasi = Bilik::select('nama_bilik')->find($request->lokasi);

            $tetapan = JadualPeperiksaan::create([
                'tetapan_peperiksaan_id' => $id,
                'subjek_id' => $request->subjek,
                'tarikh' => Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d'),
                'masa' => $request->masa_mula,
                'masa_akhir' => $request->masa_tamat,
                'bilangan_calon' => $request->bil_calon,
                'lokasi' => $lokasi->nama_bilik,
            ]);

            Alert::toast('Maklumat subjek berjaya ditambah!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function destroySubject($id)
    {
        try {

            JadualPeperiksaan::find($id)->delete();

            Alert::toast('Maklumat subjek berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadJadualPeperiksaan($id)
    {
        // try {
            $detail = TetapanPeperiksaan::with('sesi', 'pusat_pengajian', 'kursus', 'syukbah', 'semester')->find($id);
            $jadual_peperiksaan = JadualPeperiksaan::with('subjek', 'lokasi')->where('tetapan_peperiksaan_id', $id)->get();

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.jadual_pdf', compact('detail', 'jadual_peperiksaan', 'generated_at'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    public function janaBil(Request $request, $id)
    {

        $result = true;
        try
        { 
            DB::transaction(function () use($request, $id) {

                $tetapan_peperiksaan = TetapanPeperiksaan::find($id);
                if(!empty($tetapan_peperiksaan->pusat_pengajian_id) && !empty($tetapan_peperiksaan->kursus_id) && !empty($tetapan_peperiksaan->semester_id) && !empty($tetapan_peperiksaan->syukbah_id))
                {
                    $pelajar_senarai = Pelajar::join('pelajar_semesters', function($join){
                        $join->on('pelajar_semesters.pelajar_id', 'pelajar.pelajar_id_old');
                        $join->on('pelajar_semesters.semester', 'pelajar.semester');
                        $join->where(function($where){
                            $where->whereNull('is_peperiksaan_bil_generated');
                            $where->orWhere('is_peperiksaan_bil_generated', 0);
                        });
                    })
                    ->where('pelajar.pusat_pengajian_id', $tetapan_peperiksaan->pusat_pengajian_id)
                    ->where('pelajar.kursus_id', $tetapan_peperiksaan->kursus_id)
                    ->where('pelajar.semester', $tetapan_peperiksaan->semester_id)
                    ->where('pelajar.syukbah_id', $tetapan_peperiksaan->syukbah_id)
                    ->get([
                        'pelajar.id as pelajar_id',
                        'pelajar_semesters.id as pelajar_semester_id',
                    ]);
                    
                    $caj_peperiksaan_senarai = CajPeperiksaan::where('jenis', 'peperiksaan')->get();
        
                    foreach($pelajar_senarai as $pelajar)
                    {
                        $data['yuran'] = Yuran::find(Generic::YURAN_PEPERIKSAAN);
                        $data['pelajar'] = $pelajar;
                        $data['pelajar_semester_detail'] = PelajarSemesterDetail::where('pelajar_semester_id', $pelajar->pelajar_semester_id)->get();
                        $data['caj_peperiksaan_pengurusan'] = $caj_peperiksaan_senarai->whereNull('subjek_id');
                        $data['caj_peperiksaan_subjek'] = $caj_peperiksaan_senarai->whereIn('subjek_id', $data['pelajar_semester_detail']->pluck('subjek_id', 'subjek_id')->toArray());
                        BilLibrary::createBilPeperiksaan($data);

                        $pelajar_semester = PelajarSemester::where('id', $pelajar->pelajar_semester_id)->first();
                        $pelajar_semester->is_peperiksaan_bil_generated = 1;
                        $pelajar_semester->save();
                    }
                }


            });

        }
        catch (\Exception $e)
        {
            $result = false;
        }

        if($result)
        {
            Alert::toast('Janaan bil berjaya dikemaskini', 'success');
            return redirect(route($this->baseRoute . 'edit', $id));
        }
        else {
            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');
            return redirect()->back();
        }
    }
}
