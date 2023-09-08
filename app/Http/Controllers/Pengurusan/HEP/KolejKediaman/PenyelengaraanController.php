<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Http\Controllers\Controller;
use App\Models\PenyelenggaraanAsrama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\Vendor;
use Illuminate\Support\Carbon;

class PenyelengaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.penyelenggaraan.';

    public function index(Builder $builder)
    {

        $title = 'Rekod Penyelenggaraan Asrama';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Penyelenggaraan' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Rekod Penyelenggaraan',
                'route' => route('pengurusan.kolej_kediaman.penyelenggaraan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PenyelenggaraanAsrama::query();

            return DataTables::of($data)
                ->addColumn('vendor', function ($data) {
                    if ($data->vendor) {
                        return $data->vendor->nama_syarikat;
                    }else{
                        return 'N\A';
                    }
                })
                ->addColumn('status_aduan', function ($data) {
                    switch ($data->status_aduan) {
                        case 0:
                            return '<span class="badge badge-primary">Aduan Baru</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-info">Buka</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-success">Tutup</span>';
                            break;
                    }
                })
                ->addColumn('status_kerja', function ($data) {
                    switch ($data->status_kerja) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Bermula</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-info">Sedang Dijalankan</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-success">Selesai</span>';
                            break;
                    }
                })
                ->addColumn('keputusan_aduan', function ($data) {
                    switch ($data->keputusan_aduan) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Selesai</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-success">Cemerlang</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-info">Memuaskan</span>';
                            break;
                        case 3:
                            return '<span class="badge badge-warning">Tidak Memuaskan</span>';
                            break;
                        case 4:
                            return '<span class="badge badge-danger">Perlu Diperbaikai</span>';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.kolej_kediaman.penyelenggaraan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                                <i class="fa fa-pencil"></i>
                            </a><a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1 ml-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.penyelenggaraan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status_aduan', 'action','keputusan_aduan','status_kerja'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_kerja', 'name' => 'nama_kerja', 'title' => 'Nama Kerja', 'orderable' => false],
                ['data' => 'vendor', 'name' => 'vendor', 'title' => 'Vendor', 'orderable' => false],
                ['data' => 'status_aduan', 'name' => 'status_aduan', 'title' => 'Status Aduan', 'orderable' => false],
                ['data' => 'status_kerja', 'name' => 'status_kerja', 'title' => 'Status Kerja', 'orderable' => false],
                ['data' => 'keputusan_aduan', 'name' => 'keputusan_aduan', 'title' => 'Keputusan', 'orderable' => false],
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
        $action = route('pengurusan.kolej_kediaman.penyelenggaraan.store');
        $page_title = 'Tambah Rekod Penyelenggaraan';

        $title = 'Tambah Rekod Penyelenggaraan';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Penyelenggaraan' => false,
            'Tambah Rekod' => false,

        ];

        $model = new PenyelenggaraanAsrama();

        $vendor = Vendor::where('status', 1)->pluck('nama_syarikat', 'id');


        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','vendor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kerja' => 'required',
            'kategori' => 'required',
            'vendor_id' => 'required',
        ], [
            'nama_kerja.required' => 'Sila masukkan nama kerja',
            'kategori.required' => 'Sila pilih kategori',
            'vendor_id.required' => 'Sila pilih vendor',
        ]);



        $data = PenyelenggaraanAsrama::create($request->all());

        Alert::toast('Maklumat rekod penyelenggaraan asrama berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.penyelenggaraan.index');
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
        $action = route('pengurusan.kolej_kediaman.penyelenggaraan.update', $id);
        $page_title = 'Kemas Kini Rekod Penyelenggaraan';

        $title = 'Kemas Kini Rekod Penyelenggaraan';
        $breadcrumbs = [
            'Kolej Kediaman' => false,
            'Penyelenggaraan' => false,
            'Kemas Kini Rekod' => false,

        ];

        $model = PenyelenggaraanAsrama::find($id);

        $vendor = Vendor::where('status', 1)->pluck('nama_syarikat', 'id');


        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','vendor'));
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
            'nama_kerja' => 'required',
            'kategori' => 'required',
            'vendor_id' => 'required',
        ], [
            'nama_kerja.required' => 'Sila masukkan nama kerja',
            'kategori.required' => 'Sila pilih kategori',
            'vendor_id.required' => 'Sila pilih vendor',
        ]);

        $data = PenyelenggaraanAsrama::find($id);

        if($request->has('tarikh_mula_aduan') && $request->tarikh_mula_aduan != NULL)
        {
            $data->tarikh_mula = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_aduan)->format('Y-m-d');
        }

        if($request->has('tarikh_selesai_aduan') && $request->tarikh_selesai_aduan != NULL)
        {
            $data->tarikh_selesai = Carbon::createFromFormat('d/m/Y', $request->tarikh_selesai_aduan)->format('Y-m-d');
        }

        $data->nama_kerja = $request->nama_kerja;
        $data->kategori = $request->kategori;
        $data->vendor_id = $request->vendor_id;
        $data->status_aduan = $request->status_aduan;
        $data->status_kerja = $request->status_kerja;
        $data->keputusan_aduan = $request->keputusan_aduan;
        $data->komen = $request->komen;
        $data->save();

        Alert::toast('Maklumat rekod penyelenggaraan asrama berjaya dikemas kini!', 'success');

        return redirect()->route('pengurusan.kolej_kediaman.penyelenggaraan.index');
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
