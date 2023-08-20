<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PengesahanMarkahSijilTafiz extends Controller
{
    public function index(Builder $builder){
        $title = "Peperiksaan & Pemarkahan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Peperiksaan & Pemarkahan" =>  '#',
            "Calon Sijil Tahfiz" => '#',
        ];

        if (request()->ajax()) {
            $data = PemarkahanCalonSijilTahfiz::where('status_hadir_ujian_shafawi', 1)
            ->where('status_hadir_ujian_tahriri', 1)
            ->where('status_hadir_ujian_pengetahuan_islam', 1)
            ->where('approval',0)
            ->get();

            return DataTables::of($data)
            ->addColumn('nama_pemohon', function($data) {
                return $data->pelajar->nama;

            })
            ->addColumn('no_id', function($data) {
                return $data->pelajar->no_ic;

            })
            ->addColumn('action', function($data){
                $btn = '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Ditemuduga</span>';
                $btn =' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.pengesahan_markah_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon-primary btn-text-primary btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i>Temuduga Syafawi</a>';
                   

                return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                // $data->orderBy('id', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
        }

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'nama_pemohon', 'name' => 'name', 'title' => 'Nama Pemohon', 'orderable'=> false],
            ['data' => 'no_id', 'name' => 'no_id', 'title' => 'No Kad Pengenalan', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.peperiksaan_pemarkahan.pengesahan_markah_sijil_tahfiz.main', compact('title','breadcrumbs', 'html'));
    }

    public function edit($id){
        $title = "Pemarkahan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  false,
            "Peperiksaan & Pemarkahan" =>  false,
            "Pemarkahan Sijil Tahfiz" => false,
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

        return view('pages.pengurusan.pengajian_sepanjang_hayat.peperiksaan_pemarkahan.pengesahan_markah_sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id){
        DB::beginTransaction();

        try {
            if($request->has('approval')){
                $request['approval_staff_id'] = Auth::id();
                PemarkahanCalonSijilTahfiz::where('id', $id)->update($request->except('_token', '_method'));
            }

            Alert::toast('Markah Telah Berjaya Disahkan', 'success');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Markah Tidak Berjaya Disahkan', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.pengesahan_markah_sijil_tahfiz.index');
    }
}
