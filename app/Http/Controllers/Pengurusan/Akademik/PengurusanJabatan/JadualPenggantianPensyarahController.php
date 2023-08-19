<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\JadualPenggantianPensyarah;
use App\Models\Kelas;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class JadualPenggantianPensyarahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.';
    protected $baseRoute = 'pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Jadual Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual' => false,
                'Jadual Pensyarah' => false,
            ];

            if (request()->ajax()) {
                $data = Staff::with('pusatPengajian', 'jabatan')->where('deleted_at', null);
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%' . $request->nama . '%');
                }
                if ($request->has('staff_id') && $request->staff_id != null) {
                    $data->where('staff_id', 'LIKE', '%' . $request->staff_id . '%');
                }
                if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                }
                if ($request->has('jabatan') && $request->jabatan != null) {
                    $data->where('jabatan_id', $request->jabatan);
                }

                return DataTables::of($data)
                    ->addColumn('pusat_pengajian_id', function ($data) {
                        return $data->pusatPengajian->nama ?? null;
                    })
                    ->addColumn('jabatan', function ($data) {
                        return $data->jabatan->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute . 'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pensyarah', 'orderable' => false],
                    ['data' => 'staff_id', 'name' => 'staff_id', 'title' => 'No. Staff', 'orderable' => false],
                    ['data' => 'pusat_pengajian_id', 'name' => 'pusat_pengajian_id', 'title' => 'Pusat Pengajian', 'orderable' => false],
                    ['data' => 'jabatan', 'name' => 'jabatan', 'title' => 'Jabatan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $pusat_pengajian = PusatPengajian::where('deleted_at', NULL)->pluck('nama', 'id');
            $jabatan = Jabatan::where('deleted_at', NULL)->pluck('nama', 'id');
            
            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'pusat_pengajian', 'jabatan'));

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
    public function show($id, Builder $builder,Request $request)
    {
        try {

            $title = 'Maklumat Jadual Penggantian Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual' => false,
                'Jadual Penggantian Pensyarah' => route($this->baseRoute . 'index'),
                'Maklumat Jadual Penggantian Pensyarah' => false,
            ];

            $modals = [
                [
                    'title' => 'Tambah Maklumat Jadual Penggantian',
                    'id' => '#addJadualPenggantian',
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = JadualPenggantianPensyarah::with('subjek', 'kelas')->where('staff_id', $id);
                if ($request->has('subjek') && $request->subjek != null) {
                    $data = $data->whereHas('subjek', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->subjek.'%');
                    });
                }
                if ($request->has('kelas') && $request->kelas != null) {
                    $data->where('kelas_id', $request->kelas);
                }
                if ($request->has('jenis') && $request->jenis != null) {
                    $data->where('jenis', $request->jenis);
                }

                return DataTables::of($data)
                    ->addColumn('kelas_id', function ($data) {
                        return $data->kelas->nama ?? null;
                    })
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        $tarikh = Utils::formatDate($data->tarikh);
                        return $tarikh;
                    })
                    ->addColumn('masa_mula', function ($data) {
                        return Utils::formatTime2($data->masa_mula).' - '.Utils::formatTime2($data->masa_akhir);
                    })
                    ->addColumn('hari', function ($data) {
                        $hari = $data->hari;

                        switch ($hari) {
                            case 1:
                                return 'Isnin';
                                break;
                            case 2:
                                return 'Selasa';
                                break;
                            case 3:
                                return 'Rabu';
                                break;
                            case 4:
                                return 'Khamis';
                                break;
                            case 5:
                                return 'Jumaat';
                                break;
                        }
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '
                            <a href="'.route('pengurusan.akademik.jadual.jadual_pensyarah.lecturer_timetable', [$data->id, $id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Muat Turun Jadual">
                                <i class="fa-solid fa-circle-down"></i>
                            </a>
                            ';
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
                    ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable' => false],
                    ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'hari', 'name' => 'hari', 'title' => 'Hari', 'orderable' => false],
                    ['data' => 'masa_mula', 'name' => 'masa_mula', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'catatan', 'name' => 'catatan', 'title' => 'Catatan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $kelas = Kelas::where('deleted_at', NULL)->pluck('nama', 'id');
            $jenis = [
                'ganti' => 'Ganti',
                'tidak_hadir' => 'Tidak hadir'
            ];
            $subjects = Subjek::all();

            $absent_data = JadualPenggantianPensyarah::where('jenis', 'tidak_hadir')->whereDate('tarikh', '>=', date(now()))->get();
            
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'kelas', 'jenis', 'id', 'absent_data', 'modals', 'subjects'));

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
}
