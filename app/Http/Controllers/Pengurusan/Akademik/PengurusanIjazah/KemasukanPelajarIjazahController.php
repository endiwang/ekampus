<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;
use App\Models\Pelajar;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\Negeri;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class KemasukanPelajarIjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {

        $title = "Pelajar Ijazah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Pelajar" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Pelajar",
                    'route' => route('pengurusan.akademik.pengurusan_ijazah.pelajar.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

        if (request()->ajax()) {
            $data = Pelajar::where('kursus_id',12);
            if($request->has('nama_pelajar') && $request->nama_pelajar != NULL)
            {
                $data->where('nama', 'LIKE', '%' . $request->nama_pelajar . '%');
            }
            if($request->has('no_matrik') && $request->no_matrik != NULL)
            {
                $data->where('no_matrik', 'LIKE', '%' . $request->no_matrik . '%');
            }
            if($request->has('sesi') && $request->sesi != NULL)
            {
                $data->where('sesi_id',  $request->sesi);
            }
            return DataTables::of($data)
            ->addColumn('sesi_kemasukan', function($data) {
                if($data->sesi == NULL)
                {
                    return '';
                }else{
                    return $data->sesi->nama;
                }
            })
            ->addColumn('pusat_pengajian', function($data) {
                if($data->pusat_pengajian == NULL)
                {
                    return '';
                }else{
                    return $data->pusat_pengajian->nama;
                }
            })
            ->addColumn('kursus', function($data) {
                if($data->kursus == NULL)
                {
                    return '';
                }else{
                    return $data->kursus->nama;
                }
            })
            ->addIndexColumn()
            ->rawColumns(['no_kp_no_matrik','sesi_kemasukan','pusat_pengajian'])
            ->toJson();
        }

        $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder
        ->parameters([
            'language' => '{ "lengthMenu": "Show _MENU_", }',
            'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil', 'render'=> null, 'orderable'=> false, 'searchable'=> false, 'exportable'=> false, 'printable'=> true, 'footer'=> '',],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama'],
            ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No K/P'],
            ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik'],
            ['data' => 'sesi_kemasukan', 'name' => 'sesi_kemasukan', 'title' => 'Sesi Kemasukan'],
            ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus'],
            // ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred'],
            // ['data' => 'jawatan', 'name' => 'jawatan', 'title' => 'Jabatan'],
            // ['data' => 'gred', 'name' => 'gred', 'title' => 'Jawatan'],
            // ['data' => 'intro', 'name' => 'intro', 'title' => 'Intro'],
            ['data' => 'pusat_pengajian', 'name' => 'pusat_pengajian', 'title' => 'Pusat Pengajian'],
        ])
        ->minifiedAjax();

        $intake_sessions = Sesi::where('deleted_at', NULL)->pluck('nama', 'id');

        return view('pages.pengurusan.akademik.pengurusan_ijazah.pendaftaran_pelajar.main', compact('dataTable','buttons','title','breadcrumbs', 'intake_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kursus_id_ijazah = 12;
        $title = "Tambah Pelajar Ijazah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Tambah Pelajar Ijazah" =>  false,
            ];

            $buttons = [
            ];

            $kursus = Kursus::find($kursus_id_ijazah);
            $maklumat_pemohon = '';
            $negeri =  Negeri::pluck('nama','id');
            $sesi =  Sesi::where('kursus_id', $kursus_id_ijazah)->pluck('nama','id');




        return view('pages.pengurusan.akademik.pengurusan_ijazah.pendaftaran_pelajar.create', compact('buttons','title','breadcrumbs','kursus','maklumat_pemohon','negeri','sesi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->file('avatar')) {
            $fileName = $request->file('avatar')->getClientOriginalName();
            $filePath = $request->file('avatar')->storeAs('uploads/pelajar/gambar_pelajar', $fileName, 'public');
            $file_path = '/storage/' . $filePath;
        }

        //password = 123

        $password_hash = '$2y$10$DYl/XAwUYLdFk4BDUD0lkO12yxz0ZO.YpwySx0ZV9.OBVF2o/vi2y';

        $user = User::where('username', $request->no_kp)->first();

        if(!$user)
        {
            $user = User::create([
                'username' => $request->no_kp,
                'password' => $password_hash,
                'is_student' => 1,
            ]);
        }

        Pelajar::create([
            "user_id"               => $user->id,
            "kursus_id"             => $request->kursus_id,
            "img_pelajar"           => $file_path,
            "no_ic"                 => $request->no_kp,
            "email"                 => $request->email,
            "nama"                  => $request->nama_pemohon,
            'tarikh_lahir'          => Carbon::createFromFormat('d/m/Y', $request->tarikh_lahir)->format('Y-m-d'),
            "alamat"                => $request->alamat_tetap,
            "bandar"                => $request->bandar_tetap,
            "poskod"                => $request->poskod_tetap,
            "negeri_id"             => $request->negeri_tetap,
            "alamat_surat"          => $request->alamat_surat,
            "bandar_surat"          => $request->bandar_surat,
            "poskod_surat"          => $request->poskod_surat,
            "negeri_id_surat"       => $request->negeri_surat,
            "no_tel"                => $request->no_telefon,
            "jantina"               => $request->jantina,
            "negeri_kelahiran_id"   => $request->negeri_kelahiran,
            "keturunan_id"          => $request->keturunan,
            "bumiputra"             => $request->bumiputra,
            "mualaf"                => $request->mualaf,
            "warganegara"           => $request->kewarganegaraan,
            "syukbah_id"            => 1,
            "sesi_id"               => $request->sesi,
        ]);


        Alert::toast('Maklumat pelajar ijazah berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.pelajar.index');
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
