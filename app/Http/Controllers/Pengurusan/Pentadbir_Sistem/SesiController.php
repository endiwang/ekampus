<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sesi;
use Yajra\DataTables\Html\Builder;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $data = Sesi::query();
            return DataTables::of($data)
            ->addColumn('kursus', function($data) {
                if($data->kursus == NULL)
                {
                    return '';
                }else{
                    return $data->kursus->nama;
                }
            })
            ->addColumn('status_edit', function($data) {
                switch ($data->status) {
                    case 0:
                        return '<span class="badge badge-success">Aktif</span>';
                      break;
                    case 1:
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    default:
                      return '';
                  }
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('order', 'desc');
            })
            ->rawColumns(['kursus','status_edit'])
            ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder
        ->parameters([
            'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false],
            ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
        ])
        ->minifiedAjax();

        $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        return view('pages.pengurusan.pentadbir_sistem.sesi.main', compact('dataTable','kursus'));
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
