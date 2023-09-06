<?php

namespace App\Http\Controllers\Pengurusan\Akademik\eLearning;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\ELearning\ELearningSyllabus;
use App\Models\ELearning\ELearningTimetable;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Semester;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class JadualPembelajaranController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.e_learning.jadual_pembelajaran.';

    protected $baseRoute = 'pengurusan.akademik.e_learning.jadual_pembelajaran.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Penetapan Jadual Pembelajaran';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => false,
                'Penetapan Jadual Pembelajaran' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah',
                    'route' => route($this->baseRoute.'create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $lecturers = Staff::where('deleted_at', null)->pluck('nama', 'id');

            if (request()->ajax()) {
                $data = ELearningTimetable::with('kursus', 'kandungan', 'semester', 'staff')->where('status', 1);
                if ($request->has('kursus') && $request->kursus != null) {
                    $data = $data->whereHas('kursus', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->kursus.'%');
                    });
                }
                if ($request->has('nama_kandungan') && $request->nama_kandungan != null) {
                    $data = $data->whereHas('kandungan', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama_kandungan.'%');
                    });
                }
                if ($request->has('semester') && $request->semester != null) {
                    $data->where('semester_id', $request->semester);
                }
                if ($request->has('pensyarah') && $request->pensyarah != null) {
                    $data->where('staff_id', $request->pensyarah);
                }

                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        return $data->kandungan->nama ?? null;
                    })
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('semester', function ($data) {
                        return $data->semester->nama ?? null;
                    })
                    ->addColumn('kandungan', function ($data) {
                        return $data->kandungan->nama ?? null;
                    })
                    ->addColumn('staff_id', function ($data) {
                        return $data->staff->nama ?? null;
                    })
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime2($data->masa_mula).' - '.Utils::formatTime2($data->masa_akhir);
                    })
                    ->addColumn('status', function ($data) {
                        if ($data->status == 0) {
                            return 'Aktif';
                        } elseif ($data->status == 1) {
                            return 'Tidak Aktif';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
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
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kandungan', 'orderable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'semester', 'name' => 'semester', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'staff_id', 'name' => 'staff_id', 'title' => 'Pensyarah', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons', 'semesters', 'lecturers'));

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

            $title = 'Jadual Pembelajaran';
            $action = route($this->baseRoute.'store');
            $page_title = 'Tambah Jadual Pembelajaran';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => route($this->baseRoute.'index'),
                'Tambah Jadual Pembelajaran' => false,
            ];

            $model = new ELearningTimetable();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $lecturers = Staff::where('deleted_at', null)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');
            $kandungan = ELearningSyllabus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('title', 'action', 'page_title', 'breadcrumbs', 'model', 'courses', 'semesters', 'lecturers', 'classes', 'kandungan'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = new ELearningTimetable();
            $data->kursus_id = $request->kursus;
            $data->syllabus_id = $request->kandungan;
            $data->semester_id = $request->semester;
            $data->kelas_id = $request->kelas;
            $data->staff_id = $request->pensyarah;
            $data->masa_mula = $request->masa_mula;
            $data->masa_akhir = $request->masa_tamat;
            $data->status = $request->status;
            $data->save();

            Alert::toast('Jadual Pembelajaran berjaya ditambah!', 'success');

            return redirect()->route($this->baseRoute.'index');

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
    public function edit($id)
    {
        try {

            $title = 'Jadual Pembelajaran';
            $action = route($this->baseRoute.'update', $id);
            $page_title = 'Kemaskini Jadual Pembelajaran';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => route($this->baseRoute.'index'),
                'Kemaskini Jadual Pembelajaran' => false,
            ];

            $model = ELearningTimetable::findOrFail($id);

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $lecturers = Staff::where('deleted_at', null)->pluck('nama', 'id');
            $classes = Kelas::where('deleted_at', null)->pluck('nama', 'id');
            $kandungan = ELearningSyllabus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('title', 'action', 'page_title', 'breadcrumbs', 'model', 'courses', 'semesters', 'lecturers', 'classes', 'kandungan'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = ELearningTimetable::findOrFail($id);
            $data->kursus_id = $request->kursus;
            $data->syllabus_id = $request->kandungan;
            $data->semester_id = $request->semester;
            $data->kelas_id = $request->kelas;
            $data->staff_id = $request->pensyarah;
            $data->masa_mula = $request->masa_mula;
            $data->masa_akhir = $request->masa_tamat;
            $data->status = $request->status;
            $data->save();

            Alert::toast('Jadual Pembelajaran berjaya dikemaskini!', 'success');

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
            ELearningTimetable::find($id)->delete();

            Alert::toast('Maklumat jadual pembelajaran berjaya dihapuskan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function fetchContent(Request $request)
    {
        $kandungan = ELearningSyllabus::select('id', 'nama as text')->where('kursus_id', $request->kursus_id)->where('is_deleted', 0)->get();

        return $kandungan;
    }
}
