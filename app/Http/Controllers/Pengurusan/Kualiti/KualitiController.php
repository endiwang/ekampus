<?php

namespace App\Http\Controllers\Pengurusan\Kualiti;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Auth;
use File;
use Redirect;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sesi;
use App\Models\Kualiti\JaminanKualiti;
use Yajra\DataTables\Html\Builder;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Lookup\LookupKategoriMaklumat;
use Illuminate\Support\Facades\Storage;
use App\Models\Kualiti\KursusDanLatihanPensyarah;
use App\Models\Kualiti\MaklumatKursusDanLatihan;
use App\Models\Kualiti\Akreditasi;


class KualitiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // $data = JaminanKualiti::with('lkpKategoriMaklumat')->get();
        // dd($data);
        if (request()->ajax()) {
            // $data = JaminanKualiti::query();
            $data = JaminanKualiti::with('lkpKategoriMaklumat');        
            return DataTables::of($data)
            ->addColumn('kategori', function($data) {
                if($data->lkp_kategori_maklumat == NULL)
                {
                    return '';
                }else{
                    return $data->lkpKategoriMaklumat->nama;
                }
            })
            ->addColumn('jenis_dokumen', function($data) {
                switch ($data->jenis_dokumen) {
                    case 1:
                        // return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                        return 'Dokumen Baru';
                      break;
                    case 2:
                        // return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        return 'Dokumen Tambahan';
                        break;
                    case 3:
                        return 'Dokumen Ganti';
                        break;
                    case 4:
                        return 'Dokumen Hapus';
                        break;
                    default:
                      return 'Tiada jenis';
                  }
            })
            ->addColumn('action', function($data){
                // $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2">View</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';

                $btn = '<a href="'.url('/pengurusan/kualiti/edit/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Pinda</a>';

                 return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('created_at');
            })
            ->rawColumns(['kategori','kursus','jenis_dokumen','action'])
            ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'keterangan', 'name' => 'Keterangan', 'title' => 'Keterangan', 'orderable'=> false, 'class'=>'text-bold'],
            // ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false],
            ['data' => 'jenis_dokumen', 'name' => 'Jenis Dokumen', 'title' => 'Jenis Dokumen', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        // $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        return view('pages.pengurusan.kualiti.jaminan_kualiti.index', compact('dataTable'));
        // return view('pages.pengurusan.pentadbir_sistem.sesi.main', compact('dataTable','kursus'));
    }


    public function create()
    {
        $catMaklumat = LookupKategoriMaklumat::where('status',1)->pluck('nama', 'id');
        $jenisDoc = [
            1 => 'Dokumen Baru',
            2 => 'Dokumen Tambahan',
            3 => 'Dokumen Ganti (Versi Baru)',
            4 => 'Dokumen Hapus (delete)'
        ];
        


        return view('pages.pengurusan.kualiti.jaminan_kualiti.add_new', compact(['catMaklumat','jenisDoc']));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name'=> 'required',
            'file'=> 'required',
            'category' => 'required',
            
        ],[
            'nama.required'     => 'Sila masukkan maklumat nama',
            'file.required'     => 'Sila muat naik dokumen ',
        ]);

        $user = auth()->user();

        

        try{

            // $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $original_filename = $request->file->getClientOriginalName();
            // dd($original_filename);
            $file_path = 'uploads/jaminan_kualiti/';
            $file = $request->file('file');
            $file->move($file_path, $original_filename);
            $file = $file_path.''.$original_filename;

            // dd('done');

            JaminanKualiti::create([
                'nama'                      => $request->name,
                'lkp_kategori_maklumat'     => $request->category,
                'keterangan'                => $request->description,
                'jenis_dokumen'             => $request->docType,
                'path'                      => $file,
                'user_id'                   => $user->id
            ]);

            // $original_filename = $request->file->getClientOriginalName();

            Alert::toast('Maklumat jaminan kualiti berjaya ditambah!', 'success');
            return redirect::to('/pengurusan/kualiti/index');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $catMaklumat = LookupKategoriMaklumat::where('status',1)->pluck('nama', 'id');
        $jenisDoc = [
            1 => 'Dokumen Baru',
            2 => 'Dokumen Tambahan',
            3 => 'Dokumen Ganti (Versi Baru)',
            4 => 'Dokumen Hapus (delete)'
        ];

        $data = JaminanKualiti::where('id',$request->id)->first();

        // dump($data);
        return view('pages.pengurusan.kualiti.jaminan_kualiti.edit', compact(['catMaklumat','jenisDoc','data']));
    }

    public function update(Request $request)
    {
        // dump($request);
        $validation = $request->validate([
            'name'=> 'required',
            'category' => 'required',
            
        ],[
            'nama.required'     => 'Sila masukkan maklumat nama',
            
        ]);

        $user = auth()->user();

        try{

            $data = JaminanKualiti::find($request->id);
            // dd($data);

            if(!empty($request->file)){

                // unlink(storage_path($data->path));
                $original_filename = $request->file->getClientOriginalName();
                // dd($original_filename);
                $file_path = 'uploads/jaminan_kualiti/';
                $file = $request->file('file');
                $file->move($file_path, $original_filename);
                $file = $file_path.''.$original_filename;

            }else{

                $file = $data->path;

            }

            $data = $data->update([
                'nama'                      => $request->name,
                'lkp_kategori_maklumat'     => $request->category,
                'keterangan'                => $request->description,
                'jenis_dokumen'             => $request->docType,
                'path'                      => $file,
            ]);

            Alert::toast('Maklumat jaminan kualiti berjaya dikemaskini!', 'success');
            return redirect::to('/pengurusan/kualiti/index');
            
        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }


    public function kursusIndex(Builder $builder)
    {

        try {

                $title = "Kursus Dan Latihan Pensyarah";
                $breadcrumbs = [
                    "Kualiti" =>  false,
                    "Kursus Dan Latihan Pensyarah" =>  false,
                ];

                $buttons = [
                    [
                        'title' => "Tambah Kursus dan Latihan Pensyarah", 
                        'route' => route('pengurusan.kualiti.kursus.tambah'), 
                        'button_class' => "btn btn-sm btn-primary fw-bold",
                        'icon_class' => "fa fa-plus-circle"
                    ],
                ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = KursusDanLatihanPensyarah::query();
                return DataTables::of($data)
                ->addColumn('document_name', function($data) {
                    return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->document_name.'</a>';
                })
                ->addColumn('item', function($data) {
                    switch ($data->item) {
                        case 1:
                            return 'Kertas Cadangan dan Kelulusan';
                          break;
                        case 2:
                            return 'Laporan Pelaksanaan Kursus';
                          break;
                        case 3:
                                return 'Laporan Maklumbalas Kursus';
                          break;
                        default:
                          return '';
                    }
                })
                ->addColumn('status', function($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                          break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        default:
                          return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.kualiti.kursus.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.url('pengurusan/kualiti/kursus/delete').'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="id" value="'.$data->id.'">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('created_at', 'desc');
                })
                ->rawColumns(['document_name','status', 'action'])
                ->toJson();

            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable'=> false],
                ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable'=> false],
                ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view('pages.pengurusan.kualiti.kursus.index', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function kursusTambah(Request $request)
    {
        try {

            $title = "Kursus Dan Latihan Pensyarah";                
            $action = route('pengurusan.kualiti.kursus.store');
            $page_title = 'Tambah Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Kursus Dan Latihan Pensyarah" =>  false,
            ];

            $model = new KursusDanLatihanPensyarah();
            $lkpitem = [
                1 => 'Kertas Cadangan dan Kelulusan',
                2 => 'Laporan Pelaksanaan Kursus',
                3 => 'Laporan Maklumbalas Kursus'
                
            ];

            return view('pages.pengurusan.kualiti.kursus.add_edit', compact('lkpitem','model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function kursusStore(Request $request)
    {
        // dd($request);

        $validation = $request->validate([
            'name'=> 'required',
            'file'              => 'required',
        ],[
            'name.required'     => 'Sila masukkan maklumat nama',
            'file.required'     => 'Sila muat naik dokumen',
        ]);

        try {
            
            $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/kursus/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path . '' .$file_name;

            $original_filename = $request->file->getClientOriginalName();

            KursusDanLatihanPensyarah::create([
                'name'                      => $request->name,
                'item'                      => $request->item,
                'year'                      => $request->year,
                'document_name'             => $original_filename,
                'upload_document'           => $file,
                'status'                    => $request->status,
            ]);

            Alert::toast('Maklumat kursus berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.kualiti.kursus.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }


    }

    public function kursusEdit(Request $request)
    {
        try {

            $title = "Kursus Dan Latihan Pensyarah";                
            $action = route('pengurusan.kualiti.kursus.update');
            $page_title = 'Kemaskini Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Kursus Dan Latihan Pensyarah" =>  false,
            ];

            $model = KursusDanLatihanPensyarah::find($request->id);
            $lkpitem = [
                1 => 'Kertas Cadangan dan Kelulusan',
                2 => 'Laporan Pelaksanaan Kursus',
                3 => 'Laporan Maklumbalas Kursus'
                
            ];

            return view('pages.pengurusan.kualiti.kursus.add_edit', compact('lkpitem','model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }

    public function kursusUpdate(Request $request)
    {
        // dump($request);
        try {
            
            $data = KursusDanLatihanPensyarah::find($request->id);

            $file = '';
            $original_filename = '';
            if(!empty($request->file))
            {
                // unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
                $file_path = 'uploads/kualiti/kursus/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path . '' .$file_name;
    
                $original_filename = $request->file->getClientOriginalName();
            }
            else {
                $original_filename = $data->document_name;
                $file = $data->upload_document;
            }

            if(!empty($request->status)){
                // dd('ada');
                $status = 1;
            }else{
                $status = 0;
                // dd('tiada');
            }

            $data = $data->update([
                'name'                      => $request->name,
                'document_name'             => $original_filename,
                'upload_document'           => $file,
                'year'                      => $request->year,
                'status'                    => $status,
            ]);

            Alert::toast('Maklumat kursus berjaya dikemaskini!', 'success');
            return redirect()->route('pengurusan.kualiti.kursus.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = KursusDanLatihanPensyarah::find($id);

        return response()->file(public_path($download->uploaded_document));
    }

    public function kursusDestroy(Request $request)
    {
        // dd($request);
        try {

            $data = KursusDanLatihanPensyarah::find($request->id);
            $data->is_deleted = 1;
            $data->deleted_by = auth()->user()->id;
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->status = 0;
            $data->save();
            // $data = $data->delete();

            Alert::toast('Maklumat kursus berjaya dihapus!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }



    public function MaklumatKursusIndex(Builder $builder)
    {
        try {

                $title = "Kursus Dan Latihan Pensyarah";
                $breadcrumbs = [
                    "Kualiti" =>  false,
                    "Maklumat Penyertaan Kursus Pensyarah" =>  false,
                ];

                // $buttons = [
                //     [
                //         'title' => "Tambah Kursus dan Latihan Pensyarah", 
                //         'route' => route('pengurusan.kualiti.kursus.tambah'), 
                //         'button_class' => "btn btn-sm btn-primary fw-bold",
                //         'icon_class' => "fa fa-plus-circle"
                //     ],
                // ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = KursusDanLatihanPensyarah::query();
                return DataTables::of($data)
                // ->addColumn('document_name', function($data) {
                //     return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->document_name.'</a>';
                // })
                
                ->addColumn('status', function($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                        break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        default:
                        return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.url('pengurusan/kualiti/maklumat/kursus/'.$data->id.'/list').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat Peserta">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('created_at', 'desc');
                })
                ->rawColumns(['document_name','status', 'action'])
                ->toJson();

            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                // ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable'=> false],
                // ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable'=> false],
                ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kualiti.kursus.index', compact('title', 'breadcrumbs', 'dataTable'));

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function MaklumatKursusList(Builder $builder,Request $request)
    {
            // dd($request->id);
        try {

                $title = "Kursus Dan Latihan Pensyarah";
                $breadcrumbs = [
                    "Kualiti" =>  false,
                    "Maklumat Penyertaan Kursus Pensyarah" =>  false,
                ];

                // $buttons = [
                //     [
                //         'title' => "Tambah Kursus dan Latihan Pensyarah", 
                //         'route' => route('pengurusan.kualiti.kursus.tambah'), 
                //         'button_class' => "btn btn-sm btn-primary fw-bold",
                //         'icon_class' => "fa fa-plus-circle"
                //     ],
                // ];
            // dd('kursusindex');

                if (request()->ajax()) {

                    $data = MaklumatKursusDanLatihan::where('fk_kursus_dan_latihan',$request->id)->get();
                    // dd($data);
                    return DataTables::of($data)
                    // ->addColumn('document_name', function($data) {
                    //     return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->document_name.'</a>';
                    // })
                    
                    // ->addColumn('status', function($data) {
                    //     switch ($data->status) {
                    //         case 1:
                    //             return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                    //         break;
                    //         case 0:
                    //             return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                    //         default:
                    //         return '';
                    //     }
                    // })
                    ->addColumn('action', function($data){
                        return '<a href="'.url('pengurusan/kualiti/maklumat/kursus/peserta/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-list"></i>
                                </a>
                                ';
                    })
                    ->addIndexColumn()
                    // ->order(function ($data) {
                    //     $data->orderBy('created_at', 'desc');
                    // })
                    ->rawColumns(['document_name','status', 'action'])
                    ->toJson();

                }

                $dataTable = $builder
                ->columns([
                    ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                    ['data' => 'noic', 'name' => 'noic', 'title' => 'No Kad Pengenalan', 'orderable'=> false, 'class'=>'text-bold'],
                    ['data' => 'tahun', 'name' => 'tahun', 'title' => 'Tahun', 'orderable'=> false],
                    ['data' => 'maklumat_kursus', 'name' => 'maklumat_kursus', 'title' => 'Maklumat Kursus', 'orderable'=> false],
                    // ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

                $kursusid = $request->id;

                return view('pages.pengurusan.kualiti.kursus.list', compact('title', 'breadcrumbs', 'dataTable','kursusid'));

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }


    }

    public function MaklumatKursusTambah(Request $request)
    {
        try {

            $title = "Kursus Dan Latihan Pensyarah";                
            $action = route('pengurusan.kualiti.maklumat.kursus.store');
            $page_title = 'Tambah Peserta';
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Kursus Dan Latihan Pensyarah" =>  false,
                "Maklumat Penyertaan Kursus Pensyarah" =>  false,
            ];

            $model = new MaklumatKursusDanLatihan();
            

            return view('pages.pengurusan.kualiti.kursus.maklumat.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function MaklumatKursusStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name'              => 'required',
            'noic'              => 'required',
            'course'            => 'required',
            'year'              => 'required',
        ],[
            'name.required'     => 'Sila masukkan maklumat nama',
            'noic.required'     => 'Sila masukkan no IC',
            'course.required'     => 'Sila masukkan maklumat kursus',
            'year.required'     => 'Sila masukkan tahun',
        ]);

        try {
            
            

            MaklumatKursusDanLatihan::create([
                'fk_kursus_dan_latihan'     => $request->kursusid,
                'nama'                      => $request->name,
                'noic'                      => $request->noic,
                'maklumat_kursus'           => $request->course,                
                'tahun'                     => $request->year,
                'status'                    => 1
            ]);

            Alert::toast('Maklumat peserta kursus berjaya ditambah!', 'success');
            return redirect()->to('/pengurusan/kualiti/maklumat/kursus/{{$kursusid}}/tambah');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function MaklumatKursusEdit(Request $request)
    {
        try {

            $title = "Kursus Dan Latihan Pensyarah";                
            $action = url('pengurusan/kualiti/maklumat/kursus/peserta/update');
            $page_title = 'Kemaskini Peserta';
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Kursus Dan Latihan Pensyarah" =>  false,
                "Maklumat Penyertaan Kursus Pensyarah" =>  false,
            ];

            $model = MaklumatKursusDanLatihan::find($request->id);

            return view('pages.pengurusan.kualiti.kursus.maklumat.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

            

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function MaklumatKursusUpdate(Request $request)
    {
        // dd($request);
        try {
            
            $data = MaklumatKursusDanLatihan::find($request->id);

            

            $data = $data->update([
                
                'nama'                      => $request->name,
                'noic'                      => $request->noic,
                'maklumat_kursus'           => $request->course,                
                'tahun'                     => $request->year
                
            ]);

            Alert::toast('Maklumat peserta berjaya dikemaskini!', 'success');
            return redirect()->to('/pengurusan/kualiti/maklumat/kursus/'.$request->kursusid.'/list');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function MaklumatKursusDelete(Request $request)
    {
        
    }

    public function akreditasIndex(Builder $builder,Request $request)
    {
        try {

            $title = "Akreditasi";
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Akreditasi" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Akreditasi", 
                    'route' => route('pengurusan.kualiti.akreditasi.tambah'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];
        // dd('kursusindex');

            if (request()->ajax()) {

                $data = Akreditasi::get();
                // dd($data);
                return DataTables::of($data)
                ->addColumn('document_name', function($data) {
                    return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->upload_document.'</a>';
                })
                ->addColumn('jenis_dokumen', function($data) {
                    switch ($data->jenis_dokumen) {
                        case 1:
                            return 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) ';
                        break;
                        case 2:
                            return 'Senarai Template Dokumen Audit';
                        default:
                        return '';
                    }
                })
                
                ->addColumn('pilihan_dokumen', function($data) {
                    switch ($data->jenis_dokumen) {
                        case 1:
                            return 'Dokumen Baru';
                        break;
                        case 2:
                            return 'Dokumen Tambahan';
                        break;
                        case 3:
                            return 'Dokumen Ganti';
                        break;
                        case 4:
                            return 'Dokumen Hapus';
                        break;
                        default:
                        return '';
                    }
                })
                
                ->addColumn('status', function($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                        break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        default:
                        return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.url('pengurusan/kualiti/akreditasi/edit/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                ->rawColumns(['document_name','status', 'action'])
                ->toJson();

            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Nama Fail', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'jenis_dokumen', 'name' => 'jenis_dokumen', 'title' => 'Jenis Dokumen', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_upload', 'name' => 'tarikh_upload', 'title' => 'Tarikh', 'orderable'=> false],
                ['data' => 'pilihan_dokumen', 'name' => 'pilihan_dokumen', 'title' => 'Dokumen', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.akreditasi.index', compact('title','buttons', 'breadcrumbs', 'dataTable','kursusid'));

    }catch (Exception $e) {
        report($e);

        Alert::toast('Uh oh! Something went Wrong', 'error');
        return redirect()->back();
    }
    }

    public function akreditasiTambah(Request $request)
    {
        try {

            $page_title = "Akreditasi";                
            $action = route('pengurusan.kualiti.akreditasi.store');
            $title = "Akreditasi";
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Akreditasi" =>  false,
            ];

            $model = new Akreditasi();

            $jenisdoc = [
                1 => 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA)',
                2 => 'Senarai Template Dokumen Audit'                
            ];
            $statusdoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)'
            ];
            

            return view('pages.pengurusan.kualiti.akreditasi.add_edit', compact('model','jenisdoc','statusdoc','title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
        
    }

    public function akreditasiStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name'              => 'required',
            'keterangan'        => 'required',
            'file'              => 'required',
        ],[
            'name.required'     => 'Sila masukkan maklumat nama',
            'file.required'     => 'Sila muat naik dokumen',
            'keterangan.required'     => 'Sila masukkan keterangan',
        ]);

        try {
            
            $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/akreditasi/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path . '' .$file_name;

            $original_filename = $request->file->getClientOriginalName();

            Akreditasi::create([
                'jenis_dokumen'            => $request->jenisdoc,
                'nama'                      => $request->name,
                'keterangan'                => $request->keterangan,
                'document_name'             => $original_filename,
                'upload_document'           => $file,
                'pilihan_dokumen'           => $request->jenisdoc,
                'tarikh_upload'             => date('Y-m-d H:i:s'),
                'upload_by'                 => Auth::user()->id,
                'status'                    => 1
            ]);

            Alert::toast('Maklumat akreditasi ditambah!', 'success');
            return redirect()->route('pengurusan.kualiti.akreditasi.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function akreditasiEdit(Request $request)
    {
        try {

            $title = "Akreditasi";                
            $action = url('pengurusan/kualiti/akreditasi/update');
            $page_title = 'Kemaskini Akreditasi';
            $breadcrumbs = [
                "Kualiti" =>  false,
                "Akreditasi" =>  false,
                "Kemaskini" =>  false,
            ];

            $model = Akreditasi::find($request->id);
            $jenisdoc = [
                1 => 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA)',
                2 => 'Senarai Template Dokumen Audit'                
            ];
            $statusdoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)'
            ];

            return view('pages.pengurusan.kualiti.akreditasi.add_edit', compact('model','jenisdoc','statusdoc','title', 'breadcrumbs', 'page_title',  'action'));

            

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function akreditasiUpdate(Request $request)
    {
        // dd($request);
        try {
            
            $data = Akreditasi::find($request->id);

            $file = '';
            $original_filename = '';
            if(!empty($request->file))
            {
                // unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
                $file_path = 'uploads/kualiti/akreditasi/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path . '' .$file_name;
    
                $original_filename = $request->file->getClientOriginalName();
            }
            else {
                $original_filename = $data->document_name;
                $file = $data->upload_document;
            }

            if(!empty($request->status)){
                // dd('ada');
                $status = 1;
            }else{
                $status = 0;
                // dd('tiada');
            }

            $data = $data->update([
                'jenis_dokumen'             => $request->jenisdoc,
                'nama'                      => $request->name,
                'keterangan'                => $request->keterangan,
                'document_name'             => $original_filename,
                'upload_document'           => $file,
                'pilihan_dokumen'           => $request->jenisdoc,
                'tarikh_upload'             => date('Y-m-d H:i:s'),
                'upload_by'                 => Auth::user()->id,
                'status'                    => $status
            ]);

            Alert::toast('Maklumat akreditasi berjaya dikemaskini!', 'success');
            return redirect()->route('pengurusan.kualiti.akreditasi.index');


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }



}