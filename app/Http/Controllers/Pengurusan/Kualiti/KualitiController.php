<?php

namespace App\Http\Controllers\Pengurusan\Kualiti;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sesi;
use App\Models\Kualiti\JaminanKualiti;
use Yajra\DataTables\Html\Builder;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Lookup\LookupKategoriMaklumat;
use File;
use Illuminate\Support\Facades\Storage;
use Auth;
use Redirect;

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



}