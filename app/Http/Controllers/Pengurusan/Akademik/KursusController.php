<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\DataTables\Pengurusan\KursusDataTable;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KursusController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.kursus.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Kursus';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Kursus' => false,
            ];

            $buttons = [];
            // $buttons = [
            //     [
            //         'title' => "Tambah Kursus",
            //         'route' => route('pengurusan.akademik.kursus.create'),
            //         'button_class' => "btn btn-sm btn-primary fw-bold",
            //         'icon_class' => "fa fa-plus-circle"
            //     ],
            // ];

            if (request()->ajax()) {
                $data = Kursus::query();
                if ($request->has('kursus') && $request->kursus != null) {
                    $data->where('id', $request->kursus);
                }

                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                                break;
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('bil_subjek', function ($data) {
                        $total_subject = Subjek::where('kursus_id', $data->id)->count();

                        return '<span class="dt-center">'.$total_subject.'</span>';
                    })
                    ->addColumn('created_at', function ($data) {
                        $format_date = Utils::formatDateTime($data->created_at);

                        return $format_date;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.semester.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda Semester">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="'.route('pengurusan.akademik.subjek.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pengurusan Subjek">
                                <i class="fa fa-plus"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['bil_subjek', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'orderable' => false],
                    ['data' => 'bil_subjek', 'name' => 'bil_subjek', 'title' => 'Bilangan Subjek', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('is_deleted', 0)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'courses'));

        } catch (Exception $e) {
            report($e);

            alert('Error', 'Uh oh! Something went Wrong', 'error');

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
        // try {

        //     $title = 'Kursus';
        //     $action = route('pengurusan.akademik.kursus.store');
        //     $page_title = 'Tambah Kursus Baru';
        //     $breadcrumbs = [
        //         "Akademik" =>  false,
        //         "Pengurusan Kursus" =>  false,
        //         "Tambah Kursus" =>  false,
        //     ];

        //     $model = new Kursus();

        //     return view('pages.pengurusan.akademik.kursus.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        // }catch (Exception $e) {
        //     report($e);

        //     alert('Error', 'Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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

    public function table_kursus(KursusDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.akademik.kursus.main');
    }
}
