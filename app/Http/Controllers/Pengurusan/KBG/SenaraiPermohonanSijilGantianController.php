<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use App\Models\Alumni\PermohonanSijilGanti;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SenaraiPermohonanSijilGantianController extends Controller
{
    public function index(Builder $builder)
    {
        $title = 'Permohonan Sijil Gantian';
        $breadcrumbs = [
            'Kemasukan Biasiswa Graduasi' => false,
            'Permohonan Sijil Gantian' => false,
        ];

        $buttons = [

        ];

        if (request()->ajax()) {
            $data = PermohonanSijilGanti::all();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Baru Diterima</span>';

                        case 1:
                            return '<span class="badge badge-success">Selesai</span>';

                        case 2:
                            return '<span class="badge badge-danger">Ditolak</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                    <a href="' . route('pengurusan.kbg.pengurusan.permohonan_sijil_gantian.edit', $data->id) . '" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                    <i class="fa fa-eye"></i>
                    </a>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan', 'orderable' => false],
                ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.kbg.permohonan_sijil_gantian.index', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    public function edit($id)
    {
        // try {
        $title = 'Sijil Ganti';
        $page_title = 'Maklumat Permohonan Sijil Ganti';
        $action = route('pengurusan.kbg.pengurusan.permohonan_sijil_gantian.update', $id);
        $breadcrumbs = [
            'Alumni' => false,
            'Permohonan' => false,
            'Sijil Ganti' => route('alumni.permohonan.sijil_ganti.index'),
            'Maklumat Permohonan Sijil Ganti' => false,
        ];

        $data = PermohonanSijilGanti::find($id);

        return view('pages.pengurusan.kbg.permohonan_sijil_gantian.edit', compact('title', 'action', 'breadcrumbs', 'page_title', 'data'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    public function update(Request $request, $id)
    {
        $data = PermohonanSijilGanti::find($id);
        $data->status = $request->status;
        $data->approved_by = Auth::user()->id;
        $data->save();

        Alert::toast('Permohonan Sijil Ganti berjaya dikemaskini', 'success');

        return redirect()->route('pengurusan.kbg.pengurusan.permohonan_sijil_gantian.index');
    }
}