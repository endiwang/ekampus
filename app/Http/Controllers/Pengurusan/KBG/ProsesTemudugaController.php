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
use App\Models\Staff;
use App\Models\Temuduga;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;

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
                $data = Temuduga::where('is_close',0)->get();
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
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Borang Kehadiran Temuduga">
                                <i class="fa fa-file-circle-check"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Pemarkahan Temuduga">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-warning btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hantar Senarai Keputusan Ke Format Excel">
                                <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hantar Senarai Keputusan Ke Format Excel">
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
            $ketua_temuduga = Staff::where('deleted_at', null)->pluck('nama', 'id');

            return view('pages.pengurusan.kbg.proses_temuduga.add_new', compact('title', 'breadcrumbs', 'page_title','kursus','ketua_temuduga'));

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
            'pilihan_temuduga'              => 'required',
            'pusat_temuduga'                => 'required',
            'tarikh_temuduga'               => 'required',
            'masa_temuduga'                 => 'required',
            'nama_tempat_temuduga'        => 'required',
            'alamat_tempat_temuduga'        => 'required',
            'tarikh_cetak_surat_temuduga'   => 'required',
            'ketua_temuduga'                => 'required',
        ],[
            'tajuk_borang_temuduga.required'        => 'Sila masukkan tajuk borang temuduga',
            'program_pengajian.required'            => 'Sila pilih program pengajian',
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
