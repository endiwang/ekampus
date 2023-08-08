<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PusatTemuduga;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use App\Models\Zon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanPeperiksaanSijilTahfizController extends Controller
{
    public function index(Builder $builder){
        $title = "Tetapan Sesi Peperiksaan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Pengurusan Sijil Tahfiz" =>  '#',
            "Tetapan Sesi Peperiksaan Sijil Tahfiz" =>  '#',
        ];
        $buttons = [
            [
                'title' => "Tambah",
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanPeperiksaanSijilTahfiz::all();
            return DataTables::of($data)
            ->addColumn('tempoh_permohonan', function($data) {
                return Carbon::parse($data->tarikh_permohonan_dibuka)->format('d/m/Y'). ' - ' .Carbon::parse($data->tarikh_permohonan_ditutup)->format('d/m/Y');

            })
            ->addColumn('status_edit', function($data) {
                switch ($data->status) {
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
                $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                $btn .=' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                $btn .=' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.destroy',$data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                 return $btn;
            })
            ->addIndexColumn()
            // ->order(function ($data) {
            //     $data->orderBy('id', 'desc');
            // })
            ->rawColumns(['tempoh_permohonan','status_edit','action'])
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
            ['data' => 'siri', 'name' => 'siri', 'title' => 'Siri', 'orderable'=> true],
            ['data' => 'tahun', 'name' => 'tahun', 'title' => 'Tahun', 'orderable'=> false],
            ['data' => 'tempoh_permohonan', 'name' => 'tempoh_permohonan', 'title' => 'Tempoh Permohonan', 'orderable'=> false],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.main', compact('title','breadcrumbs', 'html', 'buttons'));
    }

    public function create(){
        $title = "Tambah Tetapan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Pengurusan Sijil Tahfiz" =>  '#',
            "Tetapan Sesi Peperiksaan Sijil Tahfiz" =>  '#',
            "Tambah Tetapan" =>  '#',
        ];

        $lokasi_peperiksaan = Zon::all();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'lokasi_peperiksaan' => $lokasi_peperiksaan,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.add_new', $data);

    } 

    public function store(Request $request){
        if(!$request->has('lokasi')){
            $request['lokasi'] = null;
        }

        $validated = $request->validate([
            'siri'                      => 'required',
            'tarikh_permohonan_dibuka'  => 'required',
            'tarikh_permohonan_ditutup' => 'required',
            'lokasi'                    => 'required',
        ],[
            'siri.required'                         => 'Sila masukkan siri peperiksaan.',
            'tarikh_permohonan_dibuka.required'     => 'Sila pilih tarikh mula permohonan.',
            'tarikh_permohonan_ditutup.required'    => 'Sila pilih tarikh tutup permohonan.',
            'lokasi.required'                       => 'Sila pilih pusat temuduga',
        ]);

        if($request->has('status')){
            $status = $request->status;
        }else{
            $status = 0;
        }

        DB::beginTransaction();

        try {
            TetapanPeperiksaanSijilTahfiz::create([
                'siri' => $request->siri,
                'tahun' => Carbon::createFromFormat('m/d/Y', $request->tarikh_permohonan_dibuka)->format('Y'),
                'status' => $status,
                'tarikh_permohonan_dibuka'  => Carbon::createFromFormat('d/m/Y',$request->tarikh_permohonan_dibuka)->format('Y-m-d'),
                'tarikh_permohonan_ditutup' => Carbon::createFromFormat('d/m/Y',$request->tarikh_permohonan_ditutup)->format('Y-m-d'),
                'lokasi_peperiksaan'        => json_encode($request->lokasi),
                'created_by'    => Auth::id(),
            ]);
    
            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }
        
        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index');
    }

    public function show($id){
        $tetapan = TetapanPeperiksaanSijilTahfiz::find($id);
        $title = "Lihat Tetapan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Pengurusan Sijil Tahfiz" =>  '#',
            "Tetapan Sesi Peperiksaan Sijil Tahfiz" =>  '#',
            "Lihat Tetapan" =>  '#',
        ];

        $lokasi_peperiksaan = Zon::all();

        $data = [
            'id' => $id,
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'lokasi_peperiksaan' => $lokasi_peperiksaan,
            'tetapan' => $tetapan
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.view', $data);
    }

    public function edit($id){
        $title = "Pinda Tetapan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Pengurusan Sijil Tahfiz" =>  '#',
            "Tetapan Sesi Peperiksaan Sijil Tahfiz" =>  '#',
            "Pinda Tetapan" =>  '#',
        ];

        $lokasi_peperiksaan = Zon::all();

        $tetapan = TetapanPeperiksaanSijilTahfiz::find($id);
        $data = [
            'id' => $id,
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'lokasi_peperiksaan' => $lokasi_peperiksaan,
            'tetapan' => $tetapan
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.edit', $data);

    }

    public function update(Request $request, $id){
        
        $validated = $request->validate([
            'siri'                      => 'required',
            'tarikh_permohonan_dibuka'  => 'required',
            'tarikh_permohonan_ditutup' => 'required',
            'lokasi'                    => 'required',
        ],[
            'siri.required'                         => 'Sila masukkan siri peperiksaan.',
            'tarikh_permohonan_dibuka.required'     => 'Sila pilih tarikh mula permohonan.',
            'tarikh_permohonan_ditutup.required'    => 'Sila pilih tarikh tutup permohonan.',
            'lokasi.required'                       => 'Sila pilih pusat temuduga',
        ]);

        if($request->has('status')){
            $status = $request->status;
        }else{
            $status = 0;
        }

        DB::beginTransaction();

        try {
            $tetapan = TetapanPeperiksaanSijilTahfiz::find($id);
            $tetapan->update([
                'siri' => $request->siri,
                'tahun' => Carbon::createFromFormat('m/d/Y', $request->tarikh_permohonan_dibuka)->format('Y'),
                'status' => $status,
                'tarikh_permohonan_dibuka'  => Carbon::createFromFormat('d/m/Y',$request->tarikh_permohonan_dibuka)->format('Y-m-d'),
                'tarikh_permohonan_ditutup' => Carbon::createFromFormat('d/m/Y',$request->tarikh_permohonan_ditutup)->format('Y-m-d'),
                'lokasi_peperiksaan'        => json_encode($request->lokasi),
            ]);

            Alert::toast('Tetapan Baru Berjaya Dikemaskini', 'success');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Dikemaskini', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index');
    }

    public function destroy($id){
        TetapanPeperiksaanSijilTahfiz::where('id', $id)->delete();

        Alert::toast('Tetapan telah berjaya dibuang', 'success');

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index');
    }

}
