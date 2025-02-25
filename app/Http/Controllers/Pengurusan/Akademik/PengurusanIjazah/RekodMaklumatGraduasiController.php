<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Http\Controllers\Controller;
use App\Models\IjazahMaklumatGraduasi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodMaklumatGraduasiController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Rekod Maklumat Graduasi';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Ijazah' => false,
                'Rekod Maklumat Graduasi' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Rekod Maklumat Graduasi',
                    'route' => route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            $types = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
            ];

            if (request()->ajax()) {
                $data = IjazahMaklumatGraduasi::where('deleted_at', null);
                if ($request->has('nama_fail') && $request->nama_fail != null) {
                    $data = $data->where('file_name', 'LIKE', '%'.$request->nama_fail.'%');
                }
                if ($request->has('jenis_dokumen') && $request->jenis_dokumen != null) {
                    $data = $data->where('document_type', $request->jenis_dokumen);
                }

                return DataTables::of($data)
                    ->addColumn('document_type', function ($data) {
                        switch ($data->document_type) {
                            case 1:
                                return 'Dokumen Baru';
                                break;

                            case 2:
                                return 'Dokumen Tambahan';
                                break;

                            case 3:
                                return 'Dokumen Ganti (Versi Baru)';
                                break;
                        }

                    })
                    ->addColumn('uploaded_document', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.download', $data->id).'" target="_blank">'.$data->file_name.'</a>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['uploaded_document', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'file_name', 'name' => 'file_name', 'title' => 'Nama Fail', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'description', 'name' => 'description', 'title' => 'Keterangan', 'orderable' => false],
                    ['data' => 'document_type', 'name' => 'document_type', 'title' => 'Keadaan Dokumen', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'uploaded_document', 'name' => 'uploaded_document', 'title' => 'Dokumen Graduasi', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'types'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $title = 'Tambah Rekod Maklumat Graduasi';
            $action = route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.store');
            $page_title = 'Maklumat Rekod Maklumat Graduasi';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Ijazah' => false,
                'Rekod Maklumat Graduasi' => route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index'),
                'Tambah Rekod Maklumat Graduasi' => false,
            ];

            $model = new IjazahMaklumatGraduasi();

            $types = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
            ];

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'types'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_dokumen' => 'required',
            'jenis_dokumen' => 'required',
            'file' => 'required',
        ], [
            'nama_dokumen.required' => 'Sila masukkan maklumat nama fail',
            'jenis_dokumen.required' => 'Sila pilih jenis dokumen',
            'file.required' => 'Sila pilih dokumen',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/ijazah/maklumat_graduasi';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            $data = new IjazahMaklumatGraduasi();
            $data->file_name = $request->nama_dokumen;
            $data->description = $request->keterangan;
            $data->document_type = $request->jenis_dokumen;
            $data->uploaded_document = $file;
            $data->created_by = auth()->user()->id;
            $data->save();

            Alert::toast('Rekod maklumat graduasi berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        try {

            $title = 'Tambah Rekod Maklumat Graduasi';
            $action = route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.update', $id);
            $page_title = 'Maklumat Rekod Maklumat Graduasi';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Ijazah' => false,
                'Rekod Maklumat Graduasi' => route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index'),
                'Tambah Rekod Maklumat Graduasi' => false,
            ];

            $model = IjazahMaklumatGraduasi::find($id);

            $types = [
                1 => 'Dokumen Baru',
                2 => 'Dokumen Tambahan',
                3 => 'Dokumen Ganti (Versi Baru)',
            ];

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'types'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = IjazahMaklumatGraduasi::find($id);

            $file = '';
            $original_filename = '';
            if (! empty($request->file)) {
                unlink(storage_path($data->uploaded_document));
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/ijazah/maklumat_graduasi';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.'/'.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = $data->file_name;
                $file = $data->uploaded_document;
            }

            $data->file_name = $request->nama_dokumen;
            $data->description = $request->keterangan;
            $data->document_type = $request->jenis_dokumen;
            $data->uploaded_document = $file;
            $data->created_by = auth()->user()->id;
            $data->save();

            Alert::toast('Rekod maklumat graduasi berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            IjazahMaklumatGraduasi::find($id)->delete();

            Alert::toast('Rekod maklumat graduasi berjaya dihapuskan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = IjazahMaklumatGraduasi::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
