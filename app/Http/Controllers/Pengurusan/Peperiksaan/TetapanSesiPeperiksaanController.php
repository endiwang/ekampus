<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\SesiPeperiksaan;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanSesiPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.tetapan.sesi_peperiksaan.';

    protected $baseRoute = 'pengurusan.peperiksaan.tetapan.sesi_peperiksaan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Tetapan Sesi Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tetapan' => false,
                'Sesi Peperiksaan' => false,
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
                $data = SesiPeperiksaan::with('kursus');
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                }
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })

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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Sesi', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $program_pengajian = Kursus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons', 'program_pengajian'));

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

            $title = 'Sesi Peperiksaan';
            $action = route($this->baseRoute.'store');
            $page_title = 'Tambah Sesi Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tetapan' => false,
                'Sesi Peperiksaan' => route($this->baseRoute.'index'),
                'Tambah Sesi Peperiksaan' => false,
            ];

            $model = new SesiPeperiksaan();

            $program_pengajian = Kursus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'program_pengajian'));

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
        $validation = $request->validate([
            'nama' => 'required',
            'program_pengajian' => 'required',
        ], [
            'nama.required' => 'Sila masukkan maklumat nama',
            'program_pengajian.required' => 'Sila pilih program pengajian',
        ]);

        try {

            SesiPeperiksaan::create([
                'nama' => $request->nama,
                'kursus_id' => $request->program_pengajian,
            ]);

            Alert::toast('Maklumat sesi peperiksaan berjaya ditambah!', 'success');

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

            $title = 'Sesi Peperiksaan';
            $action = route($this->baseRoute.'update', $id);
            $page_title = 'Kemaskini Sesi Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tetapan' => false,
                'Sesi Peperiksaan' => route($this->baseRoute.'index'),
                'Kemaskini Sesi Peperiksaan' => false,
            ];

            $model = SesiPeperiksaan::find($id);

            $program_pengajian = Kursus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'program_pengajian'));

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
        $validation = $request->validate([
            'nama' => 'required',
            'program_pengajian' => 'required',
        ], [
            'nama.required' => 'Sila masukkan maklumat nama',
            'program_pengajian.required' => 'Sila pilih program pengajian',
        ]);

        try {

            $update = SesiPeperiksaan::find($id);
            $update->nama = $request->nama;
            $update->kursus_id = $request->program_pengajian;
            $update->save();

            Alert::toast('Maklumat sesi peperiksaan berjaya dikemaskini!', 'success');

            return redirect()->route($this->baseRoute.'index');

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

            SesiPeperiksaan::find($id)->delete();

            Alert::toast('Maklumat sesi peperiksaan berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
