<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Http\Controllers\Controller;
use App\Models\MpkIso;
use Exception;
use File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class MpkIsoController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.mpk_iso.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Maklumat MPK & ISO';
            $breadcrumbs = [
                'Akademik' => false,
                'MPK & ISO' => false,
            ];

            $modals = [
                [
                    'title' => 'Tambah Maklumat MPK & ISO',
                    'id' => '#addMpkIso',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = MpkIso::query();
                if ($request->has('nama') && $request->nama != null) {                    
                    $data->where('document_name', 'LIKE', '%'.$request->nama.'%');
                }
                if ($request->has('jenis') && $request->jenis != null) {                    
                    $data->where('type', 'LIKE', '%'.$request->jenis.'%');
                }

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.pengurusan.mpk_iso.download', $data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.mpk_iso.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'document_name', 'name' => 'document_name', 'title' => 'Tajuk Dokumen', 'orderable' => false],
                    ['data' => 'type', 'name' => 'type', 'title' => 'Jenis', 'orderable' => false],
                    ['data' => 'description', 'name' => 'description', 'title' => 'Keterangan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $types = [
                'MPK' => 'MPK',
                'ISO' => 'ISO',
            ];

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'modals', 'dataTable', 'types'));

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'type' => 'required',
            'document_name' => 'required',
            'file' => 'required',
        ], [
            'type.required' => 'Sila pilih jenis dokument',
            'document_name.required' => 'Sila masukkan maklumat nama dokumen',
            'file.required' => 'Sila pilih fail untuk dimuat naik',
        ]);

        try {

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_extension = $request->file->getClientOriginalExtension();
            $file_path = 'uploads/mpk_iso/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            $mpk_iso = new MpkIso();
            $mpk_iso->document_name = $request->document_name;
            $mpk_iso->type = $request->type;
            $mpk_iso->description = $request->description;
            $mpk_iso->file_name = $request->file->getClientOriginalName();
            $mpk_iso->file_path = $file;
            $mpk_iso->file_extension = $file_extension;
            $mpk_iso->uploaded_by = auth()->user()->id;
            $mpk_iso->save();

            Alert::toast('Maklumat MPK & ISO berjaya disimpan!', 'success');

            return redirect()->back();

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
        //
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
            $check_file = MpkIso::find($id);

            if (File::exists(public_path($check_file->file_path))) {
                File::delete(public_path($check_file->file_path));

                $delete_file = $check_file->delete();
            } else {
                dd('File does not exists.');
            }

            Alert::toast('Maklumat mpk & iso berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = MpkIso::find($id);

        return response()->file(public_path($download->file_path));
    }
}
