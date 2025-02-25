<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\PusatTemuduga;
use App\Models\Sesi;
use App\Models\TetapanPermohonanPelajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // $test = TetapanPermohonanPelajar::find(19);
        // $data = TetapanPermohonanPelajar::first();
        // dd($data->pusat_temuduga);
        if (request()->ajax()) {
            $data = TetapanPermohonanPelajar::select('id', 'kursus_id', 'sesi_id', 'mula_permohonan', 'tutup_permohonan', 'status');

            return DataTables::of($data)
                ->addColumn('kursus', function ($data) {
                    if ($data->kursus == null) {
                        return '';
                    } else {
                        return $data->kursus->nama;
                    }
                })
                ->addColumn('sesi', function ($data) {
                    if ($data->sesi == null) {
                        return '';
                    } else {
                        return $data->sesi->nama;
                    }
                })
                ->addColumn('tempoh_permohonan', function ($data) {
                    return Carbon::parse($data->mula_permohonan)->format('d/m/Y').' - '.Carbon::parse($data->tutup_permohonan)->format('d/m/Y');

                })
                ->addColumn('status_edit', function ($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Buka</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tutup</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2">View</a>';
                    // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                    // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2 mb-1">Dokumen</a><br>';
                    $btn = $btn.'<a href="'.route('pengurusan.pentadbir_sistem.permohonan_pelajar.edit', $data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Pinda</a>';
                    // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Hapus</a>';

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['kursus', 'sesi', 'status_edit', 'tempoh_permohonan', 'action'])
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
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi', 'orderable' => false],
                ['data' => 'tempoh_permohonan', 'name' => 'tempoh_permohonan', 'title' => 'Tempoh Permohonan', 'orderable' => false],
                ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');

        return view('pages.pengurusan.pentadbir_sistem.permohonan_pelajaran.main', compact('dataTable', 'kursus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted', 0)->pluck('nama', 'id');
        $pusat_temuduga = PusatTemuduga::where('pusat_pengajian_id', 1)->get();

        return view('pages.pengurusan.pentadbir_sistem.permohonan_pelajaran.add_new', compact(['kursus', 'sesi', 'pusat_temuduga']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'kursus' => 'required',
            'sesi' => 'required',
            'mula_permohonan' => 'required',
            'tutup_permohonan' => 'required',
            'tutup_pendaftaran' => 'required',
            'mula_semakan_temuduga' => 'required',
            'tutup_semakan_temuduga' => 'required',
            'tajuk_temuduga' => 'required',
            'maklumat_temuduga' => 'required',
            'mula_semakan_tawaran' => 'required',
            'tutup_semakan_tawaran' => 'required',
            'tutup_rayuan' => 'required',
            'tajuk_rayuan' => 'required',
            'mula_semakan_rayuan' => 'required',
            'tutup_semakan_rayuan' => 'required',
            'tajuk_semakan_tawaran' => 'required',
            'maklumat_semakan_tawaran' => 'required',
            'pusat_temuduga' => 'required',
        ], [
            'kursus.required' => 'Sila pilih program pengajian.',
            'sesi.required' => 'Sila pilih sesi pengajian.',
            'mula_permohonan.required' => 'Sila pilih tarikh mula permohonan.',
            'tutup_permohonan.required' => 'Sila pilih tarikh tutup permohonan.',
            'tutup_pendaftaran.required' => 'Sila pilih tarikh tutup pendaftaran.',
            'mula_semakan_temuduga.required' => 'Sila pilih tarikh mula semakan temuduga.',
            'tutup_semakan_temuduga.required' => 'Sila pilih tarikh tutup semakan temuduga.',
            'tajuk_temuduga.required' => 'Sila isi tajuk semakan temuduga.',
            'maklumat_temuduga.required' => 'Sila isi maklumat semakan temuduga.',
            'mula_semakan_tawaran.required' => 'Sila pilih tarikh mula semakan tawaran.',
            'tutup_semakan_tawaran.required' => 'Sila pilih tarikh tutup semakan tawaran.',
            'tutup_rayuan.required' => 'Sila pilih tarikh akhir rayuan.',
            'tajuk_rayuan.required' => 'Sila isi tajuk semakan rayuan.',
            'mula_semakan_rayuan.required' => 'Sila pilih tarikh mula semakan rayuan.',
            'tutup_semakan_rayuan.required' => 'Sila pilih tarikh tutup semakan rayuan.',
            'tajuk_semakan_tawaran.required' => 'Sila isi tajuk semakan tawaran.',
            'maklumat_semakan_tawaran.required' => 'Sila isi maklumat semakan tawaran.',
            'pusat_temuduga.required' => 'Sila pilih pusat temuduga.',
        ]);

        if ($request->has('status_ujian')) {
            $status_ujian = $request->status_ujian;
        } else {
            $status_ujian = 0;
        }

        if ($request->has('status')) {
            $status = $request->status;
        } else {
            $status = 0;
        }

        TetapanPermohonanPelajar::create([
            'kursus_id' => $request->kursus,
            'sesi_id' => $request->sesi,
            'status_ujian' => $status_ujian,
            'status' => $status,
            'mula_permohonan' => Carbon::createFromFormat('d/m/Y', $request->mula_permohonan)->format('Y-m-d'),
            'tutup_permohonan' => Carbon::createFromFormat('d/m/Y', $request->tutup_permohonan)->format('Y-m-d'),
            'tutup_pendaftaran' => Carbon::createFromFormat('d/m/Y', $request->tutup_pendaftaran)->format('Y-m-d'),
            'mula_semakan_temuduga' => Carbon::createFromFormat('d/m/Y', $request->mula_semakan_temuduga)->format('Y-m-d'),
            'tutup_semakan_temuduga' => Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_temuduga)->format('Y-m-d'),
            'tajuk_semakan_temuduga' => $request->tajuk_temuduga,
            'maklumat_semakan_temuduga' => $request->maklumat_temuduga,
            'mula_semakan_tawaran' => Carbon::createFromFormat('d/m/Y', $request->mula_semakan_tawaran)->format('Y-m-d'),
            'tutup_semakan_tawaran' => Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_tawaran)->format('Y-m-d'),
            'tutup_rayuan' => Carbon::createFromFormat('d/m/Y', $request->tutup_rayuan)->format('Y-m-d'),
            'tajuk_semakan_rayuan' => $request->tajuk_rayuan,
            'tutup_rayuan' => Carbon::createFromFormat('d/m/Y', $request->tutup_rayuan)->format('Y-m-d'),
            'mula_semakan_rayuan' => Carbon::createFromFormat('d/m/Y', $request->mula_semakan_rayuan)->format('Y-m-d'),
            'tutup_semakan_rayuan' => Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_rayuan)->format('Y-m-d'),
            'tajuk_semakan_tawaran' => $request->tajuk_semakan_tawaran,
            'maklumat_semakan_tawaran' => $request->maklumat_semakan_tawaran,
            'pusat_temuduga' => json_encode($request->pusat_temuduga),
        ]);

        Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.permohonan_pelajar.index');
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
        $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted', 0)->pluck('nama', 'id');
        $tetapan_permohonan = TetapanPermohonanPelajar::find($id);
        $pusat_temuduga = PusatTemuduga::where('pusat_pengajian_id', 1)->get();

        return view('pages.pengurusan.pentadbir_sistem.permohonan_pelajaran.edit', compact('kursus', 'sesi', 'tetapan_permohonan', 'pusat_temuduga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sesi' => 'required',
            'mula_permohonan' => 'required',
            'tutup_permohonan' => 'required',
            'tutup_pendaftaran' => 'required',
            'mula_semakan_temuduga' => 'required',
            'tutup_semakan_temuduga' => 'required',
            'tajuk_temuduga' => 'required',
            'maklumat_temuduga' => 'required',
            'mula_semakan_tawaran' => 'required',
            'tutup_semakan_tawaran' => 'required',
            'tutup_rayuan' => 'required',
            'tajuk_rayuan' => 'required',
            'mula_semakan_rayuan' => 'required',
            'tutup_semakan_rayuan' => 'required',
            'tajuk_semakan_tawaran' => 'required',
            'maklumat_semakan_tawaran' => 'required',
        ], [
            'sesi.required' => 'Sila pilih sesi pengajian.',
            'mula_permohonan.required' => 'Sila pilih tarikh mula permohonan.',
            'tutup_permohonan.required' => 'Sila pilih tarikh tutup permohonan.',
            'tutup_pendaftaran.required' => 'Sila pilih tarikh tutup pendaftaran.',
            'mula_semakan_temuduga.required' => 'Sila pilih tarikh mula semakan temuduga.',
            'tutup_semakan_temuduga.required' => 'Sila pilih tarikh tutup semakan temuduga.',
            'tajuk_temuduga.required' => 'Sila isi tajuk semakan temuduga.',
            'maklumat_temuduga.required' => 'Sila isi maklumat semakan temuduga.',
            'mula_semakan_tawaran.required' => 'Sila pilih tarikh mula semakan tawaran.',
            'tutup_semakan_tawaran.required' => 'Sila pilih tarikh tutup semakan tawaran.',
            'tutup_rayuan.required' => 'Sila pilih tarikh akhir rayuan.',
            'tajuk_rayuan.required' => 'Sila isi tajuk semakan rayuan.',
            'mula_semakan_rayuan.required' => 'Sila pilih tarikh mula semakan rayuan.',
            'tutup_semakan_rayuan.required' => 'Sila pilih tarikh tutup semakan rayuan.',
            'tajuk_semakan_tawaran.required' => 'Sila isi tajuk semakan tawaran.',
            'maklumat_semakan_tawaran.required' => 'Sila isi maklumat semakan tawaran.',
        ]);

        $tetapan_permohonan = TetapanPermohonanPelajar::find($id);

        if ($request->has('status_ujian')) {
            $status_ujian = $request->status_ujian;
        } else {
            $status_ujian = 0;
        }

        if ($request->has('status')) {
            $status = $request->status;
        } else {
            $status = 0;
        }

        $tetapan_permohonan->sesi_id = $request->sesi;
        $tetapan_permohonan->status_ujian = $status_ujian;
        $tetapan_permohonan->status = $status;
        $tetapan_permohonan->mula_permohonan = Carbon::createFromFormat('d/m/Y', $request->mula_permohonan)->format('Y-m-d');
        $tetapan_permohonan->tutup_permohonan = Carbon::createFromFormat('d/m/Y', $request->tutup_permohonan)->format('Y-m-d');
        $tetapan_permohonan->tutup_pendaftaran = Carbon::createFromFormat('d/m/Y', $request->tutup_pendaftaran)->format('Y-m-d');
        $tetapan_permohonan->mula_semakan_temuduga = Carbon::createFromFormat('d/m/Y', $request->mula_semakan_temuduga)->format('Y-m-d');
        $tetapan_permohonan->tutup_semakan_temuduga = Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_temuduga)->format('Y-m-d');
        $tetapan_permohonan->tajuk_semakan_temuduga = $request->tajuk_temuduga;
        $tetapan_permohonan->maklumat_semakan_temuduga = $request->maklumat_temuduga;
        $tetapan_permohonan->mula_semakan_tawaran = Carbon::createFromFormat('d/m/Y', $request->mula_semakan_tawaran)->format('Y-m-d');
        $tetapan_permohonan->tutup_semakan_tawaran = Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_tawaran)->format('Y-m-d');
        $tetapan_permohonan->tutup_rayuan = Carbon::createFromFormat('d/m/Y', $request->tutup_rayuan)->format('Y-m-d');
        $tetapan_permohonan->tajuk_semakan_rayuan = $request->tajuk_rayuan;
        $tetapan_permohonan->tutup_rayuan = Carbon::createFromFormat('d/m/Y', $request->tutup_rayuan)->format('Y-m-d');
        $tetapan_permohonan->mula_semakan_rayuan = Carbon::createFromFormat('d/m/Y', $request->mula_semakan_rayuan)->format('Y-m-d');
        $tetapan_permohonan->tutup_semakan_rayuan = Carbon::createFromFormat('d/m/Y', $request->tutup_semakan_rayuan)->format('Y-m-d');
        $tetapan_permohonan->tajuk_semakan_tawaran = $request->tajuk_semakan_tawaran;
        $tetapan_permohonan->maklumat_semakan_tawaran = $request->maklumat_semakan_tawaran;
        $tetapan_permohonan->save();

        Alert::toast('Tetapan Baru Berjaya Dikemas kini', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.permohonan_pelajar.index');
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

    public function fetchSesi(Request $request)
    {
        $sesi = Sesi::select('id', 'nama as text')->where('kursus_id', $request->kursus_id)->where('is_deleted', 0)->get();

        return $sesi;
    }
}
