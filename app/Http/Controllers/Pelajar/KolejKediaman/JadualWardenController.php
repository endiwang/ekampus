<?php

namespace App\Http\Controllers\Pelajar\KolejKediaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadualWarden;
use App\Models\JadualWardenToWarden;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Carbon;

class JadualWardenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseView = 'pages.pelajar.kolej_kediaman.jadual_warden.';

     public function index(Builder $builder)
     {

         $title = 'Jadual Waden';
         $breadcrumbs = [
             'Pelajar' => false,
             'Jadual Waden' => false,
         ];
         $buttons = [
         ];

         if (request()->ajax()) {
             $data = JadualWarden::query();

             return DataTables::of($data)
                 ->addColumn('bulan', function ($data) {
                     switch ($data->bulan) {
                         case 1:
                             return 'Januari';
                             break;
                         case 2:
                             return 'Februari';
                             break;
                         case 3:
                             return 'Mac';
                             break;
                         case 4:
                             return 'April';
                             break;
                         case 5:
                             return 'May';
                             break;
                         case 6:
                             return 'Jun';
                             break;
                         case 7:
                             return 'Julai';
                             break;
                         case 8:
                             return 'Ogos';
                             break;

                         case 9:
                             return 'September';
                             break;
                         case 10:
                             return 'Oktober';
                             break;
                         case 11:
                             return 'November';
                             break;
                         case 12:
                             return 'Desember';
                             break;
                     }
                 })
                 ->addColumn('status', function ($data) {
                     switch ($data->status) {
                         case 0:
                             return '<span class="badge badge-primary">Tidak Aktif</span>';
                             break;

                         case 1:
                             return '<span class="badge badge-success">Aktif</span>';
                             break;
                     }
                 })
                 ->addColumn('action', function ($data) {
                         return '
                             <a href="'.route('pelajar.jadual_warden.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 pr-1" data-bs-toggle="tooltip" title="Lihat">
                                 <i class="fa fa-eye"></i>
                             </a>';
                 })
                 ->addIndexColumn()
                 ->order(function ($data) {
                     $data->orderBy('id', 'desc');
                 })
                 ->rawColumns(['status', 'action', 'tarikh_permohonan','nama_pelajar','no_ic'])
                 ->toJson();
         }

         $dataTable = $builder
             ->columns([
                 ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                 ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false],
                 ['data' => 'bulan', 'name' => 'bulan', 'title' => 'Bulan', 'orderable' => false],
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
    public function show(Builder $builder, $id)
    {
        $title = 'Senarai Warden Bertugas';
        $breadcrumbs = [
            'Pelajar' => false,
            'Senarai Warden Bertugas' => false,
        ];
        $buttons = [

        ];
        $jadual = JadualWarden::find($id);


        if (request()->ajax()) {
            $data = JadualWardenToWarden::where('jadual_warden_id',$id);

            return DataTables::of($data)
                ->addColumn('warden', function ($data) {
                    if ($data->staff) {
                        return $data->staff->nama;
                    }else{
                        return 'N\A';
                    }
                })
                ->addColumn('no_tel', function ($data) {
                    if ($data->staff) {
                        return $data->staff->no_tel;
                    }else{
                        return 'N\A';
                    }
                })
                ->addColumn('tarikh', function ($data) {
                    return Carbon::parse($data->tarikh)->format('d/m/Y');

                })
                ->addColumn('action', function ($data) use ($id) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1 pr-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>

                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.kolej_kediaman.jadual_warden.destroy_warden',[$id, $data->id]).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action','tarikh'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'warden', 'name' => 'warden', 'title' => 'Warden', 'orderable' => false],
                ['data' => 'no_tel', 'name' => 'no_tel', 'title' => 'No Telefon', 'orderable' => false],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'senarai_warden', compact('title', 'breadcrumbs', 'buttons', 'dataTable','jadual'));

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
