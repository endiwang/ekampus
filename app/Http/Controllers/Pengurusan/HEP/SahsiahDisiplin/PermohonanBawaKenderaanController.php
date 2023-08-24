<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\PermohonanBawaKenderaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PermohonanBawaKenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseView = 'pages.pengurusan.hep.permohonan.bawa_kenderaan.';

     public function index(Builder $builder)
     {


         $title = 'Permohonan Bawa Kenderaan';
         $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Permohonan' => false,
             'Bawa Kenderaan' => false,
         ];
         $buttons = [
         ];

         if (request()->ajax()) {
             $data = PermohonanBawaKenderaan::query();

             return DataTables::of($data)
                ->addColumn('nama_pelajar', function($data) {
                    if(!empty($data->pelajar)){
                        $data = $data->pelajar->nama;
                    }
                    else {
                        $data = '';
                    }

                    return $data;
                })
                ->addColumn('no_ic', function($data) {
                    if(!empty($data->pelajar)){
                        $data = '<p style="text-align:center">' . $data->pelajar->no_ic . '<br/> <span style="font-weight:bold"> [' . $data->pelajar->no_matrik . '] </span></p>';
                    }
                    else {
                        $data = '';
                    }

                    return $data;
                })
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
                 ->addColumn('jenis', function ($data) {
                     switch ($data->jenis_kenderaan) {
                         case 'K':
                             return '<span class="badge badge-success">Kereta</span>';
                             break;

                         case 'M':
                             return '<span class="badge badge-success">Motorsikal</span>';
                             break;
                     }
                 })
                 ->addColumn('tarikh_permohonan', function ($data) {
                     $tarikh = Utils::formatDate($data->created_at);

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
                 ->rawColumns(['status', 'action','jenis','tarikh_permohonan','nama_pelajar','no_ic'])
                 ->toJson();
         }

         $dataTable = $builder
             ->columns([
                 ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                 ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                 ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable'=> false],
                 ['data' => 'no_rujukan', 'name' => 'no_rujukan', 'title' => 'No Rujukan', 'orderable' => false],
                 ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                 ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
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
        $title = 'Permohonan Bawa Kenderaan';
        $page_title = 'Permohonan Bawa Kenderaan';
        $action = route('pengurusan.hep.permohonan.bawa_kenderaan.update', $id);
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Permohonan' => false,
             'Bawa Kenderaan' => false,
             'Maklumat Permohonan' => false,

         ];

        $data = PermohonanBawaKenderaan::find($id);
        return view($this->baseView.'edit', compact('title', 'breadcrumbs', 'data', 'page_title','action'));
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
        $data = PermohonanBawaKenderaan::find($id);
        $data->status = $request->status;
        $data->update_by = Auth::user()->id;
        $data->save();
         return redirect()->route('pengurusan.hep.permohonan.bawa_kenderaan.index');
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
