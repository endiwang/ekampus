<?php

namespace App\Http\Controllers\Pelajar\PengurusanIjazah;

use App\Http\Controllers\Controller;
use App\Models\IjazahTesis;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodTesisController extends Controller
{
    protected $baseView = 'pages.pelajar.pengurusan_ijazah.rekod_tesis.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Rekod Tesis/Projek Ilmiah';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Ijazah' => false,
                'Rekod Tesis/Projek Ilmiah' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Rekod Tesis/Projek Ilmiah',
                    'route' => route('pelajar.pengurusan_ijazah.rekod_tesis.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = IjazahTesis::query();
                if ($request->has('nama_projek') && $request->nama_projek != null) {
                    $data = $data->where('project_name', 'LIKE', '%'.$request->nama_projek.'%');
                }
                if ($request->has('tajuk_tesis') && $request->tajuk_tesis != null) {
                    $data = $data->where('project_title', 'LIKE', '%'.$request->tajuk_tesis.'%');
                }

                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return 'Serahan Baru';
                                break;

                            case 2:
                                return 'Dalam Proses';
                                break;

                            case 3:
                                return 'Lulus';
                                break;

                            case 4:
                                return 'Gagal';
                                break;
                        }

                    })
                    ->addColumn('uploaded_document', function ($data) {
                        return '<a href="'.route('pelajar.pengurusan_ijazah.rekod_tesis.download', $data->id).'" target="_blank">'.$data->file_name.'</a>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pelajar.pengurusan_ijazah.rekod_tesis.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.pengurusan_ijazah.rekod_tesis.destroy', $data->id).'" method="POST">
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
                    ['data' => 'project_name', 'name' => 'project_name', 'title' => 'Nama Projek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'project_title', 'name' => 'project_title', 'title' => 'Tajuk Tesis/Projek Ilmiah', 'orderable' => false],
                    ['data' => 'uploaded_document', 'name' => 'uploaded_document', 'title' => 'Dokumen Tesis/Projek Ilmiah', 'orderable' => false, 'class' => 'text-bold'],
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

            $title = 'Tambah Rekod Tesis/Projek Ilmiah';
            $action = route('pelajar.pengurusan_ijazah.rekod_tesis.store');
            $page_title = 'Maklumat Rekod Tesis/Projek Ilmiah';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Ijazah' => false,
                'Rekod Tesis/Projek Ilmiah' => route('pelajar.pengurusan_ijazah.rekod_tesis.index'),
                'Tambah Rekod Tesis/Projek Ilmiah' => false,
            ];

            $model = new IjazahTesis();

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
            'nama_projek' => 'required',
            'tajuk_tesis' => 'required',
            'nama_fail' => 'required',
            'file' => 'required',
        ], [
            'nama_projek.required' => 'Sila masukkan maklumat nama projek',
            'tajuk_tesis.required' => 'Sila masukkan maklumat tajuk tesis',
            'nama_fail.required' => 'Sila masukkan maklumat nama fail',
            'file.required' => 'Sila pilih dokumen',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_path = 'uploads/ijazah/projek_ilmiah';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            $original_filename = $request->file->getClientOriginalName();

            $data = new IjazahTesis();
            $data->project_name = $request->nama_projek;
            $data->project_title = $request->tajuk_tesis;
            $data->file_name = $request->nama_fail;
            $data->uploaded_document = $file;
            $data->document_description = $request->keterangan_dokumen;
            $data->status = 1;
            $data->created_by = auth()->user()->id;
            $data->save();

            Alert::toast('Rekod tesis/projek ilmiah berjaya ditambah!', 'success');

            return redirect()->route('pelajar.pengurusan_ijazah.rekod_tesis.index');

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
        try {

            $title = 'Rekod Tesis/Projek Ilmiah';
            $page_title = 'Maklumat Rekod Tesis/Projek Ilmiah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => route('pelajar.pengurusan_ijazah.rekod_tesis.index'),
                'Rekod Tesis/Projek Ilmiah' => false,
            ];

            $data = IjazahTesis::find($id);

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

            IjazahTesis::find($id)->delete();

            Alert::toast('Rekod maklumat tesis/projek ilmiah berjaya dihapuskan!', 'success');

            return redirect()->route('pelajar.pengurusan_ijazah.rekod_tesis.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = IjazahTesis::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
