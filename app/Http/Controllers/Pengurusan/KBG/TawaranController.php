<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Models\Tawaran;
use Yajra\DataTables\DataTables;
use App\Helpers\Utils;
use App\Mail\TawaranPemohon;
use App\Models\Kursus;
use App\Models\Permohonan;
use App\Models\Sesi;
use App\Models\Staff;
use App\Models\TawaranPermohonan;
use App\Models\TemudugaMarkah;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

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
                $data = Tawaran::orderBy('id', 'desc');
                return DataTables::of($data->get())

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

                ->addColumn('bilangan_pemohon', function($data) {

                    $bil = $data->tawaran_permohonan;

                    if($bil)
                    {
                        return $bil->count();
                    }else{
                        return 0;
                    }
                })


                ->addColumn('action', function($data){

                    $action = '<a href="'.route('pengurusan.kbg.pengurusan.tawaran.export_senarai',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up" data-bs-toggle="tooltip" target="_black">
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
                ->rawColumns(['kursus','kod','action','sesi','tarikh_format','bilangan_pemohon'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
                ['data' => 'kursus',      'name' => 'kursus',           'title' => 'Bidang Pengajian', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'sesi',     'name' => 'sesi',          'title' => 'Sesi Pengajian', 'orderable'=> false],
                ['data' => 'tarikh_format',     'name' => 'tarikh_format',          'title' => 'Tarikh Pendaftaran', 'orderable'=> false],
                ['data' => 'masa',     'name' => 'masa',          'title' => 'Masa', 'orderable'=> false],
                ['data' => 'bilangan_pemohon',     'name' => 'bilangan_pemohon',          'title' => 'Bilangan Calon', 'orderable'=> false],
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
            'tawaran_id_old' => 'NULL',
            'kursus_id' => $request->program_pengajian,
            'sesi_id' => $request->sesi,
            'pusat_id' => 1,
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
    public function show(Builder $builder, $id)
    {
        $title = "Maklumat Tawaran";
        $breadcrumbs = [
            "Kemasukan Biasiswa Graduasi" =>  false,
            "Senarai Maklumat Pemilihan Pelajar	" =>  false,
            "Maklumat Tawaran	" =>  false,
        ];

        $tawaran = Tawaran::find($id);
        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');



        if (request()->ajax()) {
            $data = TawaranPermohonan::where('tawaran_id',$id)->with('pemohon');
            return DataTables::of($data->get())

            ->addColumn('nama', function($data) {


                return $data->pemohon->nama;

            })
            ->addColumn('no_ic', function($data) {

                return $data->pemohon->no_ic;

            })
            ->addColumn('no_tel', function($data) {

                return $data->pemohon->no_tel;
            })
            ->addColumn('status', function($data) {

                if($data->is_terima == '1')
                {
                    return '<span class="badge badge-primary">Terima</span>';
                }elseif($data->is_terima == '2'){
                    return '<span class="badge badge-danger">Tolak</span>';
                }else{
                    return '';
                }
            })


            ->addColumn('action', function($data){

                $action = '<a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up" data-bs-toggle="tooltip">
                <i class="fa fa-copy"></i></a>
                <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up" data-bs-toggle="tooltip">
                <i class="fa fa-print"></i></a>
                <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up" data-bs-toggle="tooltip">
                <i class="fa fa-print"></i></a>';

                return $action;
            })

            ->addIndexColumn()
            ->rawColumns(['nama','no_ic','no_tel','action','status'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
            ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No IC', 'orderable'=> false],
            ['data' => 'no_tel',     'name' => 'no_tel',          'title' => 'No Tel', 'orderable'=> false],
            ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],
            ['data' => 'status',    'name' => 'status',         'title' => 'Status','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],

        ])
        ->minifiedAjax();


        return view('pages.pengurusan.kbg.pemilihan_calon.show', compact('tawaran','kursus','sesi','title','breadcrumbs','dataTable'));
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

    public function pilih_pelajar($id)
    {
        $title = "Pilih Pelajar";
        $breadcrumbs = [
            "Kemasukan Biasiswa Graduasi" =>  false,
            "Senarai Maklumat Pemilihan Pelajar	" =>  false,
            "Maklumat Tawaran" =>  false,
            "Pilih Pelajar" =>  false,
        ];

        $tawaran = Tawaran::find($id);

        return view('pages.pengurusan.kbg.pemilihan_calon.pilih_pelajar', compact('tawaran','title','breadcrumbs'));
    }

    public function pilih_pelajar_api($id)
    {
        // if (request()->ajax()) {
            $tawaran = Tawaran::find($id);

            // $data = TemudugaMarkah::where('tawaran_id',$id);

            $data = Permohonan::where('kursus_id', $tawaran->kursus_id)->where('sesi_id',$tawaran->sesi_id)->where('is_tawaran',0)
                        ->whereHas('temuduga_markah', function ($query) use ($tawaran) {
                            $query  ->where('jumlah', '>',0);
                        })->with('temuduga_markah')->get();

            // $data = Permohonan::where('kursus_id', $proses_temuduga->kursus_id)->where('is_deleted',0)->where('is_submitted',1)->where('is_selected',1)->where('is_tawaran',0)->where('is_interview',0)->where('sesi_id',$sesi->id)->get();

            return Datatables::of($data)
                // ->addIndexColumn()
                // ->rawColumns(['paid','status','amount','category','application_date','action','checkbox'])
                ->make(true);
        // }
    }

    public function store_pelajar(Request $request)
    {
        $tawaran = Tawaran::find($request->tawaran_id);
        foreach($request->ids as $id)
        {
            $permohonan = Permohonan::find($id);
            $permohonan->is_tawaran = 1;
            // $permohonan->temuduga_id = $request->proses_temuduga_id;
            // $permohonan->interview_date = Carbon::now()->format('Y-m-d');
            // $permohonan->interview_by = $proses_temuduga->id_ketua;
            $permohonan->save();


            TawaranPermohonan::create([
                'tawaran_id' => $request->tawaran_id,
                'permohonan_id' => $id,
            ]);

            Mail::to($permohonan->email)->send(new TawaranPemohon($tawaran,$permohonan));

        }

        Alert::success( 'Pemohonan berjaya dipilih');
        return ['success' => true];
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

    public function export_senarai($id)
    {

        $temuduga = Tawaran::find($id);
        // $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();
        $title = 'Senarai Pemohon';

        $datas  = $this->exportDataProcess($id);
        $view_file  = 'pages.pengurusan.kbg.pemilihan_calon.export_pdf';
        $orientation = 'landscape';

                return Utils::pdfGenerate($title, $datas, $view_file, $orientation);
    }

    private function exportDataProcess($id)
    {


        $tawaran = Tawaran::find($id);
        $pemohon = TawaranPermohonan::where('tawaran_id',$id)->with('pemohon')->get();


        $datas = [
            'tawaran'   => $tawaran,
            'pemohon'   => $pemohon
        ];

        return $datas;

    }

}
