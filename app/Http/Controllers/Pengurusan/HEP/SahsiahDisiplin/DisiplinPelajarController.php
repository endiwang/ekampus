<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\DisiplinPelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class DisiplinPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseView = 'pages.pengurusan.hep.pengurusan.disiplin_pelajar.';

    public function index(Builder $builder)
    {

        $title = 'Disiplin Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Permohonan' => false,
            'Disiplin Pelajar' => false,
        ];

        $buttons = [
        ];

        if (request()->ajax()) {
            $data = DisiplinPelajar::query();

            return DataTables::of($data)
            ->addColumn('nama_pelaku', function ($data) {
                return $data->aduan->pelaku->nama;
            })
            ->addColumn('no_ic_matrik', function ($data) {
                if (! empty($data->aduan->pelaku)) {
                    $data = '<p style="text-align:center">'.$data->aduan->pelaku->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->aduan->pelaku->no_matrik.'] </span></p>';
                } else {
                    $data = '';
                }

                return $data;
            })
                ->addColumn('status', function ($data) {
                    switch ($data->status_hukuman) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Berjalan</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-info">Sedang Berjalan</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-success">Selesai</span>';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.hep.permohonan.keluar_masuk.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.keluar_masuk.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action','no_ic_matrik'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pelaku', 'name' => 'nama_pelaku', 'title' => 'Nama Pelaku', 'orderable' => false],
                ['data' => 'no_ic_matrik', 'name' => 'no_ic_matrik', 'title' => 'No MyKad/Passport [No Matrik]', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Hukuman', 'orderable' => false],
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
