<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Mail\StatusPermohonanBaruSijilTahfiz;
use App\Models\Negeri;
use App\Models\Pemohon;
use App\Models\PermohonanSijilTahfiz;
use App\Models\PusatPeperiksaan;
use App\Models\PusatPeperiksaanNegeri;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanController extends Controller
{
    public function index(Builder $builder){
        $title = "Permohonan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Proses Permohonan" =>  '#',
            "Permohonan" =>  '#',
        ];

        if (request()->ajax()) {
            $data = PermohonanSijilTahfiz::all();
            return DataTables::of($data)
            ->addColumn('permohonan', function($data) {
                return 'Permohonan';

            })
            ->addColumn('tarikh_permohonan', function($data) {
                return Carbon::parse($data->created_at)->format('d/m/Y');

            })
            ->addColumn('status', function($data) {
                if($data->status_tawaran){
                    return '<span class="badge py-3 px-4 fs-7 badge-light-success">Terima Tawaran</span>';
                } else {
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
                }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                if($data->status == 2){
                    $btn .=' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.edit',$data->id).'" class="btn btn-icon btn-success btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-check-circle"></i></a>';
                }

                 return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                // $data->orderBy('id', 'desc');
            })
            ->rawColumns(['tempoh_permohonan','status','action'])
            ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama Pemohon', 'orderable'=> false],
            ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable'=> true],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.main', compact('title','breadcrumbs', 'html'));
    }

    public function show($id){
        $title = "Lihat Permohonan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Proses Permohonan" =>  '#',
            "Lihat Permohonan" =>  '#',
        ];

        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeriSelection = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id',$id)->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeriSelection' => $negeriSelection,
            'permohonan'    => $permohonan,
            'pelajar'   => $permohonan->pelajar,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.view', $data);
    }

    public function edit($id){
        $title = "Lihat Permohonan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Proses Permohonan" =>  '#',
            "Proses Kelayakan Permohonan" =>  '#',
        ];

        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeriSelection = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id',$id)->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeriSelection' => $negeriSelection,
            'permohonan'    => $permohonan,
            'pelajar'   => $permohonan->pelajar,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.edit', $data);
    }

    public function update(Request $request, $id){

        $permohonan = PermohonanSijilTahfiz::where('id',$id)->first();

        DB::beginTransaction();

        try {

            $permohonan->update($request->except('_token'));
            
            $pemohon = Pemohon::where('id', $permohonan->pemohon_id)->first();
            Mail::to($pemohon->email)->send(new StatusPermohonanBaruSijilTahfiz());
            DB::commit();
            Alert::toast('Status kelayakan berjaya dipinda!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Status kelayakan tidak berjaya dipinda!', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.index');
    }
}
