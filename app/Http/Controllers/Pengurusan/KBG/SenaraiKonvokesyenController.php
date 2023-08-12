<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Konvo;
use App\Models\KonvoPelajar;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\Sesi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SenaraiKonvokesyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        // try {

        $title = 'Maklumat Majlis Konvokesyen';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Maklumat Majlis Konvokesyen' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Maklumat Majlis Konvokesyen',
                'route' => route('pengurusan.kbg.konvokesyen.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = Konvo::where('is_deleted', 0)->get();

            return DataTables::of($data)
                ->addColumn('tajuk_pusat_konvo', function ($data) {

                    $info = '<p>'.$data->tajuk_konvo.'<br/>'.$data->nama_tempat.'</p>';

                    return $info;
                })
                ->addColumn('tarikh', function ($data) {

                    $tarikh = Utils::formatDate($data->tarikh);
                    if ($data->status == 0) {
                        $status = 'Penyediaan Maklumat';
                    } elseif ($data->status == 1) {
                        $status = 'Semakan Oleh Pelajar';
                    } elseif ($data->status == 2) {
                        $status = 'Telah Selesai';
                    }
                    $info = '<p>'.$tarikh.'<br/>'.$status.'</p>';

                    return $info;
                })
                ->addColumn('masa', function ($data) {

                    $info = '<p>'.$data->masa.' '.$data->waktu.'</p>';

                    return $info;
                })
                ->addColumn('bilangan_pelajar', function ($data) {

                    $jumlah = KonvoPelajar::where('konvo_id', $data->id)->get()->count();
                    // $info = '<p>' . $data->masa . ' '.$data->waktu.'</p>';

                    return $jumlah;
                })
                ->addColumn('bilangan_pelajar_hadir', function ($data) {

                    $jumlah = KonvoPelajar::where('konvo_id', $data->id)->where('kehadiran', 1)->get()->count();
                    // $info = '<p>' . $data->masa . ' '.$data->waktu.'</p>';

                    return $jumlah;
                })
                ->addColumn('action', function ($data) {
                    return '

                            <a href="'.route('pengurusan.kbg.konvokesyen.show', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tanbah Pelajar">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.konvokesyen.export_senarai', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Senarai">
                                <i class="fa fa-file-circle-check"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon', $data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="">
                                <i class="fa fa-close"></i>
                            </a>';

                })
                ->addIndexColumn()
                ->rawColumns(['tajuk_pusat_konvo', 'tarikh', 'action', 'masa'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'class' => 'min-w-10px'],
                ['data' => 'tajuk_pusat_konvo',      'name' => 'tajuk_pusat_konvo',           'title' => 'Tajuk & Pusat Konvokesyen', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh',      'name' => 'tarikh',           'title' => 'Tarikh', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'masa',      'name' => 'mas',           'title' => 'Masa', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bilangan_pelajar',      'name' => 'bilangan_pelajar',           'title' => 'Bilangan Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bilangan_pelajar_hadir',      'name' => 'bilangan_pelajar_hadir',           'title' => 'Pengesahan Kehadir	', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action',              'name' => 'action',                   'title' => 'Tindakan', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-10px'],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.kbg.senarai_konvokesyen.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
        $title = 'Penambahan Maklumat Konvokesyen';
        $page_title = 'Penambahan Maklumat Konvokesyen';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Maklumat Konvokesyen' => false,
            'Tambah Maklumat' => false,
        ];

        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted', 0)->pluck('nama', 'id');

        return view('pages.pengurusan.kbg.senarai_konvokesyen.add_new', compact('title', 'breadcrumbs', 'page_title', 'kursus', 'sesi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'tajuk_konvo' => 'required',
            'tarikh' => 'required',
            'masa' => 'required',
            'waktu' => 'required',
            'nama_tempat' => 'required',
            'alamat_tempat' => 'required',
            'tarikh_surat' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama kalendar akademik',
            'tarikh.required' => 'Sila masukkan tarikh konvokesyen',
            'masa.required' => 'Sila masukkan masa konvokesyen',
            'waktu.required' => 'Sila masukkan waktu',
            'nama_tempat.required' => 'Sila masukkan nama tempat konvokesyen',
            'alamat_tempat.required' => 'Sila masukkan alamat tempat konvokesyen',
            'tarikh_surat.required' => 'Sila masukkan tarikh surat',
            'status.required' => 'Sila pilih status rekod',
        ]);

        Konvo::create([
            'tajuk_konvo' => $request->tajuk_konvo,
            'tarikh' => Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d'),
            'masa' => $request->masa,
            'waktu' => $request->waktu,
            'nama_tempat' => $request->nama_tempat,
            'alamat_konvo' => $request->alamat_tempat,
            'tarikh_cetakan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat)->format('Y-m-d'),
            'status' => $request->status,
        ]);

        Alert::toast('Maklumat konvokesyen berjaya ditambah!', 'success');

        return redirect()->route('pengurusan.kbg.pengurusan.konvokesyen.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Builder $builder, $id)
    {
        $konvo = Konvo::find($id);
        $title = 'Penambahan Maklumat Konvokesyen';
        $page_title = 'Penambahan Maklumat Konvokesyen';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Maklumat Konvokesyen' => false,
            'Tambah Maklumat' => false,
        ];

        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted', 0)->pluck('nama', 'id');

        if (request()->ajax()) {
            $data = KonvoPelajar::where('konvo_id', $id)->with('pelajar')->get();

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    $data = '<p style="margin-bottom:unset !important">'.$data->pelajar->nama.'<br/><p style="margin-bottom:unset !important">'.$data->pelajar->no_ic.'<span style="font-weight:bold">&nbsp['.$data->pelajar->no_matrik.'] </span></p>';

                    return $data;
                })
                ->addColumn('kursus_id', function ($data) {
                    return $data->pelajar->kursus->nama ?? null;
                })
                ->addColumn('sesi_id', function ($data) {
                    if ($data->pelajar->sesi) {
                        return '<p style="text-align:center">'.$data->pelajar->sesi->nama.'</p>';
                    } else {
                        return '';
                    }

                })
                ->addColumn('cgpa', function ($data) {
                    if ($data->pelajar->mata_akhir == null) {
                        $cgpa = 'CGPA : 0.00';
                    } else {
                        $cgpa = 'CGPA : '.$data->pelajar->mata_akhir;
                    }

                    return $cgpa;
                })
                ->addColumn('hadir', function ($data) {
                    if ($data->kehadiran == 1) {
                        $info = '<button disabled type="button" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Pemarkahan Temuduga">
                                <i class="fa fa-check"></i>
                            </button>';
                    } else {
                        $info = '';
                    }

                    return $info;
                })
                ->addColumn('surat', function ($data) {

                    return '<button class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Pemarkahan Temuduga">
                            <i class="fa fa-print"></i>
                        </button>';
                })
                ->addColumn('alumni', function ($data) {
                    if ($data->pelajar->is_berhenti == 1) {
                        $info = '<button disabled type="button" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Pemarkahan Temuduga">
                                <i class="fa fa-check"></i>
                            </button>';
                    } else {
                        $info = '';
                    }

                    return $info;
                })
                ->addIndexColumn()
                ->rawColumns(['no_ic', 'status', 'hadir', 'sesi_id', 'nama', 'surat', 'alumni'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Pengajian', 'orderable' => false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                ['data' => 'cgpa', 'name' => 'cgpa', 'title' => 'CGPA', 'orderable' => false],
                ['data' => 'hadir', 'name' => 'hadir', 'title' => 'Hadir', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ['data' => 'surat', 'name' => 'surat', 'title' => 'Surat', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ['data' => 'alumni', 'name' => 'alumni', 'title' => 'Alumni', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.kbg.senarai_konvokesyen.show', compact('title', 'breadcrumbs', 'page_title', 'kursus', 'sesi', 'konvo', 'dataTable'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'tajuk_konvo' => 'required',
            'tarikh' => 'required',
            'masa' => 'required',
            'waktu' => 'required',
            'nama_tempat' => 'required',
            'alamat_tempat' => 'required',
            'tarikh_surat' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama kalendar akademik',
            'tarikh.required' => 'Sila masukkan tarikh konvokesyen',
            'masa.required' => 'Sila masukkan masa konvokesyen',
            'waktu.required' => 'Sila masukkan waktu',
            'nama_tempat.required' => 'Sila masukkan nama tempat konvokesyen',
            'alamat_tempat.required' => 'Sila masukkan alamat tempat konvokesyen',
            'tarikh_surat.required' => 'Sila masukkan tarikh surat',
            'status.required' => 'Sila pilih status rekod',
        ]);

        Konvo::updateOrCreate(
            [
                'id' => $id,
            ],
            [
                'tajuk_konvo' => $request->tajuk_konvo,
                'tarikh' => Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d'),
                'masa' => $request->masa,
                'waktu' => $request->waktu,
                'nama_tempat' => $request->nama_tempat,
                'alamat_konvo' => $request->alamat_tempat,
                'tarikh_cetakan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat)->format('Y-m-d'),
                'status' => $request->status,
            ]);

        Alert::toast('Maklumat konvokesyen berjaya dikemaskini!', 'success');

        return redirect()->route('pengurusan.kbg.pengurusan.konvokesyen.index');

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

    public function pilih_pelajar($id)
    {
        $title = 'Pilih Pelajar';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Senarai Maklumat Pemilihan Pelajar	' => false,
            'Maklumat Tawaran' => false,
            'Pilih Pelajar' => false,
        ];

        $konvo = Konvo::find($id);

        return view('pages.pengurusan.kbg.senarai_konvokesyen.pilih_pelajar', compact('konvo', 'title', 'breadcrumbs'));
    }

    public function pilih_pelajar_api($id)
    {
        // if (request()->ajax()) {
        $konvo = Konvo::find($id);

        // $data = TemudugaMarkah::where('tawaran_id',$id);

        $selected_student = KonvoPelajar::select('pelajar_id')->get()->pluck('pelajar_id');
        $data = Pelajar::whereNotIn('id', $selected_student)->where('is_deleted', 0)->where('is_gantung', 0)->where('is_berhenti', 0)->whereHas('sesi')->whereHas('kursus')->with('sesi', 'kursus')->get();

        // $data = Permohonan::where('kursus_id', $proses_temuduga->kursus_id)->where('is_deleted',0)->where('is_submitted',1)->where('is_selected',1)->where('is_tawaran',0)->where('is_interview',0)->where('sesi_id',$sesi->id)->get();

        return Datatables::of($data)
            // ->addIndexColumn()
            // ->rawColumns(['paid','status','amount','category','application_date','action','checkbox'])
            ->make(true);
        // }
    }

    public function store_pelajar(Request $request)
    {
        $konvo = Konvo::find($request->tawaran_id);
        foreach ($request->ids as $id) {
            $pelajar = Pelajar::find($id);

            KonvoPelajar::create([
                'konvo_id' => $request->konvo_id,
                'pelajar_id' => $id,
                'kursus_id' => $pelajar->kursus_id,
            ]);
        }
        Alert::success('Pemohonan berjaya dipilih');

        return ['success' => true];
    }

    public function export_senarai($id)
    {

        $konvo = Konvo::find($id);
        // $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();
        $title = 'Senarai Pelajar';

        $datas = $this->exportDataProcess($id);
        $view_file = 'pages.pengurusan.kbg.senarai_konvokesyen.export_pdf';
        $orientation = 'landscape';

        return Utils::pdfGenerate($title, $datas, $view_file, $orientation);
    }

    private function exportDataProcess($id)
    {

        $konvo = Konvo::find($id);
        $pelajar = KonvoPelajar::where('konvo_id', $id)->with('pelajar')->get();

        $datas = [
            'konvo' => $konvo,
            'pelajar' => $pelajar,
        ];

        return $datas;

    }
}
