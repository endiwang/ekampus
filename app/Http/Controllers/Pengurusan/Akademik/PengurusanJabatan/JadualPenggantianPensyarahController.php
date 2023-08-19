<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Bilik;
use App\Models\Jabatan;
use App\Models\JadualPenggantianPensyarah;
use App\Models\Kelas;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\Subjek;
use Carbon\Carbon;
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = new JadualPenggantianPensyarah();
            $data->jenis        = $request->jenis;
            $data->staff_id = $request->staff_id;
            $data->kelas_id     = $request->kelas;
            $data->subjek_id    = $request->subjek;
            $data->tarikh       = !empty($request->tarikh) ? Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d') : null ;
            $data->masa_mula    = $request->masa_mula;
            $data->masa_akhir   = $request->masa_tamat;
            $data->catatan      = $request->catatan;
            $data->status       = $request->status;
            $data->save();
            
            Alert::toast('Maklumat jadual penggantian pensyarah berjaya ditambah!', 'success');

            return redirect()->route($this->baseRoute .'show', $request->staff_id);

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

            $buttons = [
                [
                    'title' => 'Tambah Jadual',
                    'route' => route($this->baseRoute . 'create_jadual', $id),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
                [
                    'title' => 'Muat Turun Jadual Ganti',
                    'route' => route($this->baseRoute . 'download', $id),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa-solid fa-circle-down',
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
                    ->addColumn('jenis', function ($data) {
                        $jenis = $data->jenis;

                        switch ($jenis) {
                            case 'ganti':
                                return 'Ganti Pensyarah';
                            break;

                            case 'tidak_hadir':
                                return 'Tidak Hadir';
                            break;
                        }
                    })
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
                            <a href="'.route('pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
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
        
            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');

            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(7);
            $absent_datas = JadualPenggantianPensyarah::where('jenis', 'tidak_hadir')->whereBetween('tarikh', [$startDate, $endDate])->get();
            
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'buttons', 
                    'dataTable', 'kelas', 'jenis', 'id','absent_datas', 'subjects', 'id'));
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
        try {

            $title = 'Kemaskini Maklumat Jadual Penggantian Pensyarah';
            $action = route($this->baseRoute . 'update', $id);
            $page_title = 'Maklumat Jadual Penggantian Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Jadual Penggantian Pensyarah' => route($this->baseRoute . 'index'),
                'Maklumat Jadual Penggantian Pensyarah' => route($this->baseRoute . 'show', $id),
                'Kemaskini Maklumat Jadual Penggantian Pensyarah' => false,
            ];

            $model = JadualPenggantianPensyarah::find($id);

            $kelas = Kelas::where('deleted_at', NULL)->pluck('nama', 'id');
            $jenis = [
                'ganti' => 'Ganti',
                'tidak_hadir' => 'Tidak hadir'
            ];
        
            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');
            $days = Utils::days();
            $times = Utils::times();
            $lecturers = Staff::all()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 
            'subjects', 'days', 'times', 'kelas', 'lecturers', 'jenis', 'id'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        try {
            
            $data = JadualPenggantianPensyarah::find($id);
            $data->jenis        = $request->jenis;
            if($request->jenis == 'tidak_hadir')
            {
                $data->staff_id = $request->staff_id;
            }
            $data->kelas_id     = $request->kelas;
            $data->subjek_id    = $request->subjek;
            $data->tarikh       = $request->tarikh;
            $data->masa_mula    = $request->masa_mula;
            $data->masa_akhir   = $request->masa_tamat;
            $data->catatan      = $request->catatan;
            $data->status       = $request->status;
            $data->save();
            
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
            
            $data = JadualPenggantianPensyarah::find($id)->delete();
            
            Alert::toast('Maklumat jadual penggantian pensyarah berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function createJadual($id)
    {
        try {

            $title = 'Tambah Maklumat Jadual Penggantian Pensyarah';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Maklumat Jadual Penggantian Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Jadual Penggantian Pensyarah' => route($this->baseRoute . 'index'),
                'Maklumat Jadual Penggantian Pensyarah' => route($this->baseRoute . 'show', $id),
                'Tambah Maklumat Jadual Penggantian Pensyarah' => false,
            ];

            $model = new JadualPenggantianPensyarah();

            $kelas = Kelas::where('deleted_at', NULL)->pluck('nama', 'id');
            $jenis = [
                'ganti' => 'Ganti',
                'tidak_hadir' => 'Tidak hadir'
            ];
        
            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');
            $days = Utils::days();
            $times = Utils::times();
            $lecturers = Staff::all()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 
            'subjects', 'days', 'times', 'kelas', 'lecturers', 'jenis', 'id'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadJadual($staff_id)
    {
        try {
            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $lecturer = Staff::select('nama')->find($staff_id);

            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(7);
            $datas = JadualPenggantianPensyarah::where('staff_id', $staff_id)
                    ->whereBetween('tarikh', [$startDate, $endDate])
                    ->where('jenis', 'ganti')->get();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.export_pdf', compact('datas', 'generated_at', 'lecturer'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
