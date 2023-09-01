<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\BarangRampasan;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class BarangRampasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.pengurusan.barang_rampasan.';

    public function index(Builder $builder)
    {

        $title = 'Rekod Barang Rampasan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Barang Rampasan' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Rekod Barang Rampasan',
                'route' => route('pengurusan.hep.pengurusan.barang_rampasan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = BarangRampasan::query();

            return DataTables::of($data)
                ->addColumn('no_ic', function ($data) {
                    $data = '<p style="text-align:center">'.$data->no_ic_pemilik.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik_pemilik.'] </span></p>';

                    return $data;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Tidak Dituntut</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Dituntut</span>';
                            break;
                    }
                })
                ->addColumn('jenis', function ($data) {
                    switch ($data->jenis_barang) {
                        case 'E':
                            return '<span class="badge badge-success">Electrik</span>';
                            break;

                        case 'EN':
                            return '<span class="badge badge-success">Electronik</span>';
                            break;
                        case 'NE':
                            return '<span class="badge badge-success">Bukan Electrik/Electronik</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_rampasan', function ($data) {
                    $tarikh = Utils::formatDate($data->tarik_rampasan);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.hep.pengurusan.barang_rampasan.tuntutan', $data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tuntutan">
                             <i class="fa fa-check"></i>
                         </a>
                         <a href="'.route('pengurusan.hep.pengurusan.barang_rampasan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                             <i class="fa fa-pencil"></i>
                         </a>
                         <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                         <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.barang_rampasan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'jenis', 'tarikh_permohonan', 'nama_pelajar', 'no_ic'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pemilik', 'name' => 'nama_pemilik', 'title' => 'Nama Pemilik', 'orderable' => false],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable' => false],
                ['data' => 'no_pelekat', 'name' => 'no_pelekat', 'title' => 'No Pelekat', 'orderable' => false],
                ['data' => 'tarikh_rampasan', 'name' => 'tarikh_rampasan', 'title' => 'Tarikh Rampasan', 'orderable' => false],
                ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
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
        $action = route('pengurusan.hep.pengurusan.barang_rampasan.store');
        $page_title = 'Tambah Rekod Barang Rampasan';

        $title = 'Tambah Rekod Barang Rampasan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Barang Rampasan' => false,
            'Tambah Rekod' => false,
        ];

        $model = new BarangRampasan();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required',
            'jenama' => 'required',
            'warna' => 'required',
            'tarikh_rampasan_barang' => 'required',
            'masa_rampasan' => 'required',
            'tempat_rampasan' => 'required',
            'sebab_rampasan' => 'required',
        ], [
            'jenis_barang.required' => 'Sila pilih jenis barang',
            'jenama.required' => 'Sila masukkan jenama',
            'warna.required' => 'Sila masukkan warna',
            'tarikh_rampasan_barang.required' => 'Sila pilih tarikh rampasan',
            'masa_rampasan.required' => 'Sila masakkan masa rampasan',
            'tempat_rampasan.required' => 'Sila masukkan tempat rampasan',
            'sebab_rampasan.required' => 'Sila masukkan sebab rampasan',
        ]);

        if ($request->has('lampiran_rampasan_upload')) {
            $lampiran_rampasan = uniqid().'.'.$request->lampiran_rampasan_upload->getClientOriginalExtension();
            $lampiran_rampasan_path = 'uploads/hal_ehwal_pelajar/lampiran_rampasan';
            $file_lampiran_rampasan = $request->file('lampiran_rampasan_upload')->storeAs($lampiran_rampasan_path, $lampiran_rampasan, 'public');
            $request->request->add(['lampiran_rampasan' => $file_lampiran_rampasan]);
        }

        $request->request->add([
            'tarikh_rampasan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_rampasan_barang)->format('Y-m-d'),
            'create_by' => Auth::user()->id,
            'update_by' => Auth::user()->id,
        ]);

        $data = BarangRampasan::create($request->all());

        Alert::toast('Maklumat barang rampasan berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.barang_rampasan.store');
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
        $action = route('pengurusan.hep.pengurusan.barang_rampasan.update', $id);
        $page_title = 'Pinda Rekod Barang Rampasan';

        $title = 'Pinda Rekod Barang Rampasan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Barang Rampasan' => false,
            'Pinda Rekod' => false,
        ];

        $model = BarangRampasan::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
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
            'jenis_barang' => 'required',
            'jenama' => 'required',
            'warna' => 'required',
            'tarikh_rampasan_barang' => 'required',
            'masa_rampasan' => 'required',
            'tempat_rampasan' => 'required',
            'sebab_rampasan' => 'required',
        ], [
            'jenis_barang.required' => 'Sila pilih jenis barang',
            'jenama.required' => 'Sila masukkan jenama',
            'warna.required' => 'Sila masukkan warna',
            'tarikh_rampasan_barang.required' => 'Sila pilih tarikh rampasan',
            'masa_rampasan.required' => 'Sila masakkan masa rampasan',
            'tempat_rampasan.required' => 'Sila masukkan tempat rampasan',
            'sebab_rampasan.required' => 'Sila masukkan sebab rampasan',
        ]);

        $data = BarangRampasan::find($id);
        $data->nama_pemilik = $request->nama_pemilik;
        $data->no_ic_pemilik = $request->no_ic_pemilik;
        $data->no_matrik_pemilik = $request->no_matrik_pemilik;
        $data->no_pelekat = $request->no_pelekat;
        $data->jenis_barang = $request->jenis_barang;
        $data->jenama = $request->model;
        $data->model = $request->model;
        $data->warna = $request->warna;
        $data->tarikh_rampasan = Carbon::createFromFormat('d/m/Y', $request->tarikh_rampasan_barang)->format('Y-m-d');
        $data->masa_rampasan = $request->masa_rampasan;
        $data->tempat_rampasan = $request->tempat_rampasan;
        $data->sebab_rampasan = $request->sebab_rampasan;
        $data->status = $request->status;
        $data->update_by = Auth::user()->id;

        if ($request->has('lampiran_rampasan_upload')) {
            $lampiran_rampasan = uniqid().'.'.$request->lampiran_rampasan_upload->getClientOriginalExtension();
            $lampiran_rampasan_path = 'uploads/hal_ehwal_pelajar/lampiran_rampasan';
            $file_lampiran_rampasan = $request->file('lampiran_rampasan_upload')->storeAs($lampiran_rampasan_path, $lampiran_rampasan, 'public');
            $data->lampiran_rampasan = $file_lampiran_rampasan;
        }

        $data->save();

        Alert::toast('Maklumat barang rampasan berjaya dipinda!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.barang_rampasan.store');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tetapan = BarangRampasan::find($id);

        $tetapan = $tetapan->delete();

        Alert::toast('Maklumat barang rampasan berjaya dihapus!', 'success');

        return redirect()->back();
    }

    public function tuntutan_barang($id)
    {
        $action = route('pengurusan.hep.pengurusan.barang_rampasan.tuntutan', $id);
        $page_title = 'Tuntutan Barang Rampasan';

        $title = 'Tuntutan Barang Rampasan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Barang Rampasan' => false,
            'Tuntutan' => false,
        ];

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic_no_matrik', 'id');

        $model = BarangRampasan::find($id);

        return view($this->baseView.'tuntutan', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar'));
    }

    public function tuntutan_barang_store(Request $request, $id)
    {

        $request->validate([
            'pelajar_id' => 'required',
            'status' => 'required',
        ], [
            'pelajar_id.required' => 'Sila pilih jenis barang',
            'status.required' => 'Sila masukkan jenama',
        ]);

        $model = BarangRampasan::find($id);
        $model->pelajar_id = $request->pelajar_id;
        $model->status = $request->status;
        $model->update_by = Auth::user()->id;

        $model->save();

        Alert::toast('Barang rampasan telah dituntut!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.barang_rampasan.index');

    }
}
