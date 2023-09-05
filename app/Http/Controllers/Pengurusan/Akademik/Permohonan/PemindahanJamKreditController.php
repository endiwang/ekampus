<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPindahJamKredit;
use FFI\Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use View;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PemindahanJamKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {
            $title = 'Pelepasan Kuliah';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Pemindahan Jam Kredit' => false,
            ];


            $data = PermohonanPindahJamKredit::get();

            if (request()->ajax()) {
                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        return $data->pelajar->nama;
                    })
                    ->addColumn('tarikh', function ($data) {
                        return date('d/m/Y', strtotime($data->created_at));
                    })
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama;
                    })
                    ->addColumn('sesi', function ($data) {
                        return !empty($data->sesi) ? $data->sesi->nama : '-';
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge badge-primary">Baru diterima</span>';

                            case 1:
                                return '<span class="badge badge-success">Selesai</span>';

                            case 2:
                                return '<span class="badge badge-danger">Ditolak</span>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="' . route('pengurusan.akademik.permohonan.pemindahan_jam_kredit.show', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    // ->order(function ($data) {
                    //     $data->orderBy('id', 'desc');
                    // })
                    ->rawColumns(['nama', 'kursus', 'tarikh', 'sesi', 'status', 'action'])
                    ->toJson();
            }


            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pemohon', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.pengurusan.akademik.permohonan.pemindahan_jam_kredit.main', compact('title', 'breadcrumbs', 'dataTable'));

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
     * @param  \Illuminate\Http\Request  $request
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
        try {

            $title = 'Pemindahan Jam Kredit';
            $page_title = 'Maklumat Permohonan Pemindahan Jam Kredit';
            $action = route('pengurusan.akademik.permohonan.pemindahan_jam_kredit.update', $id);
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Pemindahan Jam Kredit' => route('pengurusan.akademik.permohonan.pemindahan_jam_kredit.index'),
                'Maklumat Pemidahan Jam Kredit' => false,
            ];

            $buttons = [
                [
                    'title' => 'Biodata Pelajar',
                    'route' => route('pengurusan.akademik.pengurusan.aktiviti_pdp.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa-solid fa-circle-info',
                ],
            ];

            $data = PermohonanPindahJamKredit::find($id);

            $statuses = [
                0 => 'Baru diterima',
                1 => 'Lulus',
                2 => 'Tolak',
            ];

            return view('pages.pengurusan.akademik.permohonan.pemindahan_jam_kredit.show', compact('title', 'breadcrumbs', 'page_title', 'action', 'data', 'buttons', 'statuses'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        $current_user = auth()->user();

        $permohonan = PermohonanPindahJamKredit::find($id);
        $permohonan->status = $request->status;
        $permohonan->updated_by = $current_user->id;
        $permohonan->save();

        Alert::toast('Permohonan Pindah Jam Kredit Berjaya Dikemaskini', 'success');

        return redirect()->route('pengurusan.akademik.permohonan.pemindahan_jam_kredit.index');
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