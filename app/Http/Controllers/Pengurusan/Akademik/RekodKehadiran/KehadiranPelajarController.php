<?php

namespace App\Http\Controllers\Pengurusan\Akademik\RekodKehadiran;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPelajar;
use App\Models\Pelajar;
use App\Models\Subjek;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KehadiranPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.rekod_kehadiran.pelajar.';
    protected $baseRoute = 'pengurusan.akademik.rekod_kehadiran.rekod_pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Rekod Kehadiran Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Rekod Kehadiran Pelajar' => false,
            ];

            if (request()->ajax()) {
                $data = Subjek::query();
                if ($request->has('kod_subjek') && $request->kod_subjek != null) {
                    $data->where('kod_subjek', 'LIKE', '%'.$request->kod_subjek.'%');
                }
                if ($request->has('nama_subjek') && $request->nama_subjek != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama_subjek.'%');
                }
                
                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute . 'show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['kursus', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'nama', 'title' => 'Kod Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'nama', 'name' => 'semasa_semester_id', 'title' => 'Nama Subjek', 'orderable' => false],
                    ['data' => 'kredit', 'name' => 'gred', 'title' => 'Jam Kredit', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

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
        try {
            $pelajar = Pelajar::where('no_matrik', 'LIKE', '%' . $request->no_matrik . '%')->first();

            $file = '';
            if(!empty($request->file))
            {
                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/kehadiran/pelajar';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.'/'.$file_name;
            }

            $store = new KehadiranPelajar();
            $store->pelajar_id = $pelajar->id;
            $store->subjek_id = $request->subjek_id;
            $store->tarikh = $request->tarikh_kehadiran;
            $store->status = $request->status;
            $store->attachment = $file;
            $store->save();

            Alert::toast('Rekod kehadiran pekajar berjaya ditambah!', 'success');

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
    public function show(Builder $builder, $id, Request $request)
    {
        try {

            $subjek = Subjek::find($id);

            $title = 'Kehadiran Pelajar [Subjek: '.$subjek->nama.']';
            $breadcrumbs = [
                'Akademik' => false,
                'Rekod Kehadiran Pelajar' => route($this->baseRoute .'index'),
                $title => false,
            ];

            $modals = [
                [
                    'title' => 'Tambah Maklumat Kehadiran',
                    'id' => '#addKehadiran',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = KehadiranPelajar::with('pelajar')->where('subjek_id', $id);
                if ($request->has('nama') && $request->nama != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                    });
                }
                if ($request->has('no_matrik') && $request->no_matrik != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_matrik', 'LIKE', '%'.$request->no_matrik.'%');
                    });
                }
                if ($request->has('tarikh') && $request->tarikh != null) {
                    $data->whereDate('tarikh', Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d'));
                }

                return DataTables::of($data)
                    ->addColumn('pelajar_id', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        return Utils::formatDate($data->tarikh) ?? null;
                    })
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime($data->waktu) ?? null;
                    })
                    ->addColumn('status', function ($data) {
                        if($data->status == 'hadir')
                        {
                            return 'Hadir';
                        }
                        if($data->status == 'tidak_hadir_tanpa_sebab')
                        {
                            return 'Tidak Hadir Tanpa Sebab';
                        }
                        if($data->status == 'tidak_hadir_dengan_kebenaran')
                        {
                            return 'Tidak Hadir Dengan Kebenaran';
                        }
                        if($data->status == 'tidak_hadir_dengan_sebab')
                        {
                            return 'Tidak Hadir Dengan Sebab Cuti Sakit';
                        }
                    })
                    ->addColumn('attachment', function ($data) {
                        if(!empty($data->attachment))
                        {
                            return '<a href="'.route($this->baseRoute . 'download', $data->id).'" target="_blank">Lampiran</a>';
                        }
                        
                    })
                    ->addColumn('action', function ($data) {
                        return '<a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route($this->baseRoute . 'destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                        
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('tarikh', 'desc');
                    })
                    ->rawColumns(['attachment', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'pelajar_id', 'name' => 'pelajar_id', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'traikh', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'attachment', 'name' => 'attachment', 'title' => 'Lampiran', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false]
                ])
                ->minifiedAjax();
            
            $statuses = [
                'hadir' => 'Hadir',
                'tidak_hadir_tanpa_sebab' => 'Tidak Hadir Tanpa Sebab',
                'tidak_hadir_dengan_kebenaran' => 'Tidak Hadir Dengan Kebenaran',
                'tidak_hadir_dengan_sebab' => 'Tidak Hadir Dengan Sebab Cuti Sakit'
            ];

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'subjek', 'modals', 'id', 'statuses'));

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

            KehadiranPelajar::find($id)->delete();

            Alert::toast('Maklumat kehadiran pelajar berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadAttendancePdf(Request $request)
    {
        try {

            $datas = KehadiranPelajar::with('pelajar')->where('tarikh', Carbon::createFromFormat('d/m/Y', $request->tarikh_kehadiran)->format('Y-m-d'))->get();

            $subjek = $request->nama_subjek;
            $tarikh = Utils::formatDate($request->tarikh);
            $generated_date = Utils::formatDateTime(now());

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.attendance_pdf', compact('datas', 'subjek', 'tarikh', 'generated_date'));

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = KehadiranPelajar::find($id);

        return response()->file(public_path($download->attachment));
    }
}
