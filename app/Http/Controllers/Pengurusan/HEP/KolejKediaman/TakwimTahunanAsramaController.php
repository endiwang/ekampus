<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Blok;
use App\Models\TakwimTahunanAsrama;

class TakwimTahunanAsramaController extends Controller
{

    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.takwim_tahunan.';

    public function index(Builder $builder)
    {

        $title = 'Takwim Tahunan';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Takwim Tahunan' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Takwim Tahunan',
                'route' => route('pengurusan.kolej_kediaman.takwim_tahunan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = TakwimTahunanAsrama::query();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Tidak Aktif</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Aktif</span>';
                            break;
                    }
                })
                ->addColumn('blok', function ($data) {
                    if($data->blok)
                    {
                        return $data->blok->nama;
                    }else{
                        return 'N\A';
                    }
                })
                ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.kolej_kediaman.takwim_tahunan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                                <i class="fa fa-pencil"></i>
                            </a><a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1 ml-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.takwim_tahunan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'tarikh_permohonan','nama_pelajar','no_ic'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'tahun_pengajian', 'name' => 'tahun_pengajian', 'title' => 'Tahun Pengajian', 'orderable' => false],
                ['data' => 'blok', 'name' => 'blok', 'title' => 'Blok', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('pengurusan.kolej_kediaman.takwim_tahunan.store');
        $page_title = 'Tambah Takwim Tahunan';

        $title = 'Tambah Takwim Tahunan';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Takwim Tahunan' => false,
            'Tambah Rekod' => false,
        ];

        $blok = Blok::where('type','A')->where('is_deleted',0)->whereNotNull('jantina')->pluck('nama','id');

        $model = new TakwimTahunanAsrama();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','blok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_pengajian' => 'required',
            'blok_id' => 'required',
            'dokument_upload' => 'required',
            'status' => 'required',
        ], [
            'tahun_pengajian.required' => 'Sila masukkan tahun pengajian',
            'blok_id.required' => 'Sila pilih blok',
            'dokument_upload.required' => 'Sila muat naik dokument takwim tahunan',
            'status.required' => 'Sila pilih status',
        ]);


        if ($request->has('dokument_upload')) {
            $dokument = uniqid().'.'.$request->dokument_upload->getClientOriginalExtension();
            $dokument_path = 'uploads/kolej_kediaman/takwim_tahunan';
            $file_dokument = $request->file('dokument_upload')->storeAs($dokument_path, $dokument, 'public');
            $request->request->add(['dokument' => $file_dokument]);
        }

        $data = TakwimTahunanAsrama::create($request->all());

        Alert::toast('Maklumat takwim tahunan asrama berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.takwim_tahunan.index');
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
        $action = route('pengurusan.kolej_kediaman.takwim_tahunan.update',$id);
        $page_title = 'Pinda Takwim Tahunan';

        $title = 'Pinda Takwim Tahunan';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Takwim Tahunan' => false,
            'Pinda Takwim' => false,
        ];

        $blok = Blok::where('type','A')->where('is_deleted',0)->whereNotNull('jantina')->pluck('nama','id');

        $model = TakwimTahunanAsrama::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','blok'));
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
            'tahun_pengajian' => 'required',
            'blok_id' => 'required',
            'dokument_upload' => 'required',
            'status' => 'required',
        ], [
            'tahun_pengajian.required' => 'Sila masukkan tahun pengajian',
            'blok_id.required' => 'Sila pilih blok',
            'dokument_upload.required' => 'Sila muat naik dokument takwim tahunan',
            'status.required' => 'Sila pilih status',
        ]);

        $data = TakwimTahunanAsrama::find($id);
        $data->tahun_pengajian = $request->tahun_pengajian;
        $data->blok_id = $request->blok_id;
        $data->status = $request->status;


        if ($request->has('dokument_upload')) {
            $dokument = uniqid().'.'.$request->dokument_upload->getClientOriginalExtension();
            $dokument_path = 'uploads/kolej_kediaman/takwim_tahunan';
            $file_dokument = $request->file('dokument_upload')->storeAs($dokument_path, $dokument, 'public');
            $data->dokument = $file_dokument;
        }

        $data->save();

        Alert::toast('Maklumat takwim tahunan asrama berjaya dipinda!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.takwim_tahunan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bilik = TakwimTahunanAsrama::find($id);
        $bilik->delete();
        Alert::toast('Maklumat bilik berjaya dihapus!', 'success');

        return redirect()->back();
    }
}
