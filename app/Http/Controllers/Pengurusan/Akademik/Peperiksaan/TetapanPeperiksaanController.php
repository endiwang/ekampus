<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Bilik;
use App\Models\JadualPeperiksaan;
use App\Models\Kursus;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use App\Models\Subjek;
use App\Models\Syukbah;
use App\Models\TetapanPeperiksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;


class TetapanPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.peperiksaan.jadual_peperiksaan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        $title = "Peperiksaan";
        $breadcrumbs = [
            "Akademik" =>  false,
            "Peperiksaan" =>  false,
        ];

        $buttons = [
            [
                'title' => "Tambah Tetapan Peperiksaan",
                'route' => route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanPeperiksaan::query();
            return DataTables::of($data)

            ->addColumn('kursus', function($data) {
                if(!empty($data->kursus))
                {
                    return $data->kursus->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('semester', function($data) {
                if(!empty($data->semester))
                {
                    return $data->semester->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })

            ->addColumn('syukbah', function($data) {
                if(!empty($data->syukbah))
                {
                    return $data->syukbah->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('sesi', function($data) {
                if(!empty($data->sesi))
                {
                    return $data->sesi->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.edit',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Jadual">
                            <i class="fa fa-print"></i>
                        </a>
                        <a href="'.route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('id', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Tetapan', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'semester', 'name' => 'semester', 'title' => 'Semester', 'orderable'=> false],
            ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi', 'orderable'=> false],
            ['data' => 'syukbah', 'name' => 'syukbah', 'title' => 'Syukbah', 'orderable'=> false],

            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Builder $builder)
    {
        $title = 'Tetapan Peperiksaan';
        $action = route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.store');
        $page_title = 'Tambah Tetapan Peperiksaan Baru';
        $breadcrumbs = [
            "Akademik" =>  false,
            "Peperiksaan" =>  false,
            "Tambah Tetapan" =>  false,
        ];

        $model = new TetapanPeperiksaan();

        $dataTable = $builder->columns([]);

        $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');
        $syukbah = Syukbah::where('is_deleted',NULL)->pluck('nama', 'id');
        $semester = Semester::where('is_deleted',0)->pluck('nama', 'id');
        $pusat_pengajian = PusatPengajian::where('is_deleted',0)->pluck('nama', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'dataTable','kursus','sesi','semester','syukbah','pusat_pengajian'));
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
            'nama'              => 'required',
            'pusat_pengajian'   => 'required',
            'kursus'            => 'required',
            'sesi'              => 'required',
            'semester'          => 'required',
            'syukbah'           => 'required',
        ],[
            'nama.required'             => 'Sila masukkan nama nama tetapan',
            'pusat_pengajian.required'  => 'Sila pilih pusat pengajian pengajian',
            'kursus.required'           => 'Sila pilih program pengajian pengajian',
            'sesi.required'             => 'Sila pilih sisi pengajian pengajian',
            'semester.required'         => 'Sila pilih semester pengajian',
            'syukbah.required'          => 'Sila pilih syukbah pengajian',
        ]);

        TetapanPeperiksaan::create([
            'nama'              => $request->nama,
            'pusat_pengajian_id'=> $request->pusat_pengajian,
            'kursus_id'         => $request->kursus,
            'sesi_id'           => $request->sesi,
            'semester_id'       => $request->semester,
            'syukbah_id'        => $request->syukbah,
        ]);

        Alert::toast('Maklumat tetapan peperiksaan berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.index');
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
    public function edit($id, Builder $builder)
    {

        $title = 'Tetapan Peperiksaan';
        $action = route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.update',$id);
        $page_title = 'Pinda Tetapan Peperiksaan';
        $breadcrumbs = [
            "Akademik" =>  false,
            "Peperiksaan" =>  false,
            "Pinda Tetapan" =>  false,
        ];

        $model = TetapanPeperiksaan::find($id);

        $dataTable = $builder->columns([]);

        $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');
        $syukbah = Syukbah::where('is_deleted',NULL)->pluck('nama', 'id');
        $semester = Semester::where('is_deleted',0)->pluck('nama', 'id');
        $pusat_pengajian = PusatPengajian::where('is_deleted',0)->pluck('nama', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'dataTable','kursus','sesi','semester','syukbah','pusat_pengajian'));
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
        $validation = $request->validate([
            'nama'              => 'required',
            'pusat_pengajian'   => 'required',
            'kursus'            => 'required',
            'sesi'              => 'required',
            'semester'          => 'required',
            'syukbah'           => 'required',
        ],[
            'nama.required'             => 'Sila masukkan nama nama tetapan',
            'pusat_pengajian.required'  => 'Sila pilih pusat pengajian pengajian',
            'kursus.required'           => 'Sila pilih program pengajian pengajian',
            'sesi.required'             => 'Sila pilih sisi pengajian pengajian',
            'semester.required'         => 'Sila pilih semester pengajian',
            'syukbah.required'          => 'Sila pilih syukbah pengajian',
        ]);

        $data = TetapanPeperiksaan::find($id);

            $data->nama               = $request->nama;
            $data->pusat_pengajian_id = $request->pusat_pengajian;
            $data->kursus_id          = $request->kursus;
            $data->sesi_id            = $request->sesi;
            $data->semester_id        = $request->semester;
            $data->syukbah_id         = $request->syukbah;
            $data->save();

        Alert::toast('Maklumat tetapan peperiksaan berjaya dipinda!', 'success');
        return redirect()->route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.index');
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

    public function pilih_subjek($id, Builder $builder)
    {
        $tetapan = TetapanPeperiksaan::find($id);

        $title = 'Tetapan Peperiksaan';
        $action = route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.store_pilihan_subjek', $id);
        $page_title = 'Pilih Subjek';
        $breadcrumbs = [
            "Akademik" =>  false,
            "Peperiksaan" =>  false,
            "Tetapan Peperiksaan" =>  false,
            "Pilih Subjek" =>  false,
        ];

        $model = new JadualPeperiksaan();

        $subjek = Subjek::where('kursus_id', $tetapan->kursus_id)->pluck('nama', 'id');

        $dataTable = $builder->columns([]);

        $lokasi = Bilik::where('is_deleted', 0)->where('status_bilik',0)->pluck('nama_bilik', 'id');

        return view($this->baseView.'add_edit_subjek', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'dataTable','lokasi','subjek'));

    }

    public function store_pilihan_subjek($id, Request $request)
    {
        $validation = $request->validate([
            'subjek'            => 'required',
            'tarikh_peperiksaan'=> 'required',
            'masa_peperiksaan'  => 'required',
            'jumlah_calon'      => 'required',
            'lokasi'            => 'required',
        ],[
            'subjek.required'               => 'Sila pilih subjek',
            'tarikh_peperiksaan.required'   => 'Sila masukkan tarikh peperiksaan',
            'masa_peperiksaan.required'     => 'Sila masukkan masa peperiksaan',
            'jumlah_calon.required'         => 'Sila masukkan jumlah calon',
            'lokasi.required'               => 'Sila pilih lokasi',
        ]);

        JadualPeperiksaan::create([
            'tetapan_peperiksaan_id' => $id,
            'subjek_id'         => $request->subjek,
            'tarikh'            => Carbon::parse($request->tarikh_peperiksaan),
            'masa'              => $request->masa_peperiksaan,
            'bilangan_calon'    => $request->jumlah_calon,
            'lokasi'            => $request->lokasi,
        ]);

        Alert::toast('Subjek berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.index');
    }
}
