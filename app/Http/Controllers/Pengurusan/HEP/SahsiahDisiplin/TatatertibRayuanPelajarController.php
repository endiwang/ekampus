<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\TatatertibPelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TatatertibRayuanPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseView = 'pages.pengurusan.hep.pengurusan.tatatertib_rayuan_pelajar.';

     public function index(Builder $builder)
     {

         $title = 'Tatatertib Pelajar';
         $breadcrumbs = [
             'Hal Ehwal Pelajar' => false,
             'Pengurusan' => false,
             'Tatatertib Pelajar' => false,
         ];
         $buttons = [
             [
                 'title' => "Tambah Rekod Tatatertib Pelajar",
                 'route' => route('pengurusan.hep.pengurusan.tatatertib_pelajar.create'),
                 'button_class' => "btn btn-sm btn-primary fw-bold",
                 'icon_class' => "fa fa-plus-circle"
             ],
         ];

         if (request()->ajax()) {
             $data = TatatertibPelajar::query();

             return DataTables::of($data)
             ->addColumn('nama_pelaku', function ($data) {
                 return $data->pelaku->nama;
             })
             ->addColumn('no_ic_matrik', function ($data) {
                 if (! empty($data->pelaku)) {
                     $data = '<p style="text-align:center">'.$data->pelaku->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->pelaku->no_matrik.'] </span></p>';
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
                         <a href="'.route('pengurusan.hep.pengurusan.tatatertib_pelajar.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                             <i class="fa fa-pencil"></i>
                         </a>
                         <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                             <i class="fa fa-trash"></i>
                         </a>
                         <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.tatatertib_pelajar.destroy', $data->id).'" method="POST">
                             <input type="hidden" name="_token" value="'.csrf_token().'">
                             <input type="hidden" name="_method" value="DELETE">
                         </form>';
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
                 ['data' => 'nama_pelaku', 'name' => 'nama_pelaku', 'title' => 'Nama Pelajar', 'orderable' => false],
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
        $title = 'Tatatertib Pelajar';
        $action = route('pengurusan.hep.pengurusan.tatatertib_pelajar.store');
        $page_title = 'Tambah Rekod Tatatertib Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Tatatertib Pelajar' => false,
            'Tambah Rekod' => false,
        ];

        $model = new TatatertibPelajar();

        $pelajar = Pelajar::where('is_berhenti',0)->get()->pluck('name_ic_no_matrik','id');
        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','pelajar'));
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
            'pelajar_id' => 'required'
        ], [
            'pelajar_id.required' => 'Sila pilih pelajar',
        ]);

        if($request->has('laporan_kes_upload'))
        {
            $laporan_kes = uniqid().'.'.$request->laporan_kes_upload->getClientOriginalExtension();
            $laporan_kes_path = 'uploads/tatatertib/laporan_kes';
            $file_laporan_kes = $request->file('laporan_kes_upload')->storeAs($laporan_kes_path, $laporan_kes, 'public');
            $request->request->add(['laporan_kes' => $file_laporan_kes]);
        }

        if($request->has('nota_hadir_upload'))
        {
            $nota_hadir = uniqid().'.'.$request->nota_hadir_upload->getClientOriginalExtension();
            $nota_hadir_path = 'uploads/tatatertib/nota_hadir';
            $file_nota_hadir = $request->file('laporan_kes_upload')->storeAs($nota_hadir_path, $nota_hadir, 'public');
            $request->request->add(['nota_hadir' => $file_nota_hadir]);
        }

        if($request->has('fakta_kes_upload'))
        {
            $fakta_kes = uniqid().'.'.$request->laporan_kes_upload->getClientOriginalExtension();
            $fakta_kes_path = 'uploads/tatatertib/fakta_kes';
            $file_fakta_kes = $request->file('fakta_kes_upload')->storeAs($fakta_kes_path, $fakta_kes, 'public');
            $request->request->add(['fakta_kes' => $file_fakta_kes]);
        }

        if($request->has('kertas_pertuduhan_upload'))
        {
            $kertas_pertuduhan = uniqid().'.'.$request->kertas_pertuduhan_upload->getClientOriginalExtension();
            $kertas_pertuduhan_path = 'uploads/tatatertib/kertas_pertuduhan';
            $file_kertas_pertuduhan= $request->file('kertas_pertuduhan_upload')->storeAs($kertas_pertuduhan_path, $kertas_pertuduhan, 'public');
            $request->request->add(['kertas_pertuduhan' => $file_kertas_pertuduhan]);
        }

        $data = TatatertibPelajar::create($request->all());

        Alert::toast('Maklumat tatatertib pelajar berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.tatatertib_pelajar.index');
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
        $action = route('pengurusan.hep.pengurusan.tatatertib_pelajar.update', $id);
        $page_title = 'Pinda Rekod Tatatertib Pelajar';

        $title = 'Maklumat Aduan Tatatertib Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Tatatertib Pelajar' => false,
        ];

        $model = TatatertibPelajar::find($id);

        $pelajar = Pelajar::where('is_berhenti',0)->get()->pluck('name_ic_no_matrik','id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'pelajar'));
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
        $tatatertib = TatatertibPelajar::find($id);
        $tatatertib->keputusan_kes_hukuman = $request->keputusan_kes_hukuman;
        $tatatertib->nota_prosiding = $request->nota_prosiding;
        $tatatertib->status_hukuman = $request->status_hukuman;

        if($request->has('laporan_kes_upload'))
        {
            $laporan_kes = uniqid().'.'.$request->laporan_kes_upload->getClientOriginalExtension();
            $laporan_kes_path = 'uploads/tatatertib/laporan_kes';
            $file_laporan_kes = $request->file('laporan_kes_upload')->storeAs($laporan_kes_path, $laporan_kes, 'public');
            $tatatertib->laporan_kes = $file_laporan_kes;
        }

        if($request->has('nota_hadir_upload'))
        {
            $nota_hadir = uniqid().'.'.$request->nota_hadir_upload->getClientOriginalExtension();
            $nota_hadir_path = 'uploads/tatatertib/nota_hadir';
            $file_nota_hadir = $request->file('laporan_kes_upload')->storeAs($nota_hadir_path, $nota_hadir, 'public');
            $tatatertib->nota_hadir = $file_nota_hadir;
        }

        if($request->has('fakta_kes_upload'))
        {
            $fakta_kes = uniqid().'.'.$request->fakta_kes_upload->getClientOriginalExtension();
            $fakta_kes_path = 'uploads/tatatertib/fakta_kes';
            $file_fakta_kes = $request->file('fakta_kes_upload')->storeAs($fakta_kes_path, $fakta_kes, 'public');
            $tatatertib->fakta_kes = $file_fakta_kes;
        }

        if($request->has('kertas_pertuduhan_upload'))
        {
            $kertas_pertuduhan = uniqid().'.'.$request->kertas_pertuduhan_upload->getClientOriginalExtension();
            $kertas_pertuduhan_path = 'uploads/tatatertib/kertas_pertuduhan';
            $file_kertas_pertuduhan= $request->file('kertas_pertuduhan_upload')->storeAs($kertas_pertuduhan_path, $kertas_pertuduhan, 'public');
            $tatatertib->kertas_pertuduhan = $file_kertas_pertuduhan;
        }


        $tatatertib->save();

        //Email pelaku utk notifikasi

        Alert::toast('Maklumat Aduan Salahlaku Pelajar Berjaya Dikemaskini', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.tatertib_pelajar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = TatatertibPelajar::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat tatatertib pelajar berjaya dihapuskan!', 'success');

        return redirect()->back();
    }

    public function rayuan($id)
    {
        //
    }

    public function rayuan_store($id)
    {
        //
    }
}
