<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BarangRampasan;
use App\Helpers\Utils;

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
                         <a href="'.route('pengurusan.hep.permohonan.bawa_kenderaan.edit', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                             <i class="fa fa-eye"></i>
                         </a>';
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
        //
    }
}
