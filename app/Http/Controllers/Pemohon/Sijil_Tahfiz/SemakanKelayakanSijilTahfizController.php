<?php

namespace App\Http\Controllers\Pemohon\Sijil_Tahfiz;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSijilTahfiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SemakanKelayakanSijilTahfizController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        if (request()->ajax()) {
            if ($request->has('carian')) {
                $query = PermohonanSijilTahfiz::join('pemohon as p', 'p.id', '=', 'permohonan_sijil_tahfizs.pemohon_id')
                    ->where('p.id', Auth::guard('pemohon')->user()->id);

                $query->where('p.username', 'like', '%'.$request->maklumat_carian.'%');

                $data = $query->select(['permohonan_sijil_tahfizs.*']);
            } else {
                $data = [];
            }

            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    return Carbon::parse($data->created_at)->format('d/m/Y');
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Layak</span>';
                            break;
                        case 2:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Layak</span>';
                        default:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                    }
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    // $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status'])
                ->toJson();
        }

        $html = $builder
            ->parameters([
                // 'language' => '{ "lengthMenu": "Show _MENU_", }',
                // 'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
            ])
            ->minifiedAjax();

        return view('pages.pemohon.sijil_tahfiz.semak_permohonan.main', compact('html'));
    }

    public function show($id)
    {
        $title = 'Lihat Keputusan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Sijil Tahfiz' => false,
            'Lihat Keputusan' => false,
        ];

        $permohonan = PermohonanSijilTahfiz::find($id);
        $pelajar = $permohonan->pelajar;

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'permohonan' => $permohonan,
            'pelajar' => $pelajar,
            'id' => $id,
        ];

        return view('pages.pelajar.sijil_tahfiz.semak_permohonan.view', $data);
    }
}
