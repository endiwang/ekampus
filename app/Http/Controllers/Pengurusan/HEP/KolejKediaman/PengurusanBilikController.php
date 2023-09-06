<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use App\Models\Bilik;
use App\Models\BilikAsrama;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Blok;

class PengurusanBilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.pengurusan_aset.maklumat_bilik.';

    public function index(Builder $builder)
    {
        $title = 'Maklumat Bilik';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Bilik' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Bilik',
                'route' => route('pengurusan.kolej_kediaman.pengurusan_bilik.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = BilikAsrama::where('is_deleted',0)->with('blok')->with('aras')->get();

            return DataTables::of($data)
                ->addColumn('blok', function ($data) {
                    if($data->blok)
                        {
                            return $data->blok->nama;
                        }
                        else{
                            return 'N\A';
                        }

                })
                ->addColumn('aras', function ($data) {
                    if($data->aras)
                        {
                            return $data->aras->nama;
                        }
                        else{
                            return 'N\A';
                        }

                })
                ->addColumn('jenis_bilik', function ($data) {
                    if($data->jenis_bilik > 1)
                        {
                            return 'Bilik '.$data->jenis_bilik.' Orang';
                        }
                        else{
                            return 'N\A';
                        }

                })
                ->addColumn('status_bilik', function ($data) {
                    switch ($data->status_bilik) {
                        case 0:
                            return '<span class="badge badge-success">Kosong</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-primary">Berpenghuni</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('keadaan_bilik', function ($data) {
                    switch ($data->keadaan_bilik) {
                        case 1:
                            return '<span class="badge badge-success">Baik</span>';
                            break;
                        case 0:
                            return '<span class="badge badge-danger">Tidak Baik</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.kolej_kediaman.pengurusan_bilik.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.pengurusan_bilik.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->rawColumns(['blok','action','jenis_bilik','status_bilik','keadaan_bilik'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_bilik', 'name' => 'no_bilik', 'title' => 'No Bilik', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'blok', 'name' => 'blok', 'title' => 'Blok', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'aras', 'name' => 'aras', 'title' => 'Aras', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jenis_bilik', 'name' => 'jenis_bilik', 'title' => 'Jenis Bilik', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status_bilik', 'name' => 'status_bilik', 'title' => 'Status Bilik', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'keadaan_bilik', 'name' => 'keadaan_bilik', 'title' => 'Keadaan Bilik', 'orderable' => false, 'class' => 'text-bold'],
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
        $action = route('pengurusan.kolej_kediaman.pengurusan_bilik.store');
        $page_title = 'Tambah Maklumat Bilik';

        $title = 'Tambah Maklumat Bilik';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Bilik' => false,
            'Tambah Bilik' => false,
        ];

        $blok = Blok::where('type','A')->where('is_deleted',0)->whereNotNull('jantina')->pluck('nama','id');
        $aras  = Tingkat::where('status',0)->pluck('nama','id');

        $model = new BilikAsrama();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','aras','blok'));
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
            'no_bilik' => 'required',
            'blok_id' => 'required',
            'tingkat_id' => 'required',
            'jenis_bilik' => 'required',
            'status_bilik' => 'required',
            'keadaan_bilik' => 'required',
        ], [
            'nama.required' => 'Sila masukkan no bilik',
            'blok_id.required' => 'Sila pilih blok',
            'tingkat_id.required' => 'Sila pilih aras',
            'status_bilik.required' => 'Sila pilih status bilik',
            'keadaan_bilik.required' => 'Sila pilih keadaan bilik',
            'jenis_bilik.required' => 'Sila masukkan jenis bilik',
        ]);

        $data = BilikAsrama::create($request->all());

        Alert::toast('Maklumat bilik disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.pengurusan_bilik.index');
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
        $action = route('pengurusan.kolej_kediaman.pengurusan_bilik.update',$id);
        $page_title = 'Pinda Maklumat Bilik';

        $title = 'Pinda Maklumat Bilik';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pengurusan Aset' => false,
            'Maklumat Bilik' => false,
            'Pinda Bilik' => false,
        ];

        $blok = Blok::where('type','A')->where('is_deleted',0)->whereNotNull('jantina')->pluck('nama','id');
        $aras  = Tingkat::where('status',0)->pluck('nama','id');

        $model = BilikAsrama::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','aras','blok'));
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
            'no_bilik' => 'required',
            'blok_id' => 'required',
            'tingkat_id' => 'required',
            'jenis_bilik' => 'required',
            'status_bilik' => 'required',
            'keadaan_bilik' => 'required',
        ], [
            'nama.required' => 'Sila masukkan no bilik',
            'blok_id.required' => 'Sila pilih blok',
            'tingkat_id.required' => 'Sila pilih aras',
            'status_bilik.required' => 'Sila pilih status bilik',
            'keadaan_bilik.required' => 'Sila pilih keadaan bilik',
            'jenis_bilik.required' => 'Sila masukkan jenis bilik',
        ]);

        $model = BilikAsrama::find($id);
        $model->no_bilik = $request->no_bilik;
        $model->blok_id = $request->blok_id;
        $model->tingkat_id = $request->tingkat_id;
        $model->jenis_bilik = $request->jenis_bilik;
        $model->status_bilik = $request->status_bilik;
        $model->keadaan_bilik = $request->keadaan_bilik;
        $model->save();

        Alert::toast('Maklumat bilik disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.pengurusan_bilik.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bilik = BilikAsrama::find($id);

        $bilik->is_deleted = 1;
        $bilik->save();

        Alert::toast('Maklumat bilik berjaya dihapus!', 'success');

        return redirect()->back();
    }
}
