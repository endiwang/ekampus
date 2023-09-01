<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Http\Controllers\Controller;
use App\Models\CloPlo;
use App\Models\CloPloMark;
use App\Models\Kelas;
use App\Models\Pelajar;
use App\Models\Syukbah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class DaftarMarkahCloPloController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Daftar Markah CLO & PLO';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Daftar Markah CLO & PLO' => false,
            ];

            if (request()->ajax()) {
                $data = Kelas::with('currentSyukbah', 'currentSemester');
                if ($request->has('nama_kelas') && $request->nama_kelas != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama_kelas.'%');
                }
                if ($request->has('syukbah') && $request->syukbah != null) {
                    $data->where('semasa_syukbah_id', $request->syukbah);
                }

                return DataTables::of($data)
                    ->addColumn('syukbah', function ($data) {
                        return $data->currentSyukbah->nama ?? null;
                    })
                    ->addColumn('semester', function ($data) {
                        return $data->currentSemester->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.student_list', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat CLO PLO">
                                <i class="fa fa-eye"></i>
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kelas', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'syukbah', 'name' => 'syukbah', 'title' => 'Syukbah', 'orderable' => false],
                    ['data' => 'semester', 'name' => 'semester', 'title' => 'Semester Terkini', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $syukbah = Syukbah::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'syukbah'));

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
    public function create(Builder $builder)
    {

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
    public function show($id, $class_id, Builder $builder)
    {
        try {

            $title = 'Daftar Markah CLO & PLO';
            $page_title = 'Maklumat CLO & PLO';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Daftar Markah CLO & PLO' => route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.index'),
                'Maklumat CLO & PLO' => false,
            ];

            if (request()->ajax()) {
                $data = CloPlo::with('clo', 'plo', 'subjek', 'kursus')->where('kelas_id', $class_id);

                return DataTables::of($data)
                    ->addColumn('clo', function ($data) {
                        return $data->clo->name ?? null;
                    })
                    ->addColumn('plo', function ($data) {
                        return $data->plo->name ?? null;
                    })
                    ->addColumn('subjek', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('action', function ($data) use ($class_id, $id) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.update_marks', [$data->id, $class_id, $id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Daftar Markah">
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
                    ['data' => 'clo', 'name' => 'clo', 'title' => 'CLO', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'plo', 'name' => 'plo', 'title' => 'PLO', 'orderable' => false],
                    ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'show', compact('title', 'page_title', 'breadcrumbs', 'dataTable'));

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

    public function studentList($class_id, Builder $builder)
    {
        try {

            $title = 'Daftar Markah CLO & PLO';
            $page_title = 'Senarai Pelajar ';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Daftar Markah CLO & PLO' => route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.index'),
                'Senarai Pelajar' => false,
            ];

            if (request()->ajax()) {
                $data = Pelajar::where('kelas_id', $class_id);

                return DataTables::of($data)
                    ->addColumn('action', function ($data) use ($class_id) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.clo_plo_list', [$data->id, $class_id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Daftar Markah">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                           ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'name', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'name', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'pelajar_list', compact('title', 'page_title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function updateMark($clo_plo_id, $class_id, $student_id)
    {
        try {

            $title = 'Kemaskini Markah CLO & PLO';
            $page_title = 'Kemaskini Markah CLO & PLO';
            $action = route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.store_marks');
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Daftar Markah CLO & PLO' => route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.show', $clo_plo_id),
                'Kemaskini Markah CLO & PLO' => false,
            ];

            $data = CloPlo::with('clo', 'plo', 'subjek', 'kursus', 'kelas', 'pensyarah')->find($clo_plo_id);

            $student = Pelajar::find($student_id);

            $model = CloPloMark::where('pelajar_id', $student_id)->where('clo_plo_id', $clo_plo_id)->first();

            return view($this->baseView.'update_marks', compact('title', 'page_title', 'breadcrumbs', 'action', 'data', 'clo_plo_id', 'class_id', 'student_id', 'student', 'model'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function storeMark(Request $request)
    {
        try {

            CloPloMark::updateOrCreate([
                'pelajar_id' => $request->student_id,
                'clo_plo_id' => $request->clo_plo_id,
                'kursus_id' => $request->kursus_id,
                'semester_terkini_id' => $request->semester_terkini_id,
            ], [
                'clo_marks' => $request->clo,
                'plo_marks' => $request->plo,
            ]);

            Alert::toast('Maklumat rekod markah clo dan plo berjaya dihantar!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.student_list', $request->class_id);

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
