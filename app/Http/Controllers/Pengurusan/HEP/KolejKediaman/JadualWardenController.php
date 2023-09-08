<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Blok;
use App\Models\JadualWarden;
use App\Models\JadualWardenToWarden;
use App\Models\Staff;
use Illuminate\Support\Carbon;

class JadualWardenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.jadual_warden.';

    public function index(Builder $builder)
    {

        $title = 'Jadual Waden';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Jadual Waden' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Jadual Waden',
                'route' => route('pengurusan.kolej_kediaman.jadual_warden.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = JadualWarden::query();

            return DataTables::of($data)
                ->addColumn('bulan', function ($data) {
                    switch ($data->bulan) {
                        case 1:
                            return 'Januari';
                            break;
                        case 2:
                            return 'Februari';
                            break;
                        case 3:
                            return 'Mac';
                            break;
                        case 4:
                            return 'April';
                            break;
                        case 5:
                            return 'May';
                            break;
                        case 6:
                            return 'Jun';
                            break;
                        case 7:
                            return 'Julai';
                            break;
                        case 8:
                            return 'Ogos';
                            break;

                        case 9:
                            return 'September';
                            break;
                        case 10:
                            return 'Oktober';
                            break;
                        case 11:
                            return 'November';
                            break;
                        case 12:
                            return 'Desember';
                            break;
                    }
                })
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
                ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.kolej_kediaman.jadual_warden.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1 pr-1" data-bs-toggle="tooltip" title="Lihat">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="'.route('pengurusan.kolej_kediaman.jadual_warden.pilih_warden', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1 pr-1" data-bs-toggle="tooltip" title="Pilih Warden">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1 pr-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>

                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.jadual_warden.destroy', $data->id).'" method="POST">
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
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false],
                ['data' => 'bulan', 'name' => 'bulan', 'title' => 'Bulan', 'orderable' => false],
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
        $action = route('pengurusan.kolej_kediaman.jadual_warden.store');
        $page_title = 'Tambah Jadual Warden';

        $title = 'Tambah Jadual Warden';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Jadual Warden' => false,
            'Tambah Rekod' => false,
        ];

        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $model = new JadualWarden();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','bulan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'bulan' => 'required',
            'status' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama jadual',
            'bulan.required' => 'Sila pilih bulan',
            'status.required' => 'Sila pilih status',
        ]);

        $data = JadualWarden::create($request->all());

        Alert::toast('Maklumat jadual warden berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.jadual_warden.index');
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
        $action = route('pengurusan.kolej_kediaman.jadual_warden.update',$id);
        $page_title = 'Pinda Jadual Warden';

        $title = 'Pinda Jadual Warden';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Jadual Warden' => false,
            'Pinda Rekod' => false,
        ];

        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $model = JadualWarden::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','bulan'));
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
            'bulan' => 'required',
            'status' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama jadual',
            'bulan.required' => 'Sila pilih bulan',
            'status.required' => 'Sila pilih status',
        ]);

        $data = JadualWarden::find($id);
        $data->nama = $request->nama;
        $data->bulan = $request->bulan;
        $data->status = $request->status;
        $data->save();

        Alert::toast('Maklumat jadual warden berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.jadual_warden.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bilik = JadualWarden::find($id);
        $bilik->delete();
        Alert::toast('Maklumat jadual warden dihapus!', 'success');

        return redirect()->back();
    }

    public function pilih_warden(Builder $builder, $id)
    {
        $action = route('pengurusan.kolej_kediaman.jadual_warden.store_warden',$id);
        $page_title = 'Pilih Warden';

        $title = 'Pilih Warden';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Pilih Warden' => false,
            'Tambah Rekod' => false,
        ];

        if (request()->ajax()) {
            $data = JadualWardenToWarden::where('jadual_warden_id',$id);

            return DataTables::of($data)
                ->addColumn('warden', function ($data) {
                    if ($data->staff) {
                        return $data->staff->nama;
                    }else{
                        return 'N\A';
                    }
                })
                ->addColumn('tarikh', function ($data) {
                    return Carbon::parse($data->tarikh)->format('d/m/Y');

                })
                ->addColumn('action', function ($data) use ($id) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1 pr-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>

                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.jadual_warden.destroy_warden',[$id, $data->id]).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action','tarikh'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'warden', 'name' => 'warden', 'title' => 'Warden', 'orderable' => false],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        // $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $model = new JadualWardenToWarden();

        $warden = Staff::where('is_warden','Y')->pluck('nama','id');

        return view($this->baseView.'pilih_warden', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','warden','dataTable'));
    }

    public function store_warden(Request $request, $id)
    {

        $request->validate([
            'tarikh_jadual' => 'required',
            'staff_id' => 'required',
        ], [
            'tarikh_jadual.required' => 'Sila pilih tarikh',
            'staff_id.required' => 'Sila pilih warden',
        ]);

        $model = new JadualWardenToWarden();
        $model->tarikh = Carbon::createFromFormat('d/m/Y', $request->tarikh_jadual)->format('Y-m-d');
        $model->staff_id = $request->staff_id;
        $model->jadual_warden_id = $id;
        $model->save();

        Alert::toast('Warden berjaya dipilih!', 'success');

        return redirect()->back();

    }

    public function destroy_warden($id,$warden)
    {

        $data = JadualWardenToWarden::find($warden);
        $data->delete();
        Alert::toast('Maklumat pilihan warden dihapus!', 'success');
        return redirect()->back();

    }



}
