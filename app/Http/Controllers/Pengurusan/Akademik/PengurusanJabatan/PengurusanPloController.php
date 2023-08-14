<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Plo;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PengurusanPloController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.plo.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Pengurusan PLO';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pengurusan PLO' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah PLO',
                    'route' => route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = Plo::with('subjek', 'kursus');
                if ($request->has('tajuk') && $request->tajuk != null) {
                    $data->where('name', 'LIKE', '%'.$request->tajuk.'%');
                }
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('program_pengajian_id', $request->program_pengajian);
                }

                return DataTables::of($data)
                // ->addColumn('subjek', function($data) {
                //    return $data->subjek->nama ?? null;
                // })
                // ->addColumn('kursus', function($data) {
                //     return $data->kursus->nama ?? null;
                // })
                    ->addColumn('created_at', function ($data) {
                        return Utils::formatDate($data->created_at) ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
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
                    ['data' => 'name', 'name' => 'name', 'title' => 'Tajuk', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'description', 'name' => 'description', 'title' => 'Keterangan', 'orderable' => false],
                    //['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable'=> false, 'class'=>'text-bold'],
                    //['data' => 'kursus', 'name' => 'kursus', 'title' => 'Program Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Rekod Dicipta', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'courses'));

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

            $title = 'Tambah Rekod PLO';
            $action = route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.store');
            $page_title = 'Maklumat PLO';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pengurusan PLO' => route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index'),
                'Tambah Rekod PLO' => false,
            ];

            $model = new Plo();

            $courses = Kursus::where('deleted_at', null)->get()->pluck('nama', 'id');

            $subjects = Subjek::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'courses', 'subjects'));

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
        $validator = Validator::make($request->all(), [
            // 'program_pengajian'     => 'required',
            // 'subjek'                => 'required|string',
            'tajuk' => 'required|string',
            'keterangan' => 'required|string',
            'status' => 'required|integer',
        ], [
            // 'program_pengajian.required'    => 'Sila pilih program pengajian',
            // 'subjek.required'               => 'Sila pilih subjek',
            'tajuk.required' => 'Sila masukkan maklumat tajuk',
            'keterangan.required' => 'Sila masukkan maklumat keterangan',
            'status.required' => 'Sila pilih status',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->all());

            return redirect()->back()->withInput();
        }

        try {
            $rekod = new Plo();
            $rekod->name = $request->tajuk;
            $rekod->description = $request->keterangan;
            //$rekod->program_pengajian_id    = $request->program_pengajian;
            //$rekod->subjek_id               = $request->subjek;
            $rekod->status = $request->status;
            $rekod->created_by = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat rekod plo berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index');

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

            $title = 'Pinda Rekod PLO';
            $action = route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.update', $id);
            $page_title = 'Maklumat CLO';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pengurusan PLO' => route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index'),
                'Pinda Rekod PLO' => false,
            ];

            $model = Plo::find($id);

            $courses = Kursus::where('deleted_at', null)->get()->pluck('nama', 'id');

            $subjects = Subjek::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'courses', 'subjects'));

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
        $validator = Validator::make($request->all(), [
            // 'program_pengajian'     => 'required',
            // 'subjek'                => 'required|string',
            'tajuk' => 'required|string',
            'keterangan' => 'required|string',
            'status' => 'required|integer',
        ], [
            // 'program_pengajian.required'    => 'Sila pilih program pengajian',
            // 'subjek.required'               => 'Sila pilih subjek',
            'tajuk.required' => 'Sila masukkan maklumat tajuk',
            'keterangan.required' => 'Sila masukkan maklumat keterangan',
            'status.required' => 'Sila pilih status',
        ]);

        if ($validator->fails()) {
            alert('error', $validator->messages()->all());

            return redirect()->back()->withInput();
        }

        try {
            $rekod = Plo::find($id);
            $rekod->name = $request->tajuk;
            $rekod->description = $request->keterangan;
            //$rekod->program_pengajian_id    = $request->program_pengajian;
            //$rekod->subjek_id               = $request->subjek;
            $rekod->status = $request->status;
            $rekod->created_by = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat rekod plo berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index');

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

            Plo::find($id)->delete();

            Alert::toast('Maklumat rekod PLO berjaya dihapuskan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
