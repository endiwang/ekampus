<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PermohonanSijilTahfiz;
use App\Models\TemplateSijilTahfiz;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PenerimaSijilTahfizController extends Controller
{
    public function index(Builder $builder, Request $request){
        $title = 'Senarai Penerima Sijil';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => false,
            'Pengurusan Sijil Tahfiz' => false,
            'Senarai Penerima Sijil' => false,
        ];

        if (request()->ajax()) {
            $query = PemarkahanCalonSijilTahfiz::query();
            if ($request->has('carian')) {
                $query->join('permohonan_sijil_tahfizs as pst', 'pst.id', '=', 'pemarkahan_calon_sijil_tahfizs.permohonan_id')
                    ->join('pemohon as p', 'p.id', '=', 'pemarkahan_calon_sijil_tahfizs.pemohon_id')
                    ->where(function($q) use ($request){
                        $q->where('pst.name', 'LIKE', '%'.$request->carian.'%');
                        $q->orWhere('p.username', 'LIKE', '%'.$request->carian.'%');
                    });
            }
            $data = $query->where('pemarkahan_calon_sijil_tahfizs.approval', 1)
                ->where('pemarkahan_calon_sijil_tahfizs.status_kelulusan', 1);
                // ->select(['pst.name as name', 'pemarkahan_calon_sijil_tahfizs.status_terima_sijil as status_terima_sijil']);

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    return $data->permohonanSijilTahfiz->name ?? null;
                })
                ->addColumn('status', function ($data) {
                    if(!empty($data->permohonanSijilTahfiz->template_sijil_tahfiz_id)){
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Dijana</span>';
                    } else {
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Belum Dijana</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    if(!empty($data->permohonanSijilTahfiz->template_sijil_tahfiz_id)){
                        $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil_tahfiz.penerima_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat" target="blank"><i class="fa fa-eye"></i></a>';
                        $btn .=' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil_tahfiz.penerima_sijil_tahfiz.download_sijil',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pengesahan Keputusan"><i class="fa fa-download"></a>';
                    } else {
                        $btn =' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil_tahfiz.penerima_sijil_tahfiz.jana_sijil',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pengesahan Keputusan"><i class="fa fa-certificate"></a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('pemarkahan_calon_sijil_tahfizs.id', 'asc');
                })
                ->rawColumns(['status', 'action', 'nama'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Calon', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'kelas', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil.penerima_sijil_tahfiz.main', compact('title', 'breadcrumbs', 'dataTable'));
    }

    public function show($id){
        $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);
        $template_sijil_tahfiz_id = PermohonanSijilTahfiz::where('id', $pemarkahan->permohonan_id)->first(['template_sijil_tahfiz_id']);
        $template_sijil = TemplateSijilTahfiz::find($template_sijil_tahfiz_id)->first();

        $nama = $pemarkahan->permohonanSijilTahfiz->name;
        $kadpengenalan = $pemarkahan->pemohon->username;

        preg_match_all('/{([^}]*)}/', $template_sijil->template, $matches);

        $message_body = '';
        $message_body .= $template_sijil->template;
        foreach ($matches[0] as $pholder) {
            if ($pholder == '{nama}') {
                $message_body = str_replace($pholder, $nama, $message_body);
            }

            if ($pholder == '{kadpengenalan}') {
                $message_body = str_replace($pholder, $kadpengenalan, $message_body);
            }
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil.penerima_sijil_tahfiz.export_pdf', compact('message_body'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function jana_sijil($id){

        DB::beginTransaction();
        try {

            $template_sijil = TemplateSijilTahfiz::where('status', 1)->latest()->first();
            if(!empty($template_sijil)){
                $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);
                PermohonanSijilTahfiz::where('id', $pemarkahan->permohonan_id)->update(['template_sijil_tahfiz_id'=>$template_sijil->id, 'tarikh_jana_sijil' => Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d')]);

                Alert::toast('Sijil Tahfiz Telah Berjaya Dijana', 'success');
                DB::commit();
            } else {
                Alert::toast('Tiada Template Sijil Tahfiz Yang Aktif Untuk DIgunakan', 'error');
            }
            

        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            Alert::toast('Sijil Tahfiz Tidak Berjaya Dijana', 'error');
        }
        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil_tahfiz.penerima_sijil_tahfiz.index');
    }

    public function download_sijil($id){
        $pemarkahan = PemarkahanCalonSijilTahfiz::find($id);
        $template_sijil_tahfiz_id = PermohonanSijilTahfiz::where('id', $pemarkahan->permohonan_id)->first(['template_sijil_tahfiz_id']);
        $template_sijil = TemplateSijilTahfiz::find($template_sijil_tahfiz_id)->first();

        $nama = $pemarkahan->permohonanSijilTahfiz->name;
        $kadpengenalan = $pemarkahan->pemohon->username;

        preg_match_all('/{([^}]*)}/', $template_sijil->template, $matches);

        $message_body = '';
        $message_body .= $template_sijil->template;
        foreach ($matches[0] as $pholder) {
            if ($pholder == '{nama}') {
                $message_body = str_replace($pholder, $nama, $message_body);
            }

            if ($pholder == '{kadpengenalan}') {
                $message_body = str_replace($pholder, $kadpengenalan, $message_body);
            }
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil.penerima_sijil_tahfiz.export_pdf', compact('message_body'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sijil_tahfiz.pdf');
    }
    
}
