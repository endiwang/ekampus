<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Models\Tawaran;
use Yajra\DataTables\DataTables;
use App\Helpers\Utils;
use App\Models\Kursus;
use App\Models\Sesi;
use App\Models\Staff;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;

class TawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {


            $title = "Senarai Maklumat Pemilihan Pelajar";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Senarai Maklumat Pemilihan Pelajar	" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Maklumat",
                    'route' => route('pengurusan.kbg.tawaran.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Tawaran::all();
                return DataTables::of($data)

                ->addColumn('kursus', function($data) {


                    if($data->kursus)
                    {
                        $nama = $data->kursus->nama;
                    }else{
                        $nama = 'N/A';
                    }
                    $info = '<p class="mb-0">'.$nama.'</p>';

                    if($data->tawaran_type == 'R')
                    {
                        $info .='<p><span class="text-capitalize text-danger font-weight-bold">Tawaran Rayuan</span></p>';

                    }


                    return $info;
                })
                ->addColumn('sesi', function($data) {

                    if($data->sesi)
                    {
                        return $data->sesi->nama;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('bil_calon', function($data) {

                    return '';
                })

                ->addColumn('tarikh_format', function($data) {

                    return Utils::formatDate($data->tarikh);
                })


                ->addColumn('action', function($data){

                    $action = '<a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up" data-bs-toggle="tooltip">
                    <i class="fa fa-print"></i></a>

                    <a href="'.route('pengurusan.kbg.tawaran.show',$data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up" data-bs-toggle="tooltip">
                    <i class="fa fa-user-plus"></i></a>';
                    if($data->close_tawaran =='1')
                    {
                        $action .= '<a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up m-1" data-bs-toggle="tooltip">
                        <i class="fa fa-times"></i></a>';
                    }

                    return $action;
                })

                ->addIndexColumn()
                ->rawColumns(['kursus','kod','action','sesi','tarikh_format'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
                ['data' => 'kursus',      'name' => 'kursus',           'title' => 'Bidang Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'sesi',     'name' => 'sesi',          'title' => 'Sesi Pengajian', 'orderable'=> false],
                ['data' => 'tarikh_format',     'name' => 'tarikh_format',          'title' => 'Tarikh Pendaftaran', 'orderable'=> false],
                ['data' => 'masa',     'name' => 'masa',          'title' => 'Masa', 'orderable'=> false],
                ['data' => 'bil_calon',     'name' => 'bil_calon',          'title' => 'Bilangan Calon', 'orderable'=> false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.pemilihan_calon.main', compact('title', 'breadcrumbs', 'dataTable','buttons'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Penambahan Maklumat Tawaran';
        $page_title = 'Maklumat Proses Temuduga';
        $breadcrumbs = [
            "Kemasukan Biasiswa Graduasi" =>  false,
            "Proses Temuduga" =>  false,
            "Tambah Proses" =>  false,
        ];

        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');

        return view('pages.pengurusan.kbg.pemilihan_calon.add_new', compact('title', 'breadcrumbs', 'page_title','kursus','sesi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tawaran::create([
            'kursus_id' => $request->program_pengajian,
            'sesi_id' => $request->sesi,
            'tajuk_tawaran' => $request->tajuk_tawaran,
            'tarikh_surat' => Carbon::createFromFormat('d/m/Y',$request->tarikh_surat)->format('Y-m-d'),
            'tarikh' => Carbon::createFromFormat('d/m/Y',$request->tarikh_pendaftaran)->format('Y-m-d'),
            'masa' => $request->masa_pendaftaran,
            'nama_tempat' => $request->nama_tempat_pendaftaran,
            'alamat_pendaftaran' => $request->alamat_tempat_pendaftaran,
            'status' => $request->status_kemasukan,
            'tawaran_type' => $request->tawaran_type,
        ]);

        Alert::toast('Maklumat tawaran berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.kbg.pengurusan.tawaran.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tawaran = Tawaran::find($id);
        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');
        return view('pages.pengurusan.kbg.pemilihan_calon.show', compact('tawaran','kursus','sesi'));
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
        $tawaran = Tawaran::find($id);


        $tawaran->kursus_id = $request->program_pengajian;
        $tawaran->sesi_id = $request->sesi;
        $tawaran->tajuk_tawaran = $request->tajuk_tawaran;
        $tawaran->tarikh_surat = Carbon::createFromFormat('d/m/Y',$request->tarikh_surat)->format('Y-m-d');
        $tawaran->tarikh = Carbon::createFromFormat('d/m/Y',$request->tarikh_pendaftaran)->format('Y-m-d');
        $tawaran->masa = $request->masa_pendaftaran;
        $tawaran->nama_tempat = $request->nama_tempat_pendaftaran;
        $tawaran->alamat_pendaftaran = $request->alamat_tempat_pendaftaran;
        $tawaran->status = $request->status_kemasukan;
        $tawaran->tawaran_type = $request->tawaran_type;
        $tawaran->save();

        Alert::toast('Maklumat tawaran berjaya dikemaskini!', 'success');
        return redirect()->route('pengurusan.kbg.pengurusan.tawaran.index');

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
