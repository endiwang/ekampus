<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPelajar;
use App\Models\Kelas;
use App\Models\Pelajar;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PemantauanKehadiranController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.';
    protected $baseRoute = 'pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Pemantaun Kehadiran';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pemantaun Kehadiran' => false,
            ];

            if (request()->ajax()) {
                $data = Kelas::query();
                if ($request->has('kelas') && $request->kelas != null) {
                    $data->where('id', $request->kelas);
                }

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat CLO PLO">
                                <i class="fa fa-eye"></i>
                            </a>
                           ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['action', 'status'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kelas', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $classes = Kelas::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'classes'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request, Builder $builder)
    {
        // try {
            $title = 'Pemantaun Kehadiran';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pemantaun Kehadiran' => route($this->baseRoute . 'index'),
                'Senarai Pelajar' => false
            ];

            $modals = [
                [
                    'title' => 'Muatturun Kehadiran',
                    'id' => '#downloadKehadiran',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = KehadiranPelajar::with('subjek')->whereHas('pelajar', function($data) use ($id) {
                            $data->where('kelas_id', $id);
                        });
                if ($request->has('nama_pelajar') && $request->nama_pelajar != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama_pelajar.'%');
                    });
                }
                if ($request->has('subjek') && $request->subjek != null) {
                    $data = $data->whereHas('subjek', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->subjek.'%');
                    });
                }

                return DataTables::of($data)
                    ->addColumn('pelajar_id', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
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
                        else if($data->status == 'tidak_hadir_tanpa_sebab')
                        {
                            return 'Tidak Hadir Tanpa Sebab';
                        }
                        else if($data->status == 'tidak_hadir_dengan_kebenaran')
                        {
                            return 'Tidak Hadir Dengan Kebenaran';
                        }
                        else if($data->status == 'tidak_hadir_dengan_sebab')
                        {
                            return 'Tidak Hadir Dengan Sebab Cuti Sakit';
                        }
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.detail', [$data->id, $id]).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat CLO PLO">
                                <i class="fa fa-eye"></i>
                            </a>
                           ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action', 'status'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'pelajar_id', 'name' => 'pelajar_id', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'traikh', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $students = Pelajar::where('kelas_id', $id)->get()->pluck('nama', 'id');

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'id', 'modals', 'students'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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
     * @param  \Illuminate\Http\Request  $request
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
        //
    }

    public function viewPelajarDetail($id, $kelas_id)
    {
        try {

            $title = 'Pemantaun Kehadiran';
            $page_title = 'Maklumat Kehadiran Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pemantaun Kehadiran' => route($this->baseRoute . 'index'),
                'Senarai Pelajar' => route($this->baseRoute . 'show', $kelas_id),
                'Maklumat Kehadiran' => false,
            ];

            $model = KehadiranPelajar::with('pelajar', 'subjek')->find($id);

            return view($this->baseView.'detail', compact('title', 'page_title', 'breadcrumbs', 'id', 'model', 'kelas_id'));

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

    public function export(Request $request)
    {
        $dari = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula)->format('Y-m-d');
        $hingga = Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir)->format('Y-m-d');

        $datas = KehadiranPelajar::with('pelajar')
                ->where('pelajar_id', $request->pelajar)
                ->whereBetween('tarikh', [$dari, $hingga])
                ->get();
        
        $model = Pelajar::with('pusat_pengajian', 'sesi', 'semester', 'syukbah')->find($request->pelajar);

        $tarikh_mula = $request->tarikh_mula;
        $tarikh_akhir = $request->tarikh_akhir;
        $generated_date = Utils::formatDateTime(now());

            //generate PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView($this->baseView.'.attendance_pdf', compact('datas', 'tarikh_mula', 'tarikh_akhir', 'generated_date', 'model'));

        return $pdf->stream();
    }
}
