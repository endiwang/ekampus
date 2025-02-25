<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Keturunan;
use App\Models\Kursus;
use App\Models\Negeri;
use App\Models\Permohonan;
use App\Models\PusatTemuduga;
use App\Models\Sesi;
use App\Models\SubjekSPM;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SenaraiPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Senarai Permohonan';
            $breadcrumbs = [
                'Kemasukan Biasiswa Graduasi' => false,
                'Senarai Permohonan' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Permohonan',
                    'route' => '',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');
            $sesi = Sesi::where('is_deleted', 0)->pluck('nama', 'id');

            if (request()->ajax()) {
                $data = Permohonan::where('is_submitted', 1)->where('is_deleted', 0)->where('is_selected', 0)->where('is_tawaran', 0)->where('is_interview', 0);
                if ($request->has('kursus') && $request->kursus != null) {
                    $data = $data->where('kursus_id', $request->kursus);
                }
                if ($request->has('sesi') && $request->sesi != null) {
                    $data = $data->where('sesi_id', $request->sesi);
                }

                return DataTables::of($data->get())
                    ->addColumn('nama', function ($data) {
                        return $data->nama ?? null;
                    })
                    ->addColumn('kursus', function ($data) {
                        if (! empty($data->kursus_id)) {
                            return $data->kursus->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('tarikh_permohonan', function ($data) {
                        $tarikh_permohonan = Utils::formatDate($data->submitted_date);

                        return $tarikh_permohonan;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'kursus', 'status', 'action', 'tarikh_permohonan'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pemohon', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No. Kad Pengenalan', 'orderable' => false],
                    ['data' => 'kursus',      'name' => 'kursus',         'title' => 'Jenis Permohonan', 'orderable' => false],
                    ['data' => 'tarikh_permohonan',   'name' => 'tarik_permohonan',   'title' => 'Tarikh Permohonan', 'orderable' => false],
                    ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan', 'orderable' => false, 'searchable' => false, 'class' => 'min-w-100px'],

                ])
                ->minifiedAjax();

            return view('pages.pengurusan.kbg.senarai_permohonan.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'kursus', 'sesi'));

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = Permohonan::find($id);
        // dd($data->penjaga);
        try {

            $negeri = Negeri::pluck('nama', 'id');
            $keturunan = Keturunan::where('status', 0)->pluck('nama', 'id');
            $subjek_spm = SubjekSPM::all();
            $pusat_temuduga = PusatTemuduga::where('pusat_pengajian_id', 1)->get()->pluck('nama', 'id');

            $title = 'Maklumat Permohonan';
            $breadcrumbs = [
                'Kemasukan Biasiswa Graduasi' => false,
                'Maklumat Permohonan' => false,
            ];

            $data = Permohonan::find($id);

            return view('pages.pengurusan.kbg.senarai_permohonan.edit', compact('title', 'breadcrumbs', 'data', 'negeri', 'keturunan', 'subjek_spm', 'pusat_temuduga'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    /**
     * Update the specified resource in storage.
     *
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

    public function pilih(Request $request)
    {
        try {

            $permohonan = Permohonan::find($request->id);

            $permohonan->is_selected = 1;
            $permohonan->save();

            Alert::toast('Permohonan telah dipilih!', 'success');

            return redirect()->route('pengurusan.kbg.pengurusan.senarai_permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }
}
