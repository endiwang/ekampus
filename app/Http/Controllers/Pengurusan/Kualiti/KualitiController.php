<?php

namespace App\Http\Controllers\Pengurusan\Kualiti;

use App\Http\Controllers\Controller;
use App\Models\Kualiti\Akreditasi;
use App\Models\Kualiti\Artikel;
use App\Models\Kualiti\EditorArtikel;
use App\Models\Kualiti\JaminanKualiti;
use App\Models\Kualiti\KursusDanLatihanPensyarah;
use App\Models\Kualiti\MaklumatKursusDanLatihan;
use App\Models\Kualiti\Muadalah;
use App\Models\Kualiti\Penyelidikan;
use App\Models\Kualiti\PenyumbangArtikel;
use App\Models\Kualiti\RekodKompetensiPensyarah;
use App\Models\Kursus;
use App\Models\Lookup\LookupKategoriMaklumat;
use App\Models\Sesi;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

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
        // $data = JaminanKualiti::with('lkpKategoriMaklumat');
        // dd($data);
        if (request()->ajax()) {
            
            $data = JaminanKualiti::with('lkpKategoriMaklumat');
            // dd($data);

            return DataTables::of($data)
                ->addColumn('kategori', function ($data) {
                    if ($data->lkp_kategori_maklumat == null) {
                        return '';
                    } else {
                        return $data->lkpKategoriMaklumat->nama;
                    }
                })
                ->addColumn('jenis_dokumen', function ($data) {
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
                ->addColumn('action', function ($data) {
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
                ->rawColumns(['kategori', 'kursus', 'jenis_dokumen', 'action'])
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
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'keterangan', 'name' => 'Keterangan', 'title' => 'Keterangan', 'orderable' => false, 'class' => 'text-bold'],
                // ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false],
                ['data' => 'jenis_dokumen', 'name' => 'Jenis Dokumen', 'title' => 'Jenis Dokumen', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        // $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        return view('pages.pengurusan.kualiti.jaminan_kualiti.index', compact('dataTable'));
        // return view('pages.pengurusan.pentadbir_sistem.sesi.main', compact('dataTable','kursus'));
    }

    public function create()
    {
        $catMaklumat = LookupKategoriMaklumat::where('status', 1)->pluck('nama', 'id');
        $jenisDoc = [
            1 => 'Dokumen Baru',
            2 => 'Dokumen Tambahan',
            3 => 'Dokumen Ganti (Versi Baru)',
            4 => 'Dokumen Hapus (delete)',
        ];

        return view('pages.pengurusan.kualiti.jaminan_kualiti.add_new', compact(['catMaklumat', 'jenisDoc']));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'file' => 'required',
            'category' => 'required',

        ], [
            'nama.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen ',
        ]);

        $user = auth()->user();

        try {

            // $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $original_filename = $request->file->getClientOriginalName();
            // dd($original_filename);
            $file_path = 'uploads/jaminan_kualiti/';
            $file = $request->file('file');
            $file->move($file_path, $original_filename);
            $file = $file_path.''.$original_filename;

            // dd('done');

            JaminanKualiti::create([
                'nama' => $request->name,
                'lkp_kategori_maklumat' => $request->category,
                'keterangan' => $request->description,
                'jenis_dokumen' => $request->docType,
                'path' => $file,
                'user_id' => $user->id,
            ]);

            // $original_filename = $request->file->getClientOriginalName();

            Alert::toast('Maklumat jaminan kualiti berjaya ditambah!', 'success');

            return redirect::to('/pengurusan/kualiti/index');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $catMaklumat = LookupKategoriMaklumat::where('status', 1)->pluck('nama', 'id');
        $jenisDoc = [
            1 => 'Dokumen Baru',
            2 => 'Dokumen Tambahan',
            3 => 'Dokumen Ganti (Versi Baru)',
            4 => 'Dokumen Hapus (delete)',
        ];

        $data = JaminanKualiti::where('id', $request->id)->first();

        // dump($data);
        return view('pages.pengurusan.kualiti.jaminan_kualiti.edit', compact(['catMaklumat', 'jenisDoc', 'data']));
    }

    public function update(Request $request)
    {
        // dump($request);
        $validation = $request->validate([
            'name' => 'required',
            'category' => 'required',

        ], [
            'nama.required' => 'Sila masukkan maklumat nama',

        ]);

        $user = auth()->user();

        try {

            $data = JaminanKualiti::find($request->id);
            // dd($data);

            if (! empty($request->file)) {

                // unlink(storage_path($data->path));
                $original_filename = $request->file->getClientOriginalName();
                // dd($original_filename);
                $file_path = 'uploads/jaminan_kualiti/';
                $file = $request->file('file');
                $file->move($file_path, $original_filename);
                $file = $file_path.''.$original_filename;

            } else {

                $file = $data->path;

            }

            $data = $data->update([
                'nama' => $request->name,
                'lkp_kategori_maklumat' => $request->category,
                'keterangan' => $request->description,
                'jenis_dokumen' => $request->docType,
                'path' => $file,
            ]);

            Alert::toast('Maklumat jaminan kualiti berjaya dikemaskini!', 'success');

            return redirect::to('/pengurusan/kualiti/index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function kursusIndex(Builder $builder)
    {

        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Kursus Dan Latihan Pensyarah' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Kursus dan Latihan Pensyarah',
                    'route' => route('pengurusan.kualiti.kursus.tambah'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) 
            {

                $data = KursusDanLatihanPensyarah::query();

                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->document_name.'</a>';
                    })
                    ->addColumn('item', function ($data) {
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
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.kualiti.kursus.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                    })
                // <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                //                 <i class="fa fa-trash"></i>
                //             </a>
                //             <form id="delete-'.$data->id.'" action="'.url('pengurusan/kualiti/kursus/delete').'" method="POST">
                //                 <input type="hidden" name="_token" value="'.csrf_token().'">
                //                 <input type="hidden" name="_method" value="POST">
                //                 <input type="hidden" name="id" value="'.$data->id.'">
                //             </form>
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

            $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

            $dataTable = $builder->parameters([
                'language' => '{ "lengthMenu": "Show _MENU_", }',
                'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable' => false],
                ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable' => false],
                ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();
            
            // $dataTable = '';

            // $dataTable = $builder
            //     ->columns([
            //         ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
            //         ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
            //         ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable' => false],
            //         ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable' => false],
            //         ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable' => false],
            //         ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
            //         ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            //     ])
            //     ->minifiedAjax();

            return view('pages.pengurusan.kualiti.kursus.index', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function kursusTambah(Request $request)
    {
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $action = route('pengurusan.kualiti.kursus.store');
            $page_title = 'Tambah Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Kursus Dan Latihan Pensyarah' => false,
            ];

            $model = new KursusDanLatihanPensyarah();
            $lkpitem = [
                1 => 'Kertas Cadangan dan Kelulusan',
                2 => 'Laporan Pelaksanaan Kursus',
                3 => 'Laporan Maklumbalas Kursus',

            ];

            return view('pages.pengurusan.kualiti.kursus.add_edit', compact('lkpitem', 'model', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function kursusStore(Request $request)
    {
        // dd($request);

        $validation = $request->validate([
            'name' => 'required',
            'file' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/kursus/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            KursusDanLatihanPensyarah::create([
                'name' => $request->name,
                'item' => $request->item,
                'year' => $request->year,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat kursus berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.kualiti.kursus.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function kursusEdit(Request $request)
    {
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $action = route('pengurusan.kualiti.kursus.update');
            $page_title = 'Kemaskini Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Kursus Dan Latihan Pensyarah' => false,
            ];

            $model = KursusDanLatihanPensyarah::find($request->id);
            $lkpitem = [
                1 => 'Kertas Cadangan dan Kelulusan',
                2 => 'Laporan Pelaksanaan Kursus',
                3 => 'Laporan Maklumbalas Kursus',

            ];

            return view('pages.pengurusan.kualiti.kursus.add_edit', compact('lkpitem', 'model', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
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
            if (! empty($request->file)) {
                // unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/kualiti/kursus/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.''.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = $data->document_name;
                $file = $data->upload_document;
            }

            if (! empty($request->status)) {
                // dd('ada');
                $status = 1;
            } else {
                $status = 0;
                // dd('tiada');
            }

            $data = $data->update([
                'name' => $request->name,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'year' => $request->year,
                'status' => $status,
            ]);

            Alert::toast('Maklumat kursus berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.kursus.index');

        } catch (Exception $e) {
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

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function MaklumatKursusIndex(Builder $builder)
    {
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Maklumat Penyertaan Kursus Pensyarah' => false,
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
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/maklumat/kursus/'.$data->id.'/list').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat Peserta">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    // ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable'=> false],
                    // ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable'=> false],
                    ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.pengurusan.kualiti.kursus.index', compact('title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function MaklumatKursusList(Builder $builder, Request $request)
    {
        // dd($request->id);
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Maklumat Penyertaan Kursus Pensyarah' => false,
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

                $data = MaklumatKursusDanLatihan::where('fk_kursus_dan_latihan', $request->id)->get();

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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/maklumat/kursus/peserta/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-list"></i>
                                </a>
                                ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'noic', 'name' => 'noic', 'title' => 'No Kad Pengenalan', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tahun', 'name' => 'tahun', 'title' => 'Tahun', 'orderable' => false],
                    ['data' => 'maklumat_kursus', 'name' => 'maklumat_kursus', 'title' => 'Maklumat Kursus', 'orderable' => false],
                    // ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.kursus.list', compact('title', 'breadcrumbs', 'dataTable', 'kursusid'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function MaklumatKursusTambah(Request $request)
    {
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $action = route('pengurusan.kualiti.maklumat.kursus.store');
            $page_title = 'Tambah Peserta';
            $breadcrumbs = [
                'Kualiti' => false,
                'Kursus Dan Latihan Pensyarah' => false,
                'Maklumat Penyertaan Kursus Pensyarah' => false,
            ];

            $model = new MaklumatKursusDanLatihan();

            return view('pages.pengurusan.kualiti.kursus.maklumat.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function MaklumatKursusStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name' => 'required',
            'noic' => 'required',
            'course' => 'required',
            'year' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            'noic.required' => 'Sila masukkan no IC',
            'course.required' => 'Sila masukkan maklumat kursus',
            'year.required' => 'Sila masukkan tahun',
        ]);

        try {

            MaklumatKursusDanLatihan::create([
                'fk_kursus_dan_latihan' => $request->kursusid,
                'nama' => $request->name,
                'noic' => $request->noic,
                'maklumat_kursus' => $request->course,
                'tahun' => $request->year,
                'status' => 1,
            ]);

            Alert::toast('Maklumat peserta kursus berjaya ditambah!', 'success');

            return redirect()->to('/pengurusan/kualiti/maklumat/kursus/{{$kursusid}}/tambah');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function MaklumatKursusEdit(Request $request)
    {
        try {

            $title = 'Kursus Dan Latihan Pensyarah';
            $action = url('pengurusan/kualiti/maklumat/kursus/peserta/update');
            $page_title = 'Kemaskini Peserta';
            $breadcrumbs = [
                'Kualiti' => false,
                'Kursus Dan Latihan Pensyarah' => false,
                'Maklumat Penyertaan Kursus Pensyarah' => false,
            ];

            $model = MaklumatKursusDanLatihan::find($request->id);

            return view('pages.pengurusan.kualiti.kursus.maklumat.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
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

                'nama' => $request->name,
                'noic' => $request->noic,
                'maklumat_kursus' => $request->course,
                'tahun' => $request->year,

            ]);

            Alert::toast('Maklumat peserta berjaya dikemaskini!', 'success');

            return redirect()->to('/pengurusan/kualiti/maklumat/kursus/'.$request->kursusid.'/list');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function MaklumatKursusDelete(Request $request)
    {

    }

    public function akreditasIndex(Builder $builder, Request $request)
    {
        try {

            $title = 'Akreditasi';
            $breadcrumbs = [
                'Kualiti' => false,
                'Akreditasi' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Akreditasi',
                    'route' => route('pengurusan.kualiti.akreditasi.tambah'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Akreditasi::get();

                // dd($data);
                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->upload_document.'</a>';
                    })
                    ->addColumn('jenis_dokumen', function ($data) {
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
                    ->addColumn('pilihan_dokumen', function ($data) {
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
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/akreditasi/edit/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-list"></i>
                                </a>
                                ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

            $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder->parameters([
            'language' => '{ "lengthMenu": "Show _MENU_", }',
            'dom' => $dom_setting,
        ])

            
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Nama Fail', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'jenis_dokumen', 'name' => 'jenis_dokumen', 'title' => 'Jenis Dokumen', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tarikh_upload', 'name' => 'tarikh_upload', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'pilihan_dokumen', 'name' => 'pilihan_dokumen', 'title' => 'Dokumen', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.akreditasi.index', compact('title', 'buttons', 'breadcrumbs', 'dataTable', 'kursusid'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function akreditasiTambah(Request $request)
    {
        try {

            $page_title = 'Akreditasi';
            $action = route('pengurusan.kualiti.akreditasi.store');
            $title = 'Akreditasi';
            $breadcrumbs = [
                'Kualiti' => false,
                'Akreditasi' => false,
            ];

            $model = new Akreditasi();

            $jenisdoc = [
                1 => 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA)',
                2 => 'Senarai Template Dokumen Audit',
            ];
            $statusdoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            return view('pages.pengurusan.kualiti.akreditasi.add_edit', compact('model', 'jenisdoc', 'statusdoc', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function akreditasiStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'file' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen',
            'keterangan.required' => 'Sila masukkan keterangan',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/akreditasi/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            Akreditasi::create([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'pilihan_dokumen' => $request->jenisdoc,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => 1,
            ]);

            Alert::toast('Maklumat akreditasi ditambah!', 'success');

            return redirect()->route('pengurusan.kualiti.akreditasi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function akreditasiEdit(Request $request)
    {
        try {

            $title = 'Akreditasi';
            $action = url('pengurusan/kualiti/akreditasi/update');
            $page_title = 'Kemaskini Akreditasi';
            $breadcrumbs = [
                'Kualiti' => false,
                'Akreditasi' => false,
                'Kemaskini' => false,
            ];

            $model = Akreditasi::find($request->id);
            $jenisdoc = [
                1 => 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA)',
                2 => 'Senarai Template Dokumen Audit',
            ];
            $statusdoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            return view('pages.pengurusan.kualiti.akreditasi.add_edit', compact('model', 'jenisdoc', 'statusdoc', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
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
            if (! empty($request->file)) {
                // unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/kualiti/akreditasi/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.''.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = $data->document_name;
                $file = $data->upload_document;
            }

            if (! empty($request->status)) {
                // dd('ada');
                $status = 1;
            } else {
                $status = 0;
                // dd('tiada');
            }

            $data = $data->update([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'pilihan_dokumen' => $request->statusdoc,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => $status,
            ]);

            if($request->statusdoc == 4){
                $datadelete = Akreditasi::find($request->id)->delete();
                Alert::toast('Maklumat akreditasi berjaya dihapus!', 'success');
            }else{
                Alert::toast('Maklumat akreditasi berjaya dikemaskini!', 'success');
            }

            

            return redirect()->route('pengurusan.kualiti.akreditasi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function muadalahIndex(Builder $builder, Request $request)
    {

        try {

            $title = 'Muadalah';
            $action = url('pengurusan/kualiti/muadalah/tambah');
            $page_title = 'Pengurusan Muadalah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Muadalah' => false,

            ];

            $buttons = [
                [
                    'title' => 'Tambah Muadalah',
                    'route' => route('pengurusan.kualiti.muadalah.tambah'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Muadalah::query();

                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->document_name.'</a>';
                    })
                    ->addColumn('jenis_dokumen', function ($data) {
                        switch ($data->jenis_dokumen) {
                            case 1:
                                return 'Skop Penaziran Akademik Ke Lokasi Tambahan Darul Quran   (LTDQ) Jakim JAKIM Program Diploma Tahfiz Al-Quran Dan Al-Qiraat';
                                break;
                            case 2:
                                return 'Laporan Penaziran Akademik Ke Lokasi Tambahan Darul Quran (LTDQ) JAKIM   Program Diploma Tahfiz Al-Quran Dan Al-Qiraat';
                                break;
                            case 3:
                                return 'Skop Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT';
                                break;
                            case 4:
                                return 'Laporan Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT';
                                break;
                            case 5:
                                return 'Minit Mesyuarat Persidangan Pengetua MTQN';
                                break;
                            case 6:
                                return 'Maklumbalas minit Persidangan';
                                break;
                            case 7:
                                return 'Laporan persidangan';
                                break;
                            case 8:
                                return 'Minit Mesyuarat Penyelarasan IPT';
                                break;
                            case 9:
                                return 'Maklumbals minit Penyelarasan IPT';
                                break;
                            case 10:
                                return 'Laporan Mesyuarat Penyelarasan IPT';
                                break;
                            case 11:
                                return 'Muadalah Luar Negara';
                                break;
                            case 12:
                                return 'Kerjasama Akademik IPT dalam negara';
                                break;
                            case 13:
                                return 'Lain - lain';
                                break;
                            default:
                                return '';
                        }
                    })
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/muadalah/edit/'.$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="View">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

            $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $dataTable = $builder->parameters([
            'language' => '{ "lengthMenu": "Show _MENU_", }',
            'dom' => $dom_setting,
        ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Kursus', 'orderable' => false],
                    ['data' => 'jenis_dokumen', 'name' => 'jenis_dokumen', 'title' => 'Jenis Dokumen', 'orderable' => false],
                    // ['data' => 'year', 'name' => 'year', 'title' => 'Tahun', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.pengurusan.kualiti.muadalah.index', compact('title', 'breadcrumbs', 'dataTable', 'buttons'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function muadalahTambah(Request $request)
    {
        try {

            $title = 'Muadalah';
            $action = route('pengurusan.kualiti.muadalah.store');
            $page_title = 'Tambah Muadalah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Muadalah' => false,
                'Tambah Muadalah' => false,
            ];

            $jenisdoc = [
                1 => 'Skop Penaziran Akademik Ke Lokasi Tambahan Darul Quran   (LTDQ) Jakim JAKIM Program Diploma Tahfiz Al-Quran Dan Al-Qiraat',
                2 => 'Laporan Penaziran Akademik Ke Lokasi Tambahan Darul Quran (LTDQ) JAKIM   Program Diploma Tahfiz Al-Quran Dan Al-Qiraat',
                3 => 'Skop Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT',
                4 => 'Laporan Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT',
                5 => 'Minit Mesyuarat Persidangan Pengetua MTQN',
                6 => 'Maklumbalas minit Persidangan',
                7 => 'Laporan persidangan',
                8 => 'Minit Mesyuarat Penyelarasan IPT',
                9 => 'Maklumbals minit Penyelarasan IPT',
                10 => 'Laporan Mesyuarat Penyelarasan IPT',
                11 => 'Muadalah Luar Negara',
                12 => 'Kerjasama Akademik IPT dalam negara',
                13 => 'Lain - lain',
            ];
            $keadaandoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            $model = new Muadalah();

            return view('pages.pengurusan.kualiti.muadalah.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'jenisdoc', 'keadaandoc', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function muadalahStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'file' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen',
            'keterangan.required' => 'Sila masukkan keterangan',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/muadalah/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            Muadalah::create([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'keadaan_dokumen' => $request->keadaandoc,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => 1,
            ]);

            Alert::toast('Maklumat muadalah ditambah!', 'success');

            return redirect()->route('pengurusan.kualiti.muadalah.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function muadalahEdit(Request $request)
    {
        try {

            $title = 'Muadalah';
            $action = route('pengurusan.kualiti.muadalah.update');
            $page_title = 'Kemaskini Muadalah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Muadalah' => false,
                'Kemaskini Muadalah' => false,
            ];

            $jenisdoc = [
                1 => 'Skop Penaziran Akademik Ke Lokasi Tambahan Darul Quran   (LTDQ) Jakim JAKIM Program Diploma Tahfiz Al-Quran Dan Al-Qiraat',
                2 => 'Laporan Penaziran Akademik Ke Lokasi Tambahan Darul Quran (LTDQ) JAKIM   Program Diploma Tahfiz Al-Quran Dan Al-Qiraat',
                3 => 'Skop Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT',
                4 => 'Laporan Penaziran Akademik Ke IPT Program Pensijilan Tahfiz JAKIM-IPT',
                5 => 'Minit Mesyuarat Persidangan Pengetua MTQN',
                6 => 'Maklumbalas minit Persidangan',
                7 => 'Laporan persidangan',
                8 => 'Minit Mesyuarat Penyelarasan IPT',
                9 => 'Maklumbals minit Penyelarasan IPT',
                10 => 'Laporan Mesyuarat Penyelarasan IPT',
                11 => 'Muadalah Luar Negara',
                12 => 'Kerjasama Akademik IPT dalam negara',
                13 => 'Lain - lain',
            ];
            $keadaandoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            $model = Muadalah::find($request->id);

            return view('pages.pengurusan.kualiti.muadalah.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'jenisdoc', 'keadaandoc', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function muadalahUpdate(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            // 'file'              => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            // 'file.required'     => 'Sila muat naik dokumen',
            'keterangan.required' => 'Sila masukkan keterangan',
        ]);

        $data = Muadalah::find($request->id);

        $file = '';
        $original_filename = '';
        if (! empty($request->file)) {
            // unlink(storage_path($rule->uploaded_document));
            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/muadalah/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();
        } else {
            $original_filename = $data->document_name;
            $file = $data->upload_document;
        }

        if (! empty($request->status)) {
            // dd('ada');
            $status = 1;
        } else {
            $status = 0;
            // dd('tiada');
        }

        try {

            $data = $data->update([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'keadaan_dokumen' => $request->keadaandoc,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => $status,
            ]);

            if($request->keadaandoc == 4){
                $delete = Muadalah::find($request->id)->delete();
                Alert::toast('Maklumat muadalah dihapus!', 'success');
            }else{
                Alert::toast('Maklumat muadalah dikemaskini!', 'success');
            }

            

            return redirect()->route('pengurusan.kualiti.muadalah.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function RekodKompetensiIndex(Builder $builder, Request $request)
    {
        try {

            $title = 'Rekod Kompetensi Pensyarah';
            $action = route('pengurusan.kualiti.rekodkompetensi.tambah');
            $page_title = 'Rekod Kompetensi Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Rekod Kompetensi Pensyarah' => false,
                'Senarai ' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Rekod Kompetensi ',
                    'route' => route('pengurusan.kualiti.rekodkompetensi.tambah'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = RekodKompetensiPensyarah::get();

                // dd($data);
                return DataTables::of($data)
                // ->addColumn('document_name', function($data) {
                //     return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->upload_document.'</a>';
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) ';
                //         break;
                //         case 2:
                //             return 'Senarai Template Dokumen Audit';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/rekodkompetensi/edit/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-list"></i>
                                </a>
                                ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['status', 'action'])
                    ->toJson();

            }

                $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_pensyarah', 'name' => 'nama_pensyarah', 'title' => 'Nama Pensyarah', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'mykad', 'name' => 'mykad', 'title' => 'No MYKAD', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'semester', 'name' => 'semester', 'title' => 'Semester', 'orderable' => false],
                    // ['data' => 'pilihan_dokumen', 'name' => 'pilihan_dokumen', 'title' => 'Dokumen', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.muadalah.rekodkompetensi.index', compact('title', 'buttons', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function RekodKompetensiTambah(Request $request)
    {
        try {

            $title = 'Rekod Kompetensi Pensyarah';
            $action = route('pengurusan.kualiti.rekodkompetensi.store');
            $page_title = 'Tambah Rekod Kompetensi Pensyarah';
            $breadcrumbs = [
                'Kualiti' => false,
                'Muadalah' => false,
                'Rekod Kompetensi Pensyarah' => false,

            ];

            $model = new Muadalah();

            return view('pages.pengurusan.kualiti.muadalah.rekodkompetensi.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function RekodKompetensiStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([
            'nama_pensyarah' => 'required',
            'mykad' => 'required',
            'subjek' => 'required',
        ], [
            'nama_pensyarah.required' => 'Sila masukkan maklumat nama',
            'mykad.required' => 'Sila masukkan mykad',
            'subjek.required' => 'Sila masukkan subjek',
        ]);

        try {

            RekodKompetensiPensyarah::create([
                'nama_pensyarah' => $request->nama_pensyarah,
                'mykad' => $request->mykad,
                'subjek' => $request->subjek,
                'semester' => $request->semester,
                'status' => 1,
            ]);

            Alert::toast('Maklumat rekod kompetensi pensyarah ditambah!', 'success');

            return redirect()->route('pengurusan.kualiti.rekodkompetensi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function RekodKompetensiEdit(Request $request)
    {

        $title = 'Tambah Rekod Kompetensi Pensyarah';
        $action = route('pengurusan.kualiti.rekodkompetensi.update');
        $page_title = 'Kemaskini Rekod Kompetensi Pensyarah';
        $breadcrumbs = [
            'Kualiti' => false,
            'Muadalah' => false,
            'Kemaskini Rekod Kompetensi Pensyarah' => false,
        ];

        $model = RekodKompetensiPensyarah::find($request->id);

        return view('pages.pengurusan.kualiti.muadalah.rekodkompetensi.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    public function RekodKompetensiUpdate(Request $request)
    {
        $validation = $request->validate([
            'nama_pensyarah' => 'required',
            'mykad' => 'required',
            'subjek' => 'required',
        ], [
            'nama_pensyarah.required' => 'Sila masukkan maklumat nama',
            'mykad.required' => 'Sila masukkan mykad',
            'subjek.required' => 'Sila masukkan subjek',
        ]);

        try {

            if (! empty($request->status)) {
                // dd('ada');
                $status = 1;
            } else {
                $status = 0;
                // dd('tiada');
            }

            $data = RekodKompetensiPensyarah::find($request->id);

            $data = $data->update([
                'nama_pensyarah' => $request->nama_pensyarah,
                'mykad' => $request->mykad,
                'subjek' => $request->subjek,
                'semester' => $request->semester,
                'status' => $status,
            ]);

            Alert::toast('Maklumat rekod kompetensi pensyarah dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.rekodkompetensi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    // penyelidikan
    public function penyelidikanIndex(Builder $builder, Request $request)
    {
        try {

            $title = 'Penyelidikan';
            $action = route('pengurusan.kualiti.penyelidikan.tambah');
            $page_title = 'Penyelidikan';
            $breadcrumbs = [
                'Kualiti' => false,
                'Penyelidikan' => false,

            ];

            $buttons = [
                [
                    'title' => 'Tambah ',
                    'route' => route('pengurusan.kualiti.penyelidikan.tambah'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Penyelidikan::get();

                // dd($data);
                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->upload_document.'</a>';
                    })
                    ->addColumn('jenis_dokumen', function ($data) {
                        switch ($data->jenis_dokumen) {
                            case 1:
                                return 'Laporan Kajian';
                                break;
                            case 2:
                                return 'Infografik';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('pilihan_dokumen', function ($data) {
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
                    ->addColumn('status', function ($data) {
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
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/penyelidikan/edit/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-list"></i>
                                </a>
                                ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();

            }

                $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen ', 'orderable' => false],
                    ['data' => 'jenis_dokumen', 'name' => 'jenis_dokumen', 'title' => 'Jenis Dokumen', 'orderable' => false],
                    ['data' => 'keterangan', 'name' => 'keterangan', 'title' => 'Keterangan', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.penyelidikan.index', compact('title', 'buttons', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyelidikanTambah(Request $request)
    {
        try {

            $title = 'Penyelidikan';
            $action = route('pengurusan.kualiti.penyelidikan.store');
            $page_title = 'Tambah Penyelidikan';
            $breadcrumbs = [
                'Kualiti' => false,
                'Penyelidikan' => false,
                'Tambah' => false,
            ];

            $jenisdoc = [
                1 => 'Laporan Kajian',
                2 => 'Infografik',

            ];
            $keadaandoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            // $model =  Penyelidikan::find($request->id);
            $model = new Penyelidikan;

            return view('pages.pengurusan.kualiti.penyelidikan.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'jenisdoc', 'keadaandoc', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyelidikanStore(Request $request)
    {
        // dd($request);

        // dd($request);
        $validation = $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'file' => 'required',
        ], [
            'name.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen',
            'keterangan.required' => 'Sila masukkan keterangan',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/penyelidikan/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            Penyelidikan::create([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'keadaan_dokumen' => $request->keadaandokumen,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => 1,
            ]);

            Alert::toast('Maklumat penyelidikan ditambah!', 'success');

            return redirect()->route('pengurusan.kualiti.penyelidikan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyelidikanEdit(Request $request)
    {
        // dd($request);
        try {

            $title = 'Penyelidikan';
            $action = route('pengurusan.kualiti.penyelidikan.update');
            $page_title = 'Kemaskini Penyelidikan';
            $breadcrumbs = [
                'Kualiti' => false,
                'Penyeidikan' => false,
                'Kemaskini' => false,
            ];

            $jenisdoc = [
                1 => 'Laporan Kajian',
                2 => 'Infografik',

            ];
            $keadaandoc = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
                4 => 'Dokumen Hapus (delete)',
            ];

            $model = Penyelidikan::find($request->id);

            return view('pages.pengurusan.kualiti.penyelidikan.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'jenisdoc', 'keadaandoc', 'action'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyelidikanUpdate(Request $request)
    {
        // dd($request);

        try {

            $data = Penyelidikan::find($request->id);

            $file = '';
            $original_filename = '';
            if (! empty($request->file)) {
                // unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/kualiti/penyelidikan/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.''.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = $data->document_name;
                $file = $data->upload_document;
            }

            if (! empty($request->status)) {
                // dd('ada');
                $status = 1;
            } else {
                $status = 0;
                // dd('tiada');
            }

            $data = $data->update([
                'jenis_dokumen' => $request->jenisdoc,
                'nama' => $request->name,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'keadaan_dokumen' => $request->keadaandokumen,
                'tarikh_upload' => date('Y-m-d H:i:s'),
                'upload_by' => Auth::user()->id,
                'status' => $status,
            ]);

            Alert::toast('Maklumat Penyelidikan berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.penyelidikan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    // penyumbang artikel daftar
    public function penyumbangDaftar(Request $request)
    {
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.penyumbang.artikel.store');
        $page_title = 'Pendaftaran Penyumbang';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Daftar Penyumbang Artikel' => false,
        ];

        $jenisic = [
            1 => 'MYKAD',
            2 => 'No Paspot',

        ];

        $model = new PenyumbangArtikel;

        return view('pages.pengurusan.kualiti.penyumbang.artikel.daftar', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenisic'));

    }

    public function penyumbangStore(Request $request)
    {
        // dd($request);

        try {

            PenyumbangArtikel::create([

                'nama_penuh' => $request->nama_penuh,
                'email' => $request->email,
                'alamat_dihubungi' => $request->alamat,
                'jenis_pengenalan' => $request->jenis_pengenalan,
                'butiran_pengenalan' => $request->butiran_pengenalan,
                'status' => 1,
            ]);

            Alert::toast('Maklumat permohonan penyumbang artikel dihantar untuk proses kelulusan!', 'success');

            return redirect()->route('pengurusan.kualiti.penyumbang.artikel.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyumbangList(Builder $builder, Request $request)
    {
        try {

            $title = 'Penyumbang Artikel';
            // $action = route('pengurusan.kualiti.penyumbang.tambah');
            $page_title = 'Senarai Permohonan Penyumbang Artikel';
            $breadcrumbs = [
                'Kualiti' => false,
                'Permohonan Penyumbang Artikel' => false,

            ];

            $buttons = [
                [
                    'title' => 'Permohonan ',
                    'route' => route('pengurusan.kualiti.penyumbang.artikel.daftar'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = PenyumbangArtikel::get();

                // dd($data);
                return DataTables::of($data)
                // ->addColumn('document_name', function($data) {
                //     return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->upload_document.'</a>';
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Laporan Kajian';
                //         break;
                //         case 2:
                //             return 'Infografik';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Pendaftaran</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Disahkan</span>';
                                break;
                            case 3:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Disahkan</span>';
                                break;
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/penyumbang/artikel/show/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kelulusan">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['status', 'action'])
                    ->toJson();

            }

                $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_penuh', 'name' => 'nama_penuh', 'title' => 'Nama Penuh', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'email', 'name' => 'email', 'title' => 'Emel ', 'orderable' => false],
                    ['data' => 'butiran_pengenalan', 'name' => 'butiran_pengenalan', 'title' => 'Butiran Pengenalan', 'orderable' => false],
                    // ['data' => 'keterangan', 'name' => 'keterangan', 'title' => 'Keterangan', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.penyumbang.artikel.index', compact('title', 'buttons', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function penyumbangShow(Request $request)
    {
        // dd($request);
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.penyumbang.artikel.update');
        $page_title = 'Kelulusan Penyumbang Artikel';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Kelulusan Penyumbang Artikel' => false,
        ];

        $jenisic = [
            1 => 'MYKAD',
            2 => 'No Paspot',
        ];

        $kelulusan = [
            2 => 'Disahkan',
            3 => 'Tidak Disahkan',
        ];

        $model = PenyumbangArtikel::find($request->id);

        return view('pages.pengurusan.kualiti.penyumbang.artikel.show', compact('kelulusan', 'model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenisic'));
    }

    public function penyumbangUpdate(Request $request)
    {
        // dd($request);
        try {

            $model = PenyumbangArtikel::find($request->id);

            $model = $model->update([
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat permohonan penyumbang artikel dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.penyumbang.artikel.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    // editor artikel
    public function editorDaftar(Request $request)
    {
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.editor.artikel.store');
        $page_title = 'Pendaftaran Editor';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Daftar Editor Artikel' => false,
        ];

        $jenisic = [
            1 => 'MYKAD',
            2 => 'No Paspot',

        ];

        $model = new EditorArtikel;

        return view('pages.pengurusan.kualiti.editor.daftar', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenisic'));

    }

    public function editorStore(Request $request)
    {
        // dd($request);

        try {

            EditorArtikel::create([

                'nama_penuh' => $request->nama_penuh,
                'email' => $request->email,
                'telefon' => $request->telefon,
                'alamat_dihubungi' => $request->alamat,
                'jenis_pengenalan' => $request->jenis_pengenalan,
                'butiran_pengenalan' => $request->butiran_pengenalan,
                'status' => 1,
            ]);

            Alert::toast('Maklumat permohonan editor artikel dihantar untuk proses kelulusan!', 'success');

            return redirect()->route('pengurusan.kualiti.editor.artikel.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function editorList(Builder $builder, Request $request)
    {
        try {

            $title = 'Editor Artikel';
            // $action = route('pengurusan.kualiti.penyumbang.tambah');
            $page_title = 'Senarai Permohonan Editor Artikel';
            $breadcrumbs = [
                'Kualiti' => false,
                'Permohonan Editor Artikel' => false,

            ];

            $buttons = [
                [
                    'title' => 'Permohonan ',
                    'route' => route('pengurusan.kualiti.editor.artikel.daftar'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = EditorArtikel::get();

                // dd($data);
                return DataTables::of($data)
                // ->addColumn('document_name', function($data) {
                //     return '<a href="'. url(data_get($data,'upload_document')) .'" target="_blank">'. $data->upload_document.'</a>';
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Laporan Kajian';
                //         break;
                //         case 2:
                //             return 'Infografik';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-info">Pendaftaran</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Lulus</span>';
                                break;
                            case 3:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Gagal</span>';
                                break;
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/editor/artikel/show/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kelulusan">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['status', 'action'])
                    ->toJson();

            }

                $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_penuh', 'name' => 'nama_penuh', 'title' => 'Nama Penuh', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'email', 'name' => 'email', 'title' => 'Emel ', 'orderable' => false],
                    ['data' => 'butiran_pengenalan', 'name' => 'butiran_pengenalan', 'title' => 'Butiran Pengenalan', 'orderable' => false],
                    // ['data' => 'keterangan', 'name' => 'keterangan', 'title' => 'Keterangan', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.editor.index', compact('title', 'buttons', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function editorShow(Request $request)
    {
        // dd($request);
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.editor.artikel.update');
        $page_title = 'Kelulusan Editor Artikel';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Kelulusan Editor Artikel' => false,
        ];

        $jenisic = [
            1 => 'MYKAD',
            2 => 'No Paspot',
        ];

        $kelulusan = [
            2 => 'Lulus',
            3 => 'Gagal',
        ];

        $model = EditorArtikel::find($request->id);

        return view('pages.pengurusan.kualiti.editor.show', compact('kelulusan', 'model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenisic'));
    }

    public function editorUpdate(Request $request)
    {
        // dd($request);
        try {

            $model = EditorArtikel::find($request->id);

            $model = $model->update([
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat permohonan Editor artikel dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.editor.artikel.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    // artikel submit and check
    public function artikelHantar(Request $request)
    {
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.artikel.store');
        $page_title = 'Hantar Artikel';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Hantar Artikel' => false,
        ];

        $model = new Artikel;

        return view('pages.pengurusan.kualiti.artikel.hantar', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    public function artikelStore(Request $request)
    {
        // dd($request);
        $validation = $request->validate([

            'file' => 'required',
        ], [

            'file.required' => 'Sila muat naik dokumen',

        ]);
        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/kualiti/artikel/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.''.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            Artikel::create([

                'nama_artikel' => $request->nama_artikel,
                'keterangan' => $request->keterangan,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'tarikh_dihantar' => date('Y-m-d H:i:s'),
                'penyumbang' => Auth::user()->id,
                'status' => 1, //dihantar
            ]);

            Alert::toast('Permohonan artikel dihantar!', 'success');

            return redirect()->route('pengurusan.kualiti.artikel.penyumbang.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function artikelPenyumbangList(Builder $builder, Request $request)
    {
        // dd($request);
        try {

            $title = 'Penerbitan';
            $action = route('pengurusan.kualiti.artikel.hantar');
            $page_title = 'Senarai Artikel Penyumbang';
            $breadcrumbs = [
                'Kualiti' => false,
                'Artikel' => false,
                'Senarai ' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Artikel ',
                    'route' => route('pengurusan.kualiti.artikel.hantar'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Artikel::with('editor.staff', 'komen')->where('penyumbang', Auth::user()->id)->get();

                // dd($data);
                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->upload_document.'</a>';
                    })
                    ->addColumn('editor', function ($data) {
                        return data_get($data, 'editor.staff.nama');
                    })
                // ->addColumn('penyumbang', function($data) {
                //     return $data->penyumbang;
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) ';
                //         break;
                //         case 2:
                //             return 'Senarai Template Dokumen Audit';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Dihantar</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Perlu Ubahsuai</span>';
                                break;
                            case 3:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-info">Ditolak</span>';
                                break;
                            case 4:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Diterima</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/rekodkompetensi/edit/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['penyumbang', 'editor', 'document_name', 'status', 'action'])
                    ->toJson();

            }

                $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_artikel', 'name' => 'nama_artikel', 'title' => 'Nama Artikel', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tarikh_dihantar', 'name' => 'tarikh_dihantar', 'title' => 'Tarikh Dihantar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'editor', 'name' => 'editor', 'title' => 'Editor', 'orderable' => false],
                    // ['data' => 'pilihan_dokumen', 'name' => 'pilihan_dokumen', 'title' => 'Dokumen', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    // ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.artikel.penyumbanglist', compact('title', 'buttons', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function artikelEditorList(Builder $builder, Request $request)
    {
        try {

            $title = 'Penerbitan';
            $action = route('pengurusan.kualiti.artikel.hantar');
            $page_title = 'Senarai Artikel Untuk Semakan';
            $breadcrumbs = [
                'Kualiti' => false,
                'Artikel' => false,
                'Senarai Artikel Untuk Semakan' => false,
            ];

            // $buttons = [
            //     [
            //         'title' => "Tambah Artikel ",
            //         'route' => route('pengurusan.kualiti.artikel.hantar'),
            //         'button_class' => "btn btn-sm btn-primary fw-bold",
            //         'icon_class' => "fa fa-plus-circle"
            //     ],
            // ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Artikel::with('editor.staff', 'komen')->whereIn('status', [1,2,3,4])->get();

                // dd($data);
                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->upload_document.'</a>';
                    })
                    ->addColumn('editor', function ($data) {
                        return data_get($data, 'editor.staff.nama');
                    })
                // ->addColumn('penyumbang', function($data) {
                //     return $data->penyumbang;
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) ';
                //         break;
                //         case 2:
                //             return 'Senarai Template Dokumen Audit';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Dihantar</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Perlu Ubahsuai</span>';
                                break;
                            case 3:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-info">Ditolak</span>';
                                break;
                            case 4:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Diterima</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/artikel/editor/show/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Semak">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['penyumbang', 'editor', 'document_name', 'status', 'action'])
                    ->toJson();

            }

            $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_artikel', 'name' => 'nama_artikel', 'title' => 'Nama Artikel', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tarikh_dihantar', 'name' => 'tarikh_dihantar', 'title' => 'Tarikh Dihantar', 'orderable' => false, 'class' => 'text-bold'],
                    // ['data' => 'editor', 'name' => 'editor', 'title' => 'Editor', 'orderable' => false],
                    // ['data' => 'pilihan_dokumen', 'name' => 'pilihan_dokumen', 'title' => 'Dokumen', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.artikel.penyumbanglist', compact('title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function artikelEditorShow(Request $request)
    {
        // dd($request);

        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.artikel.store');
        $page_title = 'Semak Artikel';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Semak Artikel' => false,
        ];

        $status = [
            2 => 'Perlu Diubahsuai',
            3 => 'Ditolak',
            4 => 'Diterima',
        ];

        $model = Artikel::find($request->id);

        return view('pages.pengurusan.kualiti.artikel.show', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'status'));
    }

    public function artikelEditorUpdate(Request $request)
    {
        // dd($request);

        try {

            $model = Artikel::find($request->id);

            $model = $model->update([
                'status' => $request->status,
                'editor' => Auth::user()->id,
            ]);

            Alert::toast('Maklumat Artikel disemak dan dikemaskini!', 'success');

            return redirect()->route('pengurusan.kualiti.artikel.editor.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function artikelPenerbitanList(Builder $builder, Request $request)
    {
        // dd('sii');
        try {

            $title = 'Penerbitan';
            $action = route('pengurusan.kualiti.artikel.hantar');
            $page_title = 'Senarai Artikel Untuk Penerbitan';
            $breadcrumbs = [
                'Kualiti' => false,
                'Artikel' => false,
                'Senarai Artikel Untuk Penerbitan' => false,
            ];

            // $buttons = [
            //     [
            //         'title' => "Tambah Artikel ",
            //         'route' => route('pengurusan.kualiti.artikel.hantar'),
            //         'button_class' => "btn btn-sm btn-primary fw-bold",
            //         'icon_class' => "fa fa-plus-circle"
            //     ],
            // ];
            // dd('kursusindex');

            if (request()->ajax()) {

                $data = Artikel::whereIn('status', [4])->get();

                // dd($data);
                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.url(data_get($data, 'upload_document')).'" target="_blank">'.$data->upload_document.'</a>';
                    })
                    ->addColumn('editor', function ($data) {
                        return data_get($data, 'editor.staff.nama');
                    })
                // ->addColumn('penyumbang', function($data) {
                //     return $data->penyumbang;
                // })
                // ->addColumn('jenis_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) ';
                //         break;
                //         case 2:
                //             return 'Senarai Template Dokumen Audit';
                //         default:
                //         return '';
                //     }
                // })

                // ->addColumn('pilihan_dokumen', function($data) {
                //     switch ($data->jenis_dokumen) {
                //         case 1:
                //             return 'Dokumen Baru';
                //         break;
                //         case 2:
                //             return 'Dokumen Tambahan';
                //         break;
                //         case 3:
                //             return 'Dokumen Ganti';
                //         break;
                //         case 4:
                //             return 'Dokumen Hapus';
                //         break;
                //         default:
                //         return '';
                //     }
                // })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Dihantar</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Perlu Ubahsuai</span>';
                                break;
                            case 3:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Ditolak</span>';
                                break;
                            case 4:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Diterima</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('status_penerbitan', function ($data) {
                        switch ($data->status_penerbitan) {
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Diterbitkan</span>';
                                break;
                            case 2:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Diterbitkan</span>';
                                break;
                            default:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Diterbitkan</span>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.url('pengurusan/kualiti/artikel/penerbitan/show/'.$data->id.'').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Semak">
                                <i class="fa fa-list"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                // ->order(function ($data) {
                //     $data->orderBy('created_at', 'desc');
                // })
                    ->rawColumns(['status_penerbitan', 'penyumbang', 'editor', 'document_name', 'status', 'action'])
                    ->toJson();

            }

            $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
                    <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
                    <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

                $dataTable = $builder->parameters([
                    'language' => '{ "lengthMenu": "Show _MENU_", }',
                    'dom' => $dom_setting,
                ])

            // $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_artikel', 'name' => 'nama_artikel', 'title' => 'Nama Artikel', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tarikh_dihantar', 'name' => 'tarikh_dihantar', 'title' => 'Tarikh Dihantar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'editor', 'name' => 'editor', 'title' => 'Editor', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'status_penerbitan', 'name' => 'status_penerbitan', 'title' => 'Status Penerbitan', 'orderable' => false],

                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            // $kursusid = $request->id;

            return view('pages.pengurusan.kualiti.artikel.penerbitanlist', compact('title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function artikelPenerbitanShow(Request $request)
    {
        $title = 'Penerbitan';
        $action = route('pengurusan.kualiti.artikel.penerbitan.update');
        $page_title = 'Penerbitan Artikel';
        $breadcrumbs = [
            'Penerbitan' => false,
            'Pengurusan Penerbitan Artikel' => false,
        ];

        $statuspenerbitan = [
            1 => 'Diterbitkan',
            2 => 'Belum Diterbitkan',

        ];

        $model = Artikel::find($request->id);

        return view('pages.pengurusan.kualiti.artikel.penerbitanshow', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'statuspenerbitan'));
    }

    public function artikelPenerbitanUpdate(Request $request)
    {
        // dd($request);

        try {

            $model = Artikel::find($request->id);
            if ($request->status_penerbitan == 1) {
                $model = $model->update([
                    'status_penerbitan' => $request->status_penerbitan,
                    'tarikh_penerbitan' => $request->tarikh_penerbitan,
                    'siri_penerbitan' => $request->siri_penerbitan,
                ]);

            }

            Alert::toast('Maklumat Artikel diterbitkan !', 'success');

            return redirect()->route('pengurusan.kualiti.artikel.penerbitan.list');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }
}
