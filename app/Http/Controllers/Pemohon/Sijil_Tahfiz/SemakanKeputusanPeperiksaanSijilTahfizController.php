<?php

namespace App\Http\Controllers\Pemohon\Sijil_Tahfiz;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SemakanKeputusanPeperiksaanSijilTahfizController extends Controller
{
    Public function index(Builder $builder, Request $request){
        if (request()->ajax()) {
            if($request->has('carian')){
                $query = PemarkahanCalonSijilTahfiz::join('pemohon as p', 'p.id', '=', 'pemarkahan_calon_sijil_tahfizs.pemohon_id')
                    ->where('p.id', Auth::guard('pemohon')->user()->id);
            
                $query->where('p.username','like','%'.$request->carian.'%');
            
                $data = $query->select(['pemarkahan_calon_sijil_tahfizs.*']);
            } else {
                $data = [];
            }
            return DataTables::of($data)
            ->addColumn('name', function($data) {
                return $data->permohonanSijilTahfiz->name;
            })
            ->addColumn('total_mark', function($data) {
                return $data->total_mark;
            })
            ->addColumn('pangkat', function($data) {
                return $data->keputusan_peperiksaan;
            })
            ->addColumn('status', function($data) {
                if($data->status_kelulusan){
                    return '<span class="badge py-3 px-4 fs-7 badge-light-success">Lulus</span>';
                } else {
                    return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Gagal</span>';
                }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pemohon.permohonan_sijil_tahfiz.semakan_keputusan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat" target="_blank"><i class="fa fa-eye"></i></a>';
                $btn .= ' <a href="'.route('pemohon.permohonan_sijil_tahfiz.semakan_keputusan_sijil_tahfiz.keputusan_sementara.downloadPdf',$data->id).'" class="btn btn-icon btn-success btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-download"></i></a>';

                return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                // $data->orderBy('id', 'desc');
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
        }

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable'=> false],
            ['data' => 'total_mark', 'name' => 'total_mark', 'title' => 'Markah', 'orderable'=> false],
            ['data' => 'pangkat', 'name' => 'pangkat', 'title' => 'Pangkat', 'orderable'=> false],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
        ])
        ->minifiedAjax();

        return view('pages.pemohon.sijil_tahfiz.semak_keputusan.main', compact('html'));
    }

    public function show($id){
        
        $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pemohon.sijil_tahfiz.semak_keputusan.export_pdf', compact('pemarkahan'))
            ->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function downloadPdf($id){
        $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pemohon.sijil_tahfiz.semak_keputusan.export_pdf', compact('pemarkahan'))
            ->setPaper('a4', 'potrait');

        return $pdf->download('slip_markah(tidak_rasmi).pdf');
    }
}
