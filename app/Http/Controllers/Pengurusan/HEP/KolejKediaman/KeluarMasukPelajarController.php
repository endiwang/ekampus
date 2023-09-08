<?php

namespace App\Http\Controllers\Pengurusan\HEP\KolejKediaman;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KeluarMasuk;
use App\Models\Pelajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KeluarMasukPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseView = 'pages.pengurusan.hep.kolej_kediaman.keluar_masuk.';

     public function index(Builder $builder)
     {
         $title = 'Rekod Keluar Masuk';
         $breadcrumbs = [
             'Kolej Kediaman' => false,
             'Rekod Keluar Masuk' => false,
         ];

         $buttons = [
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
                 ->addIndexColumn()
                 ->order(function ($data) {
                     $data->orderBy('id', 'desc');
                 })
                 ->rawColumns(['status', 'no_ic', 'tarikh_masuk', 'waktu_masuk', 'tarikh_keluar', 'waktu_keluar', 'status'])
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
