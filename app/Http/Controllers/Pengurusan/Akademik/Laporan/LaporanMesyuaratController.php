<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Laporan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\LaporanMesyuarat;
use App\Models\LaporanMesyuaratDetail;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class LaporanMesyuaratController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.laporan.mesyuarat.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Laporan Mesyuarat';
            $breadcrumbs = [
                'Akademik' => false,
                'Laporan Mesyuarat' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Laporan Mesyuarat Baru',
                    'route' => route('pengurusan.akademik.laporan.laporan_mesyuarat.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = LaporanMesyuarat::query();

                return DataTables::of($data)
                    ->addColumn('tarikh_mesyuarat', function ($data) {
                        return Utils::formatDate($data->tarikh_mesyuarat) ?? null;
                    })
                    ->addColumn('bahagian_terlibat', function ($data) {
                        $jabatan_id = json_decode($data->bahagian_terlibat);
                        $jabatan = Jabatan::whereIn('id', $jabatan_id)->pluck('nama');

                        return json_decode($jabatan) ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.laporan.laporan_mesyuarat.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.laporan.laporan_mesyuarat.destroy', $data->id).'" method="POST">
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
                    ['data' => 'nama_mesyuarat', 'name' => 'nama_mesyuarat', 'title' => 'Nama Mesyuarat', 'orderable' => false],
                    ['data' => 'tarikh_mesyuarat', 'name' => 'tarikh_mesyuarat', 'title' => 'Tarikh Mesyuarat', 'orderable' => false],
                    ['data' => 'bahagian_terlibat', 'name' => 'bahagian_terlibat', 'title' => 'Bahagian Terlibat', 'orderable' => false],
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

            $title = 'Laporan Mesyuarat';
            $action = route('pengurusan.akademik.laporan.laporan_mesyuarat.store');
            $page_title = 'Tambah Laporan Mesyuarat';
            $breadcrumbs = [
                'Akademik' => false,
                'Laporan Mesyuarat' => route('pengurusan.akademik.laporan.laporan_mesyuarat.index'),
                'Tambah Laporan Mesyuarat' => false,
            ];

            $model = new LaporanMesyuarat();

            $departments = Jabatan::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'create', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'departments'));

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
            'nama_mesyuarat' => 'required',
            'tarikh_mesyuarat' => 'required',
            'bahagian_terlibat' => 'required',
        ], [
            'nama_mesyuarat.required' => 'Sila masukkan nama mesyuarat',
            'tarikh_mesyuarat.required' => 'Sila pilih tarikh mesyuarat',
            'bahagian_terlibat.required' => 'Sila pilih unit/bahagian',
        ]);

        try {
            $laporan = new LaporanMesyuarat();
            $laporan->nama_mesyuarat = $request->nama_mesyuarat;
            $laporan->tarikh_mesyuarat = Carbon::createFromFormat('d/m/Y', $request->tarikh_mesyuarat)->format('Y-m-d');
            $laporan->bahagian_terlibat = json_encode($request->bahagian_terlibat);
            $laporan->save();

            //save multiple files
            foreach ($request->data as $value) {
                $file_name = uniqid().'.'.$value['file']->getClientOriginalExtension();
                $file_extension = $value['file']->getClientOriginalExtension();
                $file_path = 'uploads/laporan/mesyuarat/';
                $file = $value['file'];
                $file->move($file_path, $file_name);
                $file = $file_path.'/'.$file_name;

                LaporanMesyuaratDetail::create([
                    'laporan_mesyuarat_id' => $laporan->id,
                    'file_name' => $value['file_name'],
                    'description' => $value['description'],
                    'file_extension' => $file_extension,
                    'file_path' => $file,
                    'uploaded_by' => auth()->user()->id,
                ]);
            }

            Alert::toast('Maklumat laporan mesyuarat berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.laporan.laporan_mesyuarat.index');

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
    public function edit(Builder $builder, $id)
    {
        try {

            $title = 'Laporan Mesyuarat';
            $action = route('pengurusan.akademik.laporan.laporan_mesyuarat.update_laporan', $id);
            $page_title = 'Pinda Laporan Mesyuarat';
            $breadcrumbs = [
                'Akademik' => false,
                'Laporan Mesyuarat' => route('pengurusan.akademik.laporan.laporan_mesyuarat.index'),
                'Pinda Laporan Mesyuarat' => false,
            ];

            $model = LaporanMesyuarat::find($id);
            $selected_departments = json_decode($model->bahagian_terlibat);
            $departments = Jabatan::where('deleted_at', null)->pluck('nama', 'id');
            $types = [
                '0' => 'Dokumen Baru',
                '1' => 'Dokumen Tambahan',
                '2' => 'Dokumen Ganti (versi baru)',
            ];

            if (request()->ajax()) {
                $data = LaporanMesyuaratDetail::with('staff')->where('laporan_mesyuarat_id', $id);

                return DataTables::of($data)
                    ->addColumn('type', function ($data) {
                        $type = '';

                        if ($data->type == 0) {
                            $type = 'Dokumen Baru';
                        } elseif ($data->type == 1) {
                            $type = 'Dokumen Tambahan';
                        } elseif ($data->type == 2) {
                            $type = 'Dokumen Ganti (versi Baru)';
                        }

                        return $type;
                    })
                    ->addColumn('created_at', function ($data) {
                        return Utils::formatDate($data->created_at);
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.laporan.laporan_mesyuarat.download', $data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.laporan.laporan_mesyuarat.delete_file', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
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
                    ['data' => 'file_name', 'name' => 'file_name', 'title' => 'Nama Fail', 'orderable' => false],
                    ['data' => 'description', 'name' => 'description', 'title' => 'Keterangan', 'orderable' => false],
                    ['data' => 'type', 'name' => 'type', 'title' => 'Keadaan Dokumen', 'orderable' => false],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Muat Naik', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'departments', 'selected_departments', 'types', 'id', 'dataTable'));

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
            $laporan = LaporanMesyuarat::find($id);
            $laporan->nama_mesyuarat = $request->nama_mesyuarat;
            $laporan->tarikh_mesyuarat = Carbon::createFromFormat('d/m/Y', $request->tarikh_mesyuarat)->format('Y-m-d');
            $laporan->bahagian_terlibat = json_encode($request->bahagian_terlibat);
            $laporan->save();

            Alert::toast('Maklumat laporan mesyuarat berjaya dipinda!', 'success');

            return redirect()->back();

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
            LaporanMesyuarat::find($id)->delete();

            LaporanMesyuaratDetail::where('laporan_mesyuarat_id', $id)->delete();

            Alert::toast('Maklumat laporan mesyuarat berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function uploadFile($id, Request $request)
    {

        try {
            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_extension = $request->file->getClientOriginalExtension();
            $file_path = 'uploads/laporan/mesyuarat/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            LaporanMesyuaratDetail::create([
                'laporan_mesyuarat_id' => $id,
                'file_name' => $request->file_name,
                'description' => $request->description,
                'file_extension' => $file_extension,
                'file_path' => $file,
                'type' => $request->type,
                'uploaded_by' => auth()->user()->id,
            ]);

            Alert::toast('Maklumat fail mesyuarat berjaya ditambah!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function deleteFile($id)
    {
        try {
            $check_file = LaporanMesyuaratDetail::find($id);

            if (File::exists(public_path($check_file->file_path))) {
                File::delete(public_path($check_file->file_path));

                $delete_file = $check_file->delete();
            } else {
                Alert::toast('File does not exist', 'error');

                return redirect()->back();
            }

            Alert::toast('Maklumat fail mesyuarat berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = LaporanMesyuaratDetail::find($id);

        return response()->file(public_path($download->file_path));
    }
}
