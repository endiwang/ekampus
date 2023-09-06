<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PengurusanBlokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.pengurusan_aset.maklumat_blok.';

    public function index(Builder $builder)
    {
        $title = 'Maklumat Blok';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Blok' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Blok',
                'route' => route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = Blok::where('type','A')->where('is_deleted',0)->whereNotNull('jantina')->get();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-success">Boleh Digunakan</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-danger">Tidak Boleh Digunakan</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('jantina', function ($data) {
                    switch ($data->jantina) {
                        case 'L':
                            return '<span class="badge badge-primary">Banin</span>';
                            break;
                        case 'P':
                            return '<span class="badge badge-info">Banat</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['jantina','status', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Blok', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jantina', 'name' => 'jantina', 'title' => 'Jantina', 'orderable' => false, 'class' => 'text-bold'],
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
        $action = route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.store');
        $page_title = 'Tambah Maklumat Blok';

        $title = 'Tambah Maklumat Blok';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Blok' => false,
            'Tambah Blok' => false,
        ];

        $model = new Blok();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jantina' => 'required',
            'status' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama blok',
            'jantina.required' => 'Sila pilih jantina',
            'status.required' => 'Sila pilih status',
        ]);

        $request->request->add(['type' => 'A']);

        $data = Blok::create($request->all());

        Alert::toast('Maklumat blok disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.index');
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
        $action = route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.update',$id);
        $page_title = 'Pinda Maklumat Blok';

        $title = 'Pinda Maklumat Blok';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Blok' => false,
            'Tambah Blok' => false,
        ];

        $model = Blok::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
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
        $request->validate([
            'nama' => 'required',
            'jantina' => 'required',
            'status' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama blok',
            'jantina.required' => 'Sila pilih jantina',
            'status.required' => 'Sila pilih status',
        ]);

        $model = Blok::find($id);


        $model->type = 'A';
        $model->nama = $request->nama;
        $model->jantina = $request->jantina;
        $model->status = $request->status;
        $model->save();


        Alert::toast('Maklumat blok dipinda!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.index');
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
}
