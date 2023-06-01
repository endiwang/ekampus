<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\Permohonan;
use App\Models\OldDatabase\sis_tblpermohonan;
use App\Helpers\Utils;
use App\Models\Kursus;
use App\Models\Negeri;
use App\Models\PusatPengajian;
use App\Models\Sesi;
use App\Models\Staff;
use App\Models\Temuduga;
use App\Models\TemudugaMarkah;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PusatTemuduga;

class ProsesTemudugaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        try {


            $title = "Proses Temuduga";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Temuduga" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Proses",
                    'route' => route('pengurusan.kbg.proses_temuduga.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Temuduga::where('is_close',0)->where('is_sph',0)->whereDate('tarikh', '>=', Carbon::now('Asia/Kuala_Lumpur'))
                ->get();
                return DataTables::of($data)

                ->addColumn('pusat_temuduga', function($data) {

                    $ketua = $data->ketua != NULL ? $data->ketua->nama : 'N/A';
                    $info = '<p>' . $data->nama_tempat . '<br/>'.$data->kursus->nama.'<br/> Ketua: <span class="text-capitalize">'.$ketua.'</span></p>';

                    return $info;
                })
                ->addColumn('kod', function($data){
                    $kod = PusatPengajian::find($data->pusat_pengajian_id);
                    if($kod != NULL)
                    {
                        return $kod->kod;

                    }
                })

                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.kbg.pengurusan.proses_temuduga.export_senarai',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Pemarkahan Temuduga" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>

                            <a href="'.route('pengurusan.kbg.pengurusan.proses_temuduga.pilih_pemohon',$data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pilih Pemohon">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.proses_temuduga.show', $data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>';

                })

                ->addIndexColumn()
                ->rawColumns(['pusat_temuduga','kod','action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
                ['data' => 'pusat_temuduga',      'name' => 'pusat_temuduga',           'title' => 'Pusat Temuduga', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kod',     'name' => 'no_ic',          'title' => 'Kod', 'orderable'=> false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.proses_temuduga.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $title = 'Penambahan Maklumat Proses Temuduga';
            $page_title = 'Maklumat Proses Temuduga';
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Temuduga" =>  false,
                "Tambah Proses" =>  false,
            ];

            $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');
            $ketua_temuduga = Staff::where('deleted_at', null)->pluck('nama', 'id');
            $pusat_temuduga = PusatTemuduga::where('pusat_pengajian_id',1)->get()->pluck('nama', 'id');


            return view('pages.pengurusan.kbg.proses_temuduga.add_new', compact('title', 'breadcrumbs', 'page_title','kursus','ketua_temuduga','sesi','pusat_temuduga'));

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'tajuk_borang_temuduga'         => 'required',
            'program_pengajian'             => 'required',
            'sesi'                          => 'required',
            'pilihan_temuduga'              => 'required',
            'pusat_temuduga'                => 'required',
            'tarikh_temuduga'               => 'required',
            'masa_temuduga'                 => 'required',
            'nama_tempat_temuduga'          => 'required',
            'alamat_tempat_temuduga'        => 'required',
            'tarikh_cetak_surat_temuduga'   => 'required',
            'ketua_temuduga'                => 'required',
        ],[
            'tajuk_borang_temuduga.required'        => 'Sila masukkan tajuk borang temuduga',
            'program_pengajian.required'            => 'Sila pilih program pengajian',
            'sesi.required'                         => 'Sila pilih sesi pengajian',
            'pilihan_temuduga.required'             => 'Sila pilih pilihan temuduga',
            'pusat_temuduga.required'               => 'Sila pilih pusat temuduga',
            'tarikh_temuduga.required'              => 'Sila masukkan tarikh temuduga',
            'masa_temuduga.required'                => 'Sila masukkan masa temuduga',
            'nama_tempat_temuduga.required'         => 'Sila masukkan nama tempat temuduga',
            'alamat_tempat_temuduga.required'       => 'Sila masukkan alamat tempat temuduga',
            'tarikh_cetak_surat_temuduga.required'  => 'Sila masukkan tarikh cetakan surat temuduga',
            'ketua_temuduga.required'               => 'Sila pilih ketua temuduga',
        ]);

        Temuduga::create([
            'tajuk_borang'      => $request->tajuk_borang_temuduga,
            'kursus_id'         => $request->program_pengajian,
            'sesi_id'         => $request->sesi,
            'temuduga_type'     => $request->pilihan_temuduga,
            'pusat_temuduga_id'    => $request->pusat_temuduga,
            'tarikh'            => Carbon::createFromFormat('d/m/Y',$request->tarikh_temuduga)->format('Y-m-d'),
            'masa'              => $request->masa_temuduga,
            'nama_tempat'       => $request->nama_tempat_temuduga,
            'alamat_temuduga'   => $request->alamat_tempat_temuduga,
            'tkh_cetakan'       => Carbon::createFromFormat('d/m/Y',$request->tarikh_cetak_surat_temuduga)->format('Y-m-d'),
            'id_ketua'          => $request->ketua_temuduga,
            'pusat_pengajian_id'=> 1,
            'hari'              => 'Hari',
            'waktu'             => 'Waktu'
        ]);

        Alert::toast('Maklumat proses temuduga berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.kbg.pengurusan.proses_temuduga.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $temuduga = Temuduga::find($id);

        $title = 'Pinda Maklumat Proses Temuduga';
            $page_title = 'Maklumat Proses Temuduga';
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Temuduga" =>  false,
                "Pinda Proses" =>  false,
            ];

        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');
        $ketua_temuduga = Staff::where('deleted_at', null)->pluck('nama', 'id');
        $pusat_temuduga = PusatTemuduga::where('pusat_pengajian_id',1)->pluck('nama', 'id');


        return view('pages.pengurusan.kbg.proses_temuduga.show', compact('title', 'breadcrumbs', 'page_title','kursus','ketua_temuduga','sesi','temuduga','pusat_temuduga'));
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
        $temuduga = Temuduga::find($id);
        $temuduga->tajuk_borang = $request->tajuk_borang_temuduga;
        $temuduga->kursus_id = $request->program_pengajian;
        $temuduga->sesi_id = $request->sesi;
        $temuduga->temuduga_type = $request->pilihan_temuduga;
        $temuduga->pusat_temuduga_id = $request->pusat_temuduga;
        $temuduga->tarikh = Carbon::createFromFormat('d/m/Y',$request->tarikh_temuduga)->format('Y-m-d');
        $temuduga->masa = $request->masa_temuduga;
        $temuduga->nama_tempat = $request->nama_tempat_temuduga;
        $temuduga->alamat_temuduga = $request->alamat_tempat_temuduga;
        $temuduga->id_ketua = $request->ketua_temuduga;
        $temuduga->tkh_cetakan = Carbon::createFromFormat('d/m/Y',$request->tarikh_cetak_surat_temuduga)->format('Y-m-d');

        $temuduga->save();
        Alert::toast('Maklumat proses temuduga berjaya dikemaskini!', 'success');
        return redirect()->route('pengurusan.kbg.pengurusan.proses_temuduga.index');

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

    public function pilih_pemohon(Builder $builder, $id)
    {

        // try {
            $proses_temuduga = Temuduga::find($id);
            $sesi = Sesi::find($proses_temuduga->sesi_id);
            $title = 'Maklumat Senarai Pemohon';
            $page_title = $proses_temuduga->kursus->nama.' - '.$sesi->nama;
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Temuduga" =>  false,
                "Pilih Pemohon" =>  false,
            ];




            if (request()->ajax()) {
                $data = Permohonan::where('kursus_id', $proses_temuduga->kursus_id)->where('is_deleted',0)->where('is_submitted',1)->where('is_selected',1)->where('is_tawaran',0)->where('is_interview',0)->where('sesi_id',$sesi->id)->get();
                return DataTables::of($data)
                ->addColumn('kursus', function($data) {
                    if(!empty($data->kursus_id))
                    {
                        return $data->kursus->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('checkbox', function($data) {
                    $checkbox = '<input class="form-check-input" type="checkbox"  value="1">';
                    return $checkbox;
                })
                ->addIndexColumn()
                ->rawColumns(['kursus','checkbox'])
                ->toJson();
            }

                $dataTable = $builder
                ->columns([
                    ['data' => 'checkbox',  'name' => 'checkbox', 'title' => '', 'orderable'=> false],
                    [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                    ['data' => 'nama',      'name' => 'nama',         'title' => 'Nama', 'orderable'=> false],
                    ['data' => 'no_ic',      'name' => 'no_ic',         'title' => 'No IC', 'orderable'=> false],
                ])
                ->minifiedAjax();


            return view('pages.pengurusan.kbg.proses_temuduga.pilih_pemohon', compact('title', 'breadcrumbs', 'page_title','proses_temuduga','dataTable','proses_temuduga'));

        // }
        // catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
    }

    public function pilih_pemohon_api($id)
    {
        // if (request()->ajax()) {
            $proses_temuduga = Temuduga::find($id);
            $sesi = Sesi::find($proses_temuduga->sesi_id);
            $data = Permohonan::where('kursus_id', $proses_temuduga->kursus_id)->where('is_deleted',0)->where('is_submitted',1)->where('is_selected',1)->where('is_tawaran',0)->where('is_interview',0)->where('sesi_id',$sesi->id)->get();

            return Datatables::of($data)
                // ->addIndexColumn()
                // ->rawColumns(['paid','status','amount','category','application_date','action','checkbox'])
                ->make(true);
        // }
    }

    public function store_pemohon(Request $request)
    {
        $proses_temuduga = Temuduga::find($request->proses_temuduga_id);
        foreach($request->ids as $id)
        {
            $permohonan = Permohonan::find($id);
            $permohonan->is_interview = 1;
            $permohonan->temuduga_id = $request->proses_temuduga_id;
            $permohonan->interview_date = Carbon::now()->format('Y-m-d');
            $permohonan->interview_by = $proses_temuduga->id_ketua;
            $permohonan->save();


            TemudugaMarkah::create([
                'temuduga_id' => $request->proses_temuduga_id,
                'permohonan_id' => $id,
                'kursus_id' => $permohonan->kursus_id,
                'pusat_temuduga_id' => $proses_temuduga->pusat_temuduga_id,
                'temuduga_type' => $proses_temuduga->temuduga_type,
                'create_by' => Auth::user()->staff_id,
            ]);
        }
        Alert::success( 'Pemohon berjaya dipilih');
        return ['success' => true];
    }

    public function kemas_kini_markah($id)
    {
        $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();

        $title = "Kemas Kini Markah Temuduga";
        $breadcrumbs = [
            "Kemasukan Biasiswa Graduasi" =>  false,
            "Keputusan Temuduga" =>  false,
            "Kemas Kini Markah" =>  false,
        ];

        $temuduga = Temuduga::find($id);

        return view('pages.pengurusan.kbg.keputusan_temuduga.kemas_kini_markah', compact('title', 'breadcrumbs', 'markah_temuduga','temuduga'));


    }

    public function export_senarai($id)
    {

        $temuduga = Temuduga::find($id);
        // $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();
        $title = 'Temuduga Program ' . $temuduga->tajuk_borang;

        $datas  = $this->exportDataProcess($id);
        $view_file  = 'pages.pengurusan.kbg.proses_temuduga.export_pdf';
        $orientation = 'landscape';

                return Utils::pdfGenerate($title, $datas, $view_file, $orientation);
    }

    private function exportDataProcess($id)
    {

        $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->with('pemohon',)->get();

        $temuduga = Temuduga::find($id);

        $datas = [
            'temuduga'        => $temuduga,
            'markah_temuduga' => $markah_temuduga
        ];

        return $datas;

    }
}
