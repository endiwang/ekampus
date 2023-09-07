<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanKemudahanBilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\BilikAsrama;
use Illuminate\Support\Carbon;

class PermohonanPenggunaanKemudahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pelajar.permohonan.penggunaan_kemudahan.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Penggunaan Kemudahan Bilik';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Penggunaan Kemudahan Bilik' => false,
        ];
        $buttons = [
            [
                'title' => 'Permohonan Baru',
                'route' => route('pelajar.permohonan.penggunaan_kemudahan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PenggunaanKemudahanBilik::where('pelajar_id', Auth::user()->pelajar->last()->id);

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Permohonan Baru</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Lulus</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-danger">Tidak Lulus</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    $tarikh = Utils::formatDate($data->created_at);

                    return $tarikh;
                })
                ->addColumn('bilik', function ($data) {
                    if($data->bilik)
                    {
                        return $data->bilik->no_bilik;
                    }else{
                        return 'N/A';
                    }

                })
                ->addColumn('action', function ($data) {
                    if($data->status == 1)
                        return '
                            <a href="'.route('pelajar.permohonan.penggunaan_kemudahan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pelajar.permohonan.penggunaan_kemudahan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kemas Kini">
                                <i class="fa fa-pencil"></i>
                            </a>';
                        else{
                            return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.penggunaan_kemudahan.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';

                        }
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'tarikh_permohonan'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_rujukan', 'name' => 'no_rujukan', 'title' => 'No Rujukan', 'orderable' => false],
                ['data' => 'nama_persatuan', 'name' => 'nama_persatuan', 'title' => 'Nama Persatuan', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Permohonan', 'orderable' => false],
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
        $title = 'Penggunaan Kemudahan Bilik';
        $action = route('pelajar.permohonan.penggunaan_kemudahan.store');
        $page_title = 'Penggunaan Kemudahan Bilik';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Penggunaan Kemudahan Bilik' => false,
            'Permohonan Baru' => false,
        ];

        $bilik = BilikAsrama::where('no_bilik','LIKE','%dorm%')->pluck('no_bilik','id');


        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title','bilik'));
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
            'nama_persatuan' => 'required',
            'tujuan' => 'required',
            'tarikh_mula_penggunaan' => 'required',
            'tarikh_tamat_penggunaan' => 'required',
            'bilik_asrama_id' => 'required',
        ], [
            'nama_persatuan.required' => 'Sila masukkan nama institusi',
            'tujuan.required' => 'Sila masukkan tujuan',
            'tarikh_mula_penggunaan.required' => 'SSila pilih tarikh mula penggunaan',
            'tarikh_tamat_penggunaan.required' => 'Sila pilih tarikh tamat penggunaan',
            'bilik_asrama_id.required' => 'Sila pilih bilik',
        ]);

        $request->request->add([
            'tarikh_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_penggunaan)->format('Y-m-d'),
            'tarikh_tamat' => Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat_penggunaan)->format('Y-m-d'),
            'no_rujukan' => 'PPKB-'.date('Ymd').'-'.rand(1000, 9999),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $data = PenggunaanKemudahanBilik::create($request->all());

        Alert::toast('Maklumat permohonan penggunaan kemudahan bilik berjaya dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.penggunaan_kemudahan.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = PenggunaanKemudahanBilik::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
