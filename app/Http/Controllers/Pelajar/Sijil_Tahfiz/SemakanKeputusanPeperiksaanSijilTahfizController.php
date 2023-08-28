<?php

namespace App\Http\Controllers\Pelajar\Sijil_Tahfiz;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SemakanKeputusanPeperiksaanSijilTahfizController extends Controller
{
    Public function index(Builder $builder, Request $request){
        $title = "Semak Keputusan Peperiksaan Sijil Tahfiz";
        $breadcrumbs = [
            "Pelajar" =>  false,
            "Sijil Tahfiz" =>  false,
            "Semak Keputusan" => false,
        ];

        if (request()->ajax()) {
            if($request->has('maklumat_carian')){
                $query = PemarkahanCalonSijilTahfiz::join('pelajar as p', 'p.id', '=', 'pemarkahan_calon_sijil_tahfizs.pelajar_id')
                    ->where('p.user_id', Auth::id());
            
                $query->where('no_ic','like','%'.$request->maklumat_carian.'%');
            
                $data = $query->select(['p.nama as name', 'pemarkahan_calon_sijil_tahfizs.*']);
            } else {
                $data = [];
            }
            return DataTables::of($data)
            ->addColumn('name', function($data) {
                return $data->name;
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
                $btn = '<a href="'.route('pelajar.sijil_tahfiz.semakan_keputusan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';

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

        return view('pages.pelajar.sijil_tahfiz.semak_keputusan.main', compact('title','breadcrumbs', 'html'));
    }

    public function show($id){
        $title = "Lihat Keputusan";
        $breadcrumbs = [
            "Pelajar" =>  false,
            "Sijil Tahfiz" =>  false,
            "Lihat Keputusan" => false,
        ];

        $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);
        $pelajar = $pemarkahan->pelajar;

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'pemarkahan' => $pemarkahan,
            'pelajar' => $pelajar,
            'id' => $id,
        ];

        return view('pages.pelajar.sijil_tahfiz.semak_keputusan.view', $data);
    }
}
