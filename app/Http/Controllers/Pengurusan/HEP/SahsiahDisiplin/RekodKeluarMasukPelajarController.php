<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KeluarMasuk;
use App\Models\Pelajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodKeluarMasukPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.hep.pengurusan.keluar_masuk.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Rekod Keluar Masuk';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Rekod Keluar Masuk' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Rekod',
                'route' => route('pengurusan.hep.pengurusan.keluar_masuk.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = KeluarMasuk::query();

            return DataTables::of($data)
                ->addColumn('nama_pelajar', function ($data) {
                    if (! empty($data->pelajar)) {
                        $data = $data->pelajar->nama;
                    } else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('no_ic', function ($data) {
                    if (! empty($data->pelajar)) {
                        $data = '<p style="text-align:center">'.$data->pelajar->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->pelajar->no_matrik.'] </span></p>';
                    } else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('tarikh_masuk', function ($data) {
                    return ! empty($data->tarikh_masuk) ? Utils::formatDate($data->tarikh_masuk) : null;
                })
                ->addColumn('waktu_masuk', function ($data) {
                    return ! empty($data->waktu_masuk) ? Utils::formatTime2($data->waktu_masuk) : null;
                })
                ->addColumn('tarikh_keluar', function ($data) {
                    return ! empty($data->tarikh_keluar) ? Utils::formatDate($data->tarikh_keluar) : null;
                })
                ->addColumn('waktu_keluar', function ($data) {
                    return ! empty($data->waktu_keluar) ? Utils::formatTime2($data->waktu_keluar) : null;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-success">Keluar</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-info">Masuk</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-danger">Lewat</span>';
                            break;
                        case 3:
                            return '<span class="badge badge-warning">Lewat Dengan Alasan</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.hep.pengurusan.keluar_masuk.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.keluar_masuk.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'no_ic', 'tarikh_masuk', 'waktu_masuk', 'tarikh_keluar', 'waktu_keluar', 'status', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable' => false],
                ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'waktu_keluar', 'name' => 'waktu_keluar', 'title' => 'Masa Keluar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh Masuk', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'waktu_masuk', 'name' => 'waktu_masuk', 'title' => 'Masa Masuk', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

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

        $action = route('pengurusan.hep.pengurusan.keluar_masuk.store');
        $page_title = 'Tambah Rekod Keluar Masuk';

        $title = 'Rekod Keluar Masuk';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Keluar Masuk' => false,
            'Tambah Rekod' => false,
        ];

        $model = new KeluarMasuk();

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'pelajar_id' => 'required',
            'tarikh_keluar' => 'required',
            'waktu_keluar' => 'required',
            'status' => 'required',
        ], [
            'pelajar_id.required' => 'Sila pilih pelejar',
            'tarikh_keluar.required' => 'Sila tarikh keluar',
            'waktu_keluar.required' => 'Sila masa keluar',
            'status.required' => 'Sila status',
        ]);

        $pelajar = Pelajar::find($request->pelajar_id);

        KeluarMasuk::create([
            'pelajar_id' => $request->pelajar_id,
            'user_id' => $pelajar->user_id,
            'tarikh_keluar' => Carbon::createFromFormat('d/m/Y', $request->tarikh_keluar)->format('Y-m-d'),
            'waktu_keluar' => $request->waktu_keluar,
            'tarikh_masuk' => $request->tarikh_masuk ? Carbon::createFromFormat('d/m/Y', $request->tarikh_masuk)->format('Y-m-d') : null,
            'waktu_masuk' => $request->waktu_masuk,
            'status' => $request->status,
        ]);

        Alert::toast('Maklumat keluar masuk berjaya ditambah!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.keluar_masuk.index');

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
        $action = route('pengurusan.hep.pengurusan.keluar_masuk.update', $id);
        $page_title = 'Pinda Maklumat Keluar Masuk';

        $title = 'Maklumat Keluar Masuk';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Keluar Masuk' => false,
        ];

        $model = KeluarMasuk::find($id);

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar'));
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
            'tarikh_keluar' => 'required',
            'waktu_keluar' => 'required',
            'status' => 'required',
        ], [
            'tarikh_keluar.required' => 'Sila tarikh keluar',
            'waktu_keluar.required' => 'Sila masa keluar',
            'status.required' => 'Sila status',
        ]);

        $keluar_masuk = KeluarMasuk::find($id);

        $keluar_masuk->tarikh_keluar = Carbon::createFromFormat('d/m/Y', $request->tarikh_keluar)->format('Y-m-d');
        $keluar_masuk->waktu_keluar = $request->waktu_keluar;
        $keluar_masuk->tarikh_masuk = $request->tarikh_masuk ? Carbon::createFromFormat('d/m/Y', $request->tarikh_masuk)->format('Y-m-d') : null;
        $keluar_masuk->waktu_masuk = $request->waktu_masuk;
        $keluar_masuk->status = $request->status;
        $keluar_masuk->save();

        Alert::toast('Maklumat keluar masuk berjaya dikemaskini!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.keluar_masuk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keluar_masuk = KeluarMasuk::find($id);

        $keluar_masuk = $keluar_masuk->delete();

        Alert::toast('Maklumat keluar masuk berjaya dihapus!', 'success');

        return redirect()->back();

    }
}
