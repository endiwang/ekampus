<?php

namespace App\Http\Controllers\Pelajar\eLearning;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\ELearning\ELearningSyllabus;
use App\Models\ELearning\ELearningSyllabusContent;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KandunganPembelajaranController extends Controller
{
    protected $baseView = 'pages.pelajar.e_learning.kandungan_pembelajaran.';
    protected $baseRoute = 'pelajar.e_learning.kandungan_pembelajaran.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Kandungan Pembelajaran';
            $breadcrumbs = [
                'Pelajar' => false,
                'E-Learning' => false,
                'Kandungan Pembelajaran' => false,
            ];

            $student_id = auth()->user()->id;
            $student_kursus = Pelajar::where('user_id', $student_id)->first();
            if (request()->ajax()) {
                $data = ELearningSyllabus::with('kursus', 'subjek', 'createdBy')->where('kursus_id', $student_kursus->kursus_id);
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                }

                return DataTables::of($data)
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute . 'show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Kandungan">
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kandungan', 'orderable' => false],
                    // ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

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
    public function show($id, Builder $builder)
    {
        try {

            $title = 'Kandungan Pembelajarn';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Senarai Kandungan Pembelajaran';
            $breadcrumbs = [
                'Pelajar' => false,
                'E-Learning' => false,
                'Kandungan Pembelajaran' => route($this->baseRoute . 'index'),
                'Senarai Kandungan Pembelajaran' => false
            ];

            $models = ELearningSyllabus::with('kursus')->find($id);

            if (request()->ajax()) {
                $data = ELearningSyllabusContent::where('e_learning_syllabus_id', $id);

                return DataTables::of($data)
                    ->addColumn('type', function ($data) {
                        $type = '';

                        if ($data->type == 'bahan_sokongan') {
                            $type = 'Bahan Sokongan';
                        } elseif ($data->type == 'tugasan') {
                            $type = 'Assignment/Tugasan';
                        }

                        return $type;
                    })
                    ->addColumn('created_at', function ($data) {
                        return Utils::formatDate($data->created_at);
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute .'download', $data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
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
                    ['data' => 'file_name', 'name' => 'file_name', 'title' => 'Nama Fail', 'orderable' => false],
                    ['data' => 'type', 'name' => 'type', 'title' => 'Jenis Kandungan', 'orderable' => false],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Muat Naik', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'show', compact('title', 'action', 'page_title', 'breadcrumbs', 'models' , 'dataTable'));

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

    public function download(Request $request, $id)
    {
        try {
            $download = ELearningSyllabusContent::find($id);

            return response()->file(public_path($download->file_path));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
