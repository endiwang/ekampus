<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Aktiviti;
use App\Models\AktivitiDetail;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class HebahanAktivitiController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.hebahan_aktiviti.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Hebahan Aktiviti';
            $breadcrumbs = [
                'Akademik' => false,
                'Hebahan Aktiviti' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Hebahan Aktiviti',
                    'route' => route('pengurusan.akademik.pengurusan.hebahan_aktiviti.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = Aktiviti::query();
                if ($request->has('nama') && $request->nama != null) {                    
                    $data->where('nama_program', 'LIKE', '%'.$request->nama.'%');
                }

                return DataTables::of($data)
                    ->addColumn('tarikh_program', function ($data) {
                        return Utils::formatDate($data->tarikh_program) ?? null;
                    })
                    ->addColumn('tarikh_mula', function ($data) {
                        return Utils::formatDate($data->tarikh_mula) ?? null;
                    })
                    ->addColumn('tarikh_tamat', function ($data) {
                        return Utils::formatDate($data->tarikh_tamat) ?? null;
                    })
                    ->addColumn('status_kelulusan', function ($data) {
                        $kelulusan = '';

                        if ($data->kelulusan == 0) {
                            $kelulusan = 'Dalam Proses';
                        } elseif ($data->kelulusan == 1) {
                            $kelulusan = 'Diluluskan';
                        } elseif ($data->kelulusan == 1) {
                            $kelulusan = 'Ditolak';
                        }

                        return $kelulusan;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.pengurusan.hebahan_aktiviti.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.hebahan_aktiviti.destroy', $data->id).'" method="POST">
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
                    ['data' => 'nama_program', 'name' => 'document_name', 'title' => 'Nama Program', 'orderable' => false],
                    ['data' => 'tarikh_program', 'name' => 'type', 'title' => 'Tarikh Program', 'orderable' => false],
                    ['data' => 'tarikh_mula', 'name' => 'tarikh_mula', 'title' => 'Tarikh Mula Hebahan', 'orderable' => false],
                    ['data' => 'tarikh_tamat', 'name' => 'tarikh_tamat', 'title' => 'Tarikh Habis Hebahan', 'orderable' => false],
                    ['data' => 'status_kelulusan', 'name' => 'status_kelulusan', 'title' => 'Kelulusan', 'orderable' => false],
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

            $title = 'Hebahan Aktiviti';
            $action = route('pengurusan.akademik.pengurusan.hebahan_aktiviti.store');
            $page_title = 'Tambah Hebahan Aktiviti';
            $breadcrumbs = [
                'Akademik' => false,
                'Hebahan Aktiviti' => route('pengurusan.akademik.pengurusan.hebahan_aktiviti.index'),
                'Tambah Hebahan Aktiviti' => false,
            ];

            $model = new Aktiviti();

            $statuses = [
                '1' => 'Dalam Proses',
                '2' => 'Diluluskan',
                '3' => 'Ditolak',
            ];

            return view($this->baseView.'create', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'statuses'));

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
        try {
            $aktiviti = new Aktiviti();
            $aktiviti->nama_program = $request->nama_program;
            $aktiviti->tarikh_program = Carbon::createFromFormat('d/m/Y', $request->tarikh_program)->format('Y-m-d');
            $aktiviti->jenis_hebahan = $request->jenis_hebahan;
            $aktiviti->jenis_hebahan_detail = $request->jenis_hebahan_detail;
            $aktiviti->tarikh_mula = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula)->format('Y-m-d');
            $aktiviti->tarikh_tamat = Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat)->format('Y-m-d');
            $aktiviti->status_kelulusan = $request->kelulusan;
            $aktiviti->save();

            //save multiple files
            foreach ($request->data as $value) {
                if (! empty($value['file'])) {

                    $file_name = uniqid().'.'.$value['file']->getClientOriginalExtension();
                    $file_extension = $value['file']->getClientOriginalExtension();
                    $file_path = 'uploads/pengurusan/hebahan_aktiviti/';
                    $file_data = $value['file'];
                    $file = $value['file'];
                    //dd($request->all());
                    $file->move($file_path, $file_name);
                    $file = $file_path.'/'.$file_name;

                    AktivitiDetail::create([
                        'aktiviti_id' => $aktiviti->id,
                        'file_name' => $value['file_name'],
                        'file_extension' => $file_extension,
                        'file_path' => $file,
                    ]);
                }

            }

            Alert::toast('Maklumat hebahan aktiviti berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan.hebahan_aktiviti.index');

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

            $title = 'Hebahan Aktiviti';
            $action = route('pengurusan.akademik.pengurusan.hebahan_aktiviti.update_aktiviti', $id);
            $page_title = 'Pinda Hebahan Aktiviti';
            $breadcrumbs = [
                'Akademik' => false,
                'Hebahan Aktiviti' => route('pengurusan.akademik.pengurusan.hebahan_aktiviti.index'),
                'Pinda Hebahan Aktiviti' => false,
            ];

            $model = Aktiviti::find($id);
            $selected_status = $model->status_kelulusan;

            $statuses = [
                '1' => 'Dalam Proses',
                '2' => 'Diluluskan',
                '3' => 'Ditolak',
            ];

            $selected_type = $model->jenis_hebahan;
            $selected_detail = $model->jenis_hebahan_detail;

            if (request()->ajax()) {
                $data = AktivitiDetail::where('aktiviti_id', $id);

                return DataTables::of($data)
                    ->addColumn('created_at', function ($data) {
                        return Utils::formatDate($data->created_at);
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.pengurusan.hebahan_aktiviti.download', $data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.hebahan_aktiviti.delete_file', $data->id).'" method="POST">
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
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Muat Naik', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'id', 'dataTable', 'statuses', 'selected_status', 'selected_type', 'selected_detail'));

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
            $aktiviti = Aktiviti::find($id);
            $aktiviti->nama_program = $request->nama_program;
            $aktiviti->tarikh_program = Carbon::createFromFormat('d/m/Y', $request->tarikh_program)->format('Y-m-d');
            $aktiviti->tarikh_mula = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula)->format('Y-m-d');
            $aktiviti->tarikh_tamat = Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat)->format('Y-m-d');
            $aktiviti->jenis_hebahan = $request->jenis_hebahan;
            $aktiviti->jenis_hebahan_detail = $request->jenis_hebahan_detail;
            $aktiviti->save();

            Alert::toast('Maklumat hebahan aktiviti berjaya dipinda!', 'success');

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
            Aktiviti::find($id)->delete();

            AktivitiDetail::where('aktiviti_id', $id)->delete();

            Alert::toast('Maklumat hebahan aktiviti berjaya dihapus!', 'success');

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
            $file_path = 'uploads/pengurusan/hebahan_aktiviti/';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            AktivitiDetail::create([
                'aktiviti_id' => $id,
                'file_name' => $request->file_name,
                'file_extension' => $file_extension,
                'file_path' => $file,
            ]);

            Alert::toast('Maklumat fail hebahan aktiviti berjaya ditambah!', 'success');

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
            $check_file = AktivitiDetail::find($id);

            if (File::exists(public_path($check_file->file_path))) {
                File::delete(public_path($check_file->file_path));

                $delete_file = $check_file->delete();
            } else {
                Alert::toast('File does not exist', 'error');

                return redirect()->back();
            }

            Alert::toast('Maklumat fail hebahan aktiviti berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = AktivitiDetail::find($id);

        return response()->file(public_path($download->file_path));
    }
}
