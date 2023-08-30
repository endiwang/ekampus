<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\Negeri;
use App\Models\VenuePeperiksaanSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class VenuePeperiksaanSijilTahfizController extends Controller
{
    public function index(Builder $builder){
        $title = "Tetapan Venue Peperiksaan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  false,
            "Pengurusan Sijil Tahfiz" =>  false,
            "Tetapan Venue Peperiksaan Sijil Tahfiz" =>  false,
        ];

        if (request()->ajax()) {
            $data = Negeri::all();
            return DataTables::of($data)
            ->addColumn('address', function($data){
                return $data->venuePeperiksaanSijilTahfiz->address ?? '';
            })
            ->addColumn('status_edit', function($data) {
                switch ($data->venuePeperiksaanSijilTahfiz->status ?? 0) {
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Buka</span>';
                      break;
                    case 0:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tutup</span>';
                    default:
                      return '';
                  }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.venue_peperiksaan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                $btn .=' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.venue_peperiksaan_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';

                 return $btn;
            })
            ->addIndexColumn()
            // ->order(function ($data) {
            //     $data->orderBy('id', 'desc');
            // })
            ->rawColumns(['address','status_edit','action'])
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
            ['data' => 'nama', 'name' => 'name', 'title' => 'Negeri', 'orderable'=> true],
            ['data' => 'address', 'name' => 'address', 'title' => 'Venue Peperiksaan', 'orderable'=> true],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.venue_peperiksaan_sijil_tahfiz.main', compact('title','breadcrumbs', 'html'));
    }

    public function edit($id){
        $title = "Tetapan Venue Peperiksaan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  false,
            "Pengurusan Sijil Tahfiz" =>  false,
            "Tetapan Venue Peperiksaan Sijil Tahfiz" =>  false,
            "Pinda" => false,
        ];

        $venue = VenuePeperiksaanSijilTahfiz::where('negeri_id', $id)->first();
        $negeri = Negeri::find($id);

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'venue' => $venue,
            'negeri' => $negeri,
            'id' => $id,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.venue_peperiksaan_sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id){

        $validated = $request->validate([
            'address'  => 'required',
        ],[
            'address.required' => 'Sila masukkan alamat penuh lokasi peperiksaan sijil tahfiz.',
        ]);

        if(!$request->has('status')){
            $request['status'] = 0;
        }
        DB::beginTransaction();

        try {
            //check if venue already created
            $venue = VenuePeperiksaanSijilTahfiz::where('negeri_id', $id)->first();
            if(empty($venue)){
                $request['negeri_id'] = $id;
                VenuePeperiksaanSijilTahfiz::create($request->except('_token', '_method')); 
            } else {
                VenuePeperiksaanSijilTahfiz::where('negeri_id', $id)->update($request->except('_token', '_method'));
            }

            Alert::toast('Venue Telah Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            dd($e);
            Alert::toast('Venue Tidak Berjaya Ditambah', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.venue_peperiksaan_sijil_tahfiz.index');

    }
}
