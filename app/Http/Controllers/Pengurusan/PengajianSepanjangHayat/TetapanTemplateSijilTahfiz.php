<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\TemplateSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanTemplateSijilTahfiz extends Controller
{
    public function index(Builder $builder){
        $title = "Tetapan Template Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Pengurusan Sijil Tahfiz" =>  '#',
            "Tetapan Template Sijil Tahfiz" =>  '#',
        ];
        $buttons = [
            [
                'title' => "Tambah",
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = TemplateSijilTahfiz::all();
            return DataTables::of($data)
            // ->addColumn('tempoh_permohonan', function($data) {
            //     return Carbon::parse($data->tarikh_permohonan_dibuka)->format('d/m/Y'). ' - ' .Carbon::parse($data->tarikh_permohonan_ditutup)->format('d/m/Y');

            // })
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
                // $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.pusat_peperiksaan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                $btn =' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                $btn .=' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.destroy',$data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                 return $btn;
            })
            ->addIndexColumn()
            // ->order(function ($data) {
            //     $data->orderBy('id', 'desc');
            // })
            ->rawColumns(['status_edit','action'])
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
            ['data' => 'name', 'name' => 'name', 'title' => 'Pusat Peperiksaan', 'orderable'=> true],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.main', compact('title','breadcrumbs', 'html', 'buttons'));
    }

    public function create(){
        $title = "Tambah Tempalate Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  false,
            "Pengurusan Sijil Tahfiz" =>  false,
            "Tetapan Tempalate Sijil Tahfiz" =>  false,
            "Tambah Tempalate Sijil Tahfiz" =>  false,
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.add_new', $data);
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name'  => 'required',
            'template'  => 'required',
        ],[
            'name.required' => 'Sila masukkan nama sijil.',
            'template.required' => 'Ruangan ini perlu diisi.',
        ]);

        $request['created_by'] = Auth::id();
        DB::beginTransaction();
        try {
            TemplateSijilTahfiz::create($request->except('_token'));

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            dd($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.index');
    }

    public function edit($id){
        $title = "Kemaskini Tempalate Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  false,
            "Pengurusan Sijil Tahfiz" =>  false,
            "Tetapan Tempalate Sijil Tahfiz" =>  false,
            "Kemaskini Tempalate Sijil Tahfiz" =>  false,
        ];

        $template = TemplateSijilTahfiz::find($id);
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'template' => $template,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id){

        $validated = $request->validate([
            'name'  => 'required',
            'template'  => 'required',
        ],[
            'name.required' => 'Sila masukkan nama sijil.',
            'template.required' => 'Ruangan ini perlu diisi.',
        ]);

        DB::beginTransaction();
        try {
            TemplateSijilTahfiz::where('id', $id)->update($request->except('_token','_method'));

            Alert::toast('Tetapan Berjaya Dikemaskini', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            dd($e);
            Alert::toast('Tetapan Tidak Berjaya Dikemaskini', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.index');
    }

    public function destroy($id){
        TemplateSijilTahfiz::where('id', $id)->delete();
        Alert::toast('Tetapan Dibuang', 'success');
        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.index');
    }
}
