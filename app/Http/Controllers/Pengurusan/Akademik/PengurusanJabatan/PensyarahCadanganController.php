<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\PensyarahCadangan;
use App\Models\Semester;
use App\Models\Sesi;
use App\Models\Staff;
use App\Models\Subjek;
use Carbon\Carbon;
use Exception;
use Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PensyarahCadanganController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.';
    protected $baseRoute = 'pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Pensyarah Cadangan';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pensyarah Cadangan' => false,
            ];

            $modals = [
                [
                    'title' => 'Muat Turun Cadangan Pensyarah',
                    'id' => '#downloadPensyarahCadangan',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = Subjek::with('kursus');
                if ($request->has('kursus') && $request->kursus != null) {
                    $data->where('kursus_id', $request->kursus);
                }
                if ($request->has('subjek') && $request->subjek != null) {
                    $data->where('nama', 'LIKE', '%' . $request->subjek . '%');
                }
                if ($request->has('kod_subjek') && $request->kod_subjek != null) {
                    $data->where('kod_subjek', 'LIKE', '%' . $request->kod_subjek . '%');
                }

                return DataTables::of($data)
                    ->addColumn('kursus', function($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tambah Pensyarah">
                                <i class="fa fa-pencil-alt"></i>
                                </a>
                                ';
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
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable' => false],
                    ['data' => 'kredit', 'name' => 'kredit', 'title' => 'Jam Kredit', 'orderable'=> false, 'class'=>'text-bold'],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Program Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('is_deleted', 0)->get()->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'modals', 'dataTable', 'courses', 'semesters', 'sessions'));

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
        $validator = Validator::make($request->all(), [
            'semester' => 'required|integer',
            'kelas' => 'nullable',
            'staff' => 'required|integer',
        ], [
            'semester.required' => 'Sila pilih semester',
            'staff.required' => 'Sila pilih pensyarah',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->all());

            return redirect()->back()->withInput();
        }

        try {
            $kursus = Subjek::select('kursus_id')->find($request->subjek_id);
            
            $data = new PensyarahCadangan();
            $data->kursus_id    = $kursus->kursus_id;
            $data->subjek_id    = $request->subjek_id;
            $data->kelas_id     = $request->kelas;
            $data->semester_id  = $request->semester;
            $data->staff_id      = $request->staff;
            $data->sesi_id      = $request->sesi;
            $data->save();

            Alert::toast('Maklumat pensyarah cadangan berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.show', $request->subjek_id);

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
    public function show($id, Request $request, Builder $builder)
    {
        try {

            $title = 'Maklumat Pensyarah Cadangan';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan' => false,
                'Pensyarah Cadangan' => route('pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.index'),
                'Maklumat Pensyarah Cadangan' => false,
            ];

            $modals = [
                [
                    'title' => 'Tambah Pensyarah Cadangan',
                    'id' => '#addPensyarahCadangan',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
    
            if (request()->ajax()) {
                $data = PensyarahCadangan::with('semester', 'kelas', 'staff', 'subjek', 'kursus', 'sesi')->where('subjek_id', $id);
                if ($request->has('filter_semester') && $request->filter_semester != null) {
                    $data->where('semester_id', $request->filter_semester);
                }
                if ($request->has('filter_class') && $request->filter_class != null) {
                    $data->where('kelas_id', $request->filter_class);
                }
                if ($request->has('filter_sesi') && $request->filter_sesi != null) {
                    $data->where('sesi_id', $request->filter_sesi);
                }
    
                return DataTables::of($data)
                    ->addColumn('semester_id', function ($data) {
                        return $data->semester->nama ?? null;
                    })
                    ->addColumn('kelas_id', function ($data) {
                        return $data->kelas->nama ?? null;
                    })
                    ->addColumn('staff_id', function ($data) {
                        return $data->staff->nama ?? null;
                    })
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '
                                <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.pensyarah_cadangan.destroy', $data->id).'" method="POST">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }
    
            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable' => false],
                    ['data' => 'semester_id', 'name' => 'semester_id', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'staff_id', 'name' => 'staff_id', 'title' => 'Pensyarah', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
    
                ])
                ->minifiedAjax();

            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', NULL)->pluck('nama', 'id');
            $staffs = Staff::where('deleted_at', NULL)->pluck('nama', 'id');
            $sessions = Sesi::where('deleted_at', NULL)->pluck('nama', 'id');
    
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'id', 'semesters', 'classes', 'modals', 'staffs', 'sessions'));
    
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
        try {

            PensyarahCadangan::find($id)->delete();

            Alert::toast('Maklumat pensyarah cadangan berjaya dihapuskan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download(Request $request)
    {
        try {
            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $datas = PensyarahCadangan::with('kelas', 'staff', 'subjek', 'semester');
            if (! empty($request->download_kursus)) {
                $datas = $datas->where('kursus_id', $request->download_kursus);
            }
            if (! empty($request->download_semester)) {
                $datas = $datas->where('semester_id', $request->download_semester);
            }
            if (! empty($request->download_sesi)) {
                $datas = $datas->where('sesi_id', $request->download_sesi);
            }
            $datas = $datas->get();

            $extracted_datas = [];
            foreach($datas as $data)
            {
                $extracted_datas[$data->subjek_id][] = [
                    'subjek' => $data->subjek->nama,
                    'jam_kredit' => $data->subjek->kredit,
                    'kelas' => $data->kelas->nama ?? null,
                    'pensyarah' => $data->staff->nama ?? null,
                    'semester' => $data->semester->nama ?? null
                ];
            }

            $program_pengajian = Kursus::select('nama')->find($request->download_kursus);
            $sesi = Sesi::select('nama')->find($request->download_sesi);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.download_pdf', compact('generated_at', 'extracted_datas', 'program_pengajian', 'sesi'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
