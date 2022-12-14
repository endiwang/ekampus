<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sesi;
use Yajra\DataTables\Html\Builder;
use RealRashid\SweetAlert\Facades\Alert;


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
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                      break;
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                    default:
                      return '';
                  }
            })
            ->addColumn('action', function($data){
                // $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2">View</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';

                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';

                 return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('order', 'desc');
            })
            ->rawColumns(['kursus','status_edit','action'])
            ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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
        $sesi_year_from= [];
        foreach(range( date('Y'), date('Y') + 6) as $year_form) {
            $sesi_year_from[$year_form] = $year_form;
        }

        $sesi_year_to= [];
        foreach(range( date('Y') + 1, date('Y') + 7) as $year_to) {
            $sesi_year_to[$year_to] = $year_to;
        }

        $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');

        return view('pages.pengurusan.pentadbir_sistem.sesi.add_new', compact(['kursus','sesi_year_from','sesi_year_to']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_bermula' => 'required',
            'tahun_berakhir' => 'required',
            'kursus' => 'required',
        ],[
            'tahun_bermula.required' => 'Sila pilih tahun bermula',
            'tahun_berakhir.required' => 'Sila pilih tahun berakhir',
            'kursus.required' => 'Sila pilih kursus',
        ]);

        $sesi = Sesi::latest('created_at', 'desc')->first();

        $nama = 'SESI '. $request->tahun_bermula.'/'.$request->tahun_berakhir;
        Sesi::create([
            'nama' => $nama,
            'kursus_id' => $request->kursus,
            'status' => $request->status,
            'order' => $sesi->order+1,
        ]);

        Alert::toast('Sesi Pengajian Berjaya Ditambah', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.sesi.index');
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
