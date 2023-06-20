<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use File;
use Illuminate\Support\Facades\Storage;
use App\Models\IjazahPenawaranSubjek;
use App\Models\Sesi;

class RekodPenawaranSubjekController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

            $title = "Rekod Penawaran Subjek";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Penawaran Subjek" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Penawaran Subjek",
                    'route' => route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = IjazahPenawaranSubjek::query();
                return DataTables::of($data)
                ->addColumn('document_name', function($data) {
                    return '<a href="'. route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.download', $data->id) .'" target="_blank">'. $data->document_name.'</a>';
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addColumn('sesi', function($data) {
                    if(!empty($data->sesi))
                    {
                        return $data->sesi->nama;
                    }
                    else {
                        return 'N\A';
                    }
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['document_name','sesi', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'sesi', 'name' => 'sasi', 'title' => 'Sesi', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Penawaran Subjek', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Rekod Penawaran Subjek';
        $action = route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.store');
        $page_title = 'Tambah Rekod Penawaran Subjek';
        $breadcrumbs = [
            "Akademik" =>  false,
            "Pengurusan Ijazah" =>  false,
            "Rekod Penawaran Subjek" =>  false,
            "Tambah Rekod" =>  false,
        ];

        $model = new IjazahPenawaranSubjek();
        $sesi =  Sesi::where('kursus_id', 12)->pluck('nama','id');


        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action','sesi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'sesi'=> 'required',
            'nama_dokumen'=> 'required',
            'file'              => 'required',
        ],[
            'nama.required'         => 'Sila pilih sesi pengajian',
            'nama_dokumen.required' => 'Sila masukkan nama dokument',
            'file.required'         => 'Sila muat naik rekod penawaran akademik',
        ]);

        $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
        $file_path = 'uploads/ijazah/rekod_penawaran_subjek';
        $file = $request->file('file');
        $file->move($file_path, $file_name);
        $file = $file_path . '/' .$file_name;

        $original_filename = $request->file->getClientOriginalName();

        IjazahPenawaranSubjek::create([
            'name'                      => $request->nama_dokumen,
            'document_name'             => $original_filename,
            'uploaded_document'         => $file,
            'sesi_id'                   => $request->sesi,
            'status'                    => 1,
            'kursus_id'                 => 12,
        ]);

        Alert::toast('Maklumat rekod penawaran subjek berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Rekod Penawaran Subjek';
        $action = route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.update',$id);
        $page_title = 'Pinda Rekod Penawaran Subjek';
        $breadcrumbs = [
            "Akademik" =>  false,
            "Pengurusan Ijazah" =>  false,
            "Rekod Penawaran Subjek" =>  false,
            "Tambah Rekod" =>  false,
        ];

        $sesi =  Sesi::where('kursus_id', 12)->pluck('nama','id');

        $model = IjazahPenawaranSubjek::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','sesi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'sesi'=> 'required',
            'nama_dokumen'=> 'required',
        ],[
            'nama.required'         => 'Sila pilih sesi pengajian',
            'nama_dokumen.required' => 'Sila masukkan nama dokument',
        ]);

        $data = IjazahPenawaranSubjek::find($id);

        $file = '';
        $original_filename = '';
        if(!empty($request->file))
        {
            unlink(storage_path($data->uploaded_document));
            $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $file_path = 'uploads/peraturan_akademik/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path . '/' .$file_name;

            $original_filename = $request->file->getClientOriginalName();
        }
        else {
            $original_filename = $data->document_name;
            $file = $data->uploaded_document;
        }


            $data->name                 = $request->nama_dokumen;
            $data->document_name        = $original_filename;
            $data->uploaded_document    = $file;
            $data->sesi_id              = $request->sesi;
            $data->status               = 1;
            $data->kursus_id            = 12;
            $data->save();

        Alert::toast('Maklumat rekod penawaran subjek berjaya dipinda!', 'success');
        return redirect()->route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = IjazahPenawaranSubjek::find($id);
            $data->is_deleted = 1;
            $data->deleted_by = auth()->user()->id;
            $data->delete();

            Alert::toast('Maklumat rekod penawaran subjek berjaya dihapus!', 'success');
            return redirect()->back();
    }

    public function download($id)
    {
        $download = IjazahPenawaranSubjek::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
