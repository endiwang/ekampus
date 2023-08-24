<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\TemplateJemputanMajlisPensijilan;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class JemputanMajlisPenyerahanSijilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        $title = 'Senarai Jemputan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => false,
            'Majlis Pensijilan' => false,
            'Jemputan Majlis Pensijilan' => false,
        ];

        if (request()->ajax()) {
            $query = PemarkahanCalonSijilTahfiz::query();
            if ($request->has('carian')) {
                $query->join('pelajar as p', 'p.id', '=', 'pemarkahan_calon_sijil_tahfizs.pelajar_id')
                    ->where(function($q) use ($request){
                        $q->where('p.nama', 'LIKE', '%'.$request->carian.'%');
                        $q->orWhere('p.no_ic', 'LIKE', '%'.$request->carian.'%');
                    });
            }
            $data = $query->where('pemarkahan_calon_sijil_tahfizs.approval', 1)
                ->where('pemarkahan_calon_sijil_tahfizs.status_kelulusan', 1);

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    return $data->pelajar->nama ?? null;
                })
                ->addColumn('status_kehadiran', function ($data) {
                    switch ($data->status_terima_sijil) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Hadir</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Hadir</span>';
                            break;
                        
                        default:
                            return '';
                    }
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status_terima_sijil) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Dijana</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Belum Dijana</span>';
                            break;
                        
                        default:
                            return '';
                    }
                })
                ->addColumn('select', function ($data) {
                    $btn = '<input type="hidden" name="pelajar_id[]" value="'.$data->pelajar_id.'">';

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('pemarkahan_calon_sijil_tahfizs.id', 'asc');
                })
                ->rawColumns(['status', 'select', 'nama','status_kehadiran'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Jemputan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status_kehadiran', 'name' => 'status_kehadiran', 'title' => 'Status Kehadiran', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Janaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'select', 'name' => 'select','title'=>'Pilih', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
            ])
            ->columnDefs([
                [
                    'orderable' => 'false',
                    'className' => 'select-checkbox',
                    'targets' => -1
                ],
            ])
            ->select(
                ['style' =>'multi']
            )
            ->parameters(
                [
                    'info'=>false,
                    'paging' => false,
                ]
            )
            ->minifiedAjax();

            $majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->whereNull('deleted_at')->get()->pluck('nama', 'id');
            $template = TemplateJemputanMajlisPensijilan::where('status', 1)->whereNull('deleted_at')->get()->pluck('name', 'id');

        return view('pages.pengurusan.pengajian_sepanjang_hayat.majlis_pensijilan.jemputan_majlis_pensijilan.main', compact('title', 'breadcrumbs', 'dataTable', 'majlis', 'template'));
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
