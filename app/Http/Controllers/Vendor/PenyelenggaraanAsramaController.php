<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Models\PenyelenggaraanAsrama;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use Illuminate\Support\Carbon;

class PenyelenggaraanAsramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.vendor.penyelenggaraan_asrama.';

    protected $baseRoute = 'vendor.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        $title = 'Rekod Penyelenggaraan Asrama';
        $breadcrumbs = [
            'Vendor' => false,
            'Penyelenggaraan Asrama' => false,
        ];
        $buttons = [
        ];

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();

        if (request()->ajax()) {
            $data = PenyelenggaraanAsrama::where('vendor_id', $vendor->id);

            return DataTables::of($data)
                ->addColumn('tarikh_aduan', function ($data) {
                    return Utils::formatDate($data->created_at) ?? null;
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
                            <a href="'.route('vendor.penyelenggaraan_asrama.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                                <i class="fa fa-pencil"></i>
                            </a>';
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
                ['data' => 'tarikh_aduan', 'name' => 'tarikh_aduan', 'title' => 'Tarikh Aduan', 'orderable' => false],
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $action = route('vendor.penyelenggaraan_asrama.update', $id);
        $page_title = 'Kemas Kini Rekod Penyelenggaraan';

        $title = 'Kemas Kini Rekod Penyelenggaraan';
        $breadcrumbs = [
            'Vendor' => false,
            'Penyelenggaraan Asrama' => false,
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
            'status_kerja' => 'required',
        ], [
            'status_kerja.required' => 'Sila pilih status kerja',
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

        $data->status_kerja = $request->status_kerja;
        $data->save();

        Alert::toast('Maklumat rekod penyelenggaraan asrama berjaya dikemas kini!', 'success');

        return redirect()->route('vendor.penyelenggaraan_asrama.index');
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
