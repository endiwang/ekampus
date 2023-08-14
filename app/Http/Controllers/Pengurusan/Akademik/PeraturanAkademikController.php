<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Http\Controllers\Controller;
use App\Models\PeraturanAkademik;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PeraturanAkademikController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.peraturan_akademik.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Peraturan Akademik';
            $breadcrumbs = [
                'Akademik' => false,
                'Peraturan Akademik' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Peraturan Akademik',
                    'route' => route('pengurusan.akademik.peraturan_akademik.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PeraturanAkademik::query();

                return DataTables::of($data)
                    ->addColumn('document_name', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.peraturan_akademik.download', $data->id).'" target="_blank">'.$data->document_name.'</a>';
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                                break;
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.peraturan_akademik.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.peraturan_akademik.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['document_name', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Dokumen Peraturan Akademik', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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

            $title = 'Peraturan Akademik';
            $action = route('pengurusan.akademik.peraturan_akademik.store');
            $page_title = 'Tambah Peraturan Akademik';
            $breadcrumbs = [
                'Akademik' => false,
                'Tambah Peraturan Akademik' => false,
            ];

            $model = new PeraturanAkademik();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

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
            'peraturan_akademik' => 'required',
            'file' => 'required',
        ], [
            'nama.required' => 'Sila masukkan maklumat nama',
            'file.required' => 'Sila muat naik dokumen peraturan akademik',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/peraturan_akademik/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            PeraturanAkademik::create([
                'name' => $request->peraturan_akademik,
                'document_name' => $original_filename,
                'uploaded_document' => $file,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat peraturan akademik berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

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

            $title = 'Peraturan Akademik';
            $action = route('pengurusan.akademik.peraturan_akademik.store');
            $page_title = 'Tambah Peraturan Akademik';
            $breadcrumbs = [
                'Akademik' => false,
                'Tambah Peraturan Akademik' => false,
            ];

            $model = PeraturanAkademik::find($id);

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

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

            $rule = PeraturanAkademik::find($id);

            $file = '';
            $original_filename = '';
            if (! empty($request->file)) {
                unlink(storage_path($rule->uploaded_document));
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/peraturan_akademik/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.'/'.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = $rule->document_name;
                $file = $rule->uploaded_document;
            }

            $rule = $rule->update([
                'name' => $request->peraturan_akademik,
                'document_name' => $original_filename,
                'uploaded_document' => $file,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat peraturan akademik berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

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

            $rule = PeraturanAkademik::find($id);
            $rule->is_deleted = 1;
            $rule->deleted_by = auth()->user()->id;
            $rule = $rule->delete();

            Alert::toast('Maklumat peraturan akademik berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = PeraturanAkademik::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
