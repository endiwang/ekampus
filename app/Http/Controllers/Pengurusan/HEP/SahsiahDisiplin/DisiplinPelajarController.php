<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\DisiplinPelajar;
use App\Models\HukumanDisiplin;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class DisiplinPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.pengurusan.disiplin_pelajar.';

    public function index(Builder $builder)
    {

        $title = 'Disiplin Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Disiplin Pelajar' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Rekod Disiplin Pelajar',
                'route' => route('pengurusan.hep.pengurusan.disiplin_pelajar.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = DisiplinPelajar::query();

            return DataTables::of($data)
                ->addColumn('nama_pelaku', function ($data) {
                    return $data->pelaku->nama;
                })
                ->addColumn('no_ic_matrik', function ($data) {
                    if (! empty($data->pelaku)) {
                        $data = '<p style="text-align:center">'.$data->pelaku->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->pelaku->no_matrik.'] </span></p>';
                    } else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status_hukuman) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Berjalan</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-info">Sedang Berjalan</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-success">Selesai</span>';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.hep.pengurusan.disiplin_pelajar.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.disiplin_pelajar.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'no_ic_matrik'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pelaku', 'name' => 'nama_pelaku', 'title' => 'Nama Pelaku', 'orderable' => false],
                ['data' => 'no_ic_matrik', 'name' => 'no_ic_matrik', 'title' => 'No MyKad/Passport [No Matrik]', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Hukuman', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Disiplin Pelajar';
        $action = route('pengurusan.hep.pengurusan.disiplin_pelajar.store');
        $page_title = 'Tambah Rekod Disiplin Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Disiplin Pelajar' => false,
            'Tambah Rekod' => false,
        ];

        $model = new DisiplinPelajar();

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic_no_matrik', 'id');
        $hukuman = HukumanDisiplin::where('status', 0)->get()->pluck('hukuman', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar', 'hukuman'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelajar_id' => 'required',
            'keterangan' => 'required',
            'hukuman_disiplin_id' => 'required',
        ], [
            'pelajar_id.required' => 'Sila pilih pelajar',
            'keterangan.required' => 'Sila masukkan keterangan',
            'hukuman_disiplin_id.required' => 'Sila pilih hukuman',
        ]);

        $data = DisiplinPelajar::create($request->all());

        Alert::toast('Maklumat disiplin pelajar berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.disiplin_pelajar.index');
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
        $action = route('pengurusan.hep.pengurusan.disiplin_pelajar.update', $id);
        $title = 'Disiplin Pelajar';
        $page_title = 'Tambah Rekod Disiplin Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Disiplin Pelajar' => false,
            'Tambah Rekod' => false,
        ];

        $model = DisiplinPelajar::find($id);

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic_no_matrik', 'id');

        $hukuman = HukumanDisiplin::where('status', 0)->get()->pluck('hukuman', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar', 'hukuman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required',
            'hukuman_disiplin_id' => 'required',
        ], [
            'keterangan.required' => 'Sila masukkan keterangan',
            'hukuman_disiplin_id.required' => 'Sila pilih hukuman',
        ]);

        $model = DisiplinPelajar::find($id);
        $model->pelajar_id = $request->pelajar_id;
        $model->keterangan = $request->keterangan;
        $model->hukuman_disiplin_id = $request->hukuman_disiplin_id;
        $model->save();

        Alert::toast('Maklumat disiplin pelajar berjaya dikemaskini!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.disiplin_pelajar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = DisiplinPelajar::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat disiplin pelajar berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
