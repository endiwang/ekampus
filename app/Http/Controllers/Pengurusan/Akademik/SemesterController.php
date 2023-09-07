<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Semester;
use App\Models\SemesterKursus;
use App\Models\SemesterTerkini;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SemesterController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.semester.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Maklumat Semester';
            $breadcrumbs = [
                'Akademik' => false,
                'Maklumat Semester' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Semester',
                    'route' => route('pengurusan.akademik.semester.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = SemesterTerkini::with('kursus');
                if ($request->has('tahun_pengajian') && $request->tahun_pengajian != null) {
                    $data->where('sesi_pengajian', 'LIKE', '%'.$request->tahun_pengajian.'%');
                }
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }
                if ($request->has('semester') && $request->semester != null) {
                    $data->where('semester_no', $request->semester);
                }
                if ($request->has('status') && $request->status != null) {
                    $data->where('status', $request->status);
                }
                if ($request->has('status_keputusan') && $request->status_keputusan != null) {
                    $data->where('status_keputusan', $request->program_pengajian);
                }
                if ($request->has('status_ulangan') && $request->status_ulangan != null) {
                    $data->where('status_keputusan_ulangan', $request->status_ulangan);
                }

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('semester_name', function ($data) {
                        return $data->semester_name ?? null;
                    })
                    ->addColumn('status_semester', function ($data) {
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
                    ->addColumn('status_keputusan', function ($data) {
                        switch ($data->status_keputusan) {
                            case 0:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                                break;
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('status_keputusan_ulangan', function ($data) {
                        switch ($data->status_keputusan_ulangan) {
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
                        return '<a href="'.route('pengurusan.akademik.semester.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.semester.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['status_semester', 'status_keputusan', 'status_keputusan_ulangan', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Nama Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sesi_pengajian', 'name' => 'sesi_pengajian', 'title' => 'Tahun Pengajian', 'orderable' => false],
                    ['data' => 'semester_name', 'name' => 'semester_name', 'title' => 'Nama Semester - Semasa', 'orderable' => false],
                    ['data' => 'status_semester', 'name' => 'status_semester', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'status_keputusan', 'name' => 'status_keputusan', 'title' => 'Status Keputusan Peperiksaan', 'orderable' => false],
                    ['data' => 'status_keputusan_ulangan', 'name' => 'status_keputusan_ulangan', 'title' => 'Status Keputusan Ulangan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
            $semesters = Semester::where('deleted_at', null)->pluck('nama', 'id');
            $statuses = [
                '1' => 'Tidak Aktif',
                '0' => 'Aktif',
            ];

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'courses', 'semesters', 'statuses'));

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

            $title = 'Semester';
            $action = route('pengurusan.akademik.semester.store');
            $page_title = 'Tambah Semester';
            $breadcrumbs = [
                'Akademik' => false,
                'Maklumat Semester' => route('pengurusan.akademik.semester.index'),
                'Tambah Semester' => false,
            ];

            $model = new SemesterTerkini();

            for ($i = 2005; $i <= 2040; $i++) {
                $sesi[] = strval($i).'/'.strval($i + 1);
            }

            $semesters = [
                1 => 'Semester Satu',
                2 => 'Semester Dua',
                3 => 'Semester Tiga',
                4 => 'Semester Empat',
                5 => 'Semester Lima',
                6 => 'Semester Enam',
                7 => 'Semester Tujuh',
                8 => 'Semester Lapan',
            ];

            $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');

            $statuses = [
                0 => 'Tiada Keputusan',
                1 => 'Dipaparkan Untuk Semakan Pelajar',
            ];

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'sesi', 'kursus', 'semesters', 'statuses', 'action'));

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
            'program_pengajian' => 'required',
            'tahun_pengajian' => 'required',
            'nama_sesi_semasa' => 'required',
            'tarikh_daftar_pelajar' => 'required',
            'tarikh_mula_kuliah' => 'required',
            'tarikh_akhir_kuliah' => 'required',
            'tarikh_mula_daftar' => 'required',
            'tarikh_akhir_daftar' => 'required',
            'tarikh_mula_peperiksaan' => 'required',
            'tarikh_akhir_peperiksaan' => 'required',
            'tarikh_keputusan_peperiksaan' => 'required',
        ], [
            'program_pengajian.required' => 'Sila pilih program pengajian',
            'tahun_pengajian.required' => 'Sila pilih tahun pengajian',
            'nama_sesi_semasa.required' => 'Sila masukkan maklumat sesi semasa',
            'tarikh_daftar_pelajar.required' => 'Sila pilih tarikh daftar pelajar',
            'tarikh_mula_kuliah.required' => 'Sila pilih tarikh mula kuliah',
            'tarikh_akhir_kuliah.required' => 'Sila pilih tarikh akhir kuliah',
            'tarikh_mula_daftar.required' => 'Sila pilih mula daftar kursus',
            'tarikh_akhir_daftar.required' => 'Sila pilih akhir daftar kursus',
            'tarikh_mula_peperiksaan.required' => 'Sila pilih mula peperiksaan',
            'tarikh_akhir_peperiksaan.required' => 'Sila pilih akhir peperiksaan',
            'tarikh_keputusan_peperiksaan.required' => 'Sila pilih keputusan peperiksaan',
        ]);

        try {

            $semester_name = '';
            switch ($request->nama_semester) {
                case '1':
                    $semester_name = 'Semester Satu';
                break;

                case '2':
                    $semester_name = 'Semester Dua';
                break;

                case '3':
                    $semester_name = 'Semester Tiga';
                break;

                case '4':
                    $semester_name = 'Semester Empat';
                break;

                case '5':
                    $semester_name = 'Semester Lima';
                break;

                case '6':
                    $semester_name = 'Semester Enam';
                break;

                case '7':
                    $semester_name = 'Semester Tujuh';
                break;

                case '8':
                    $semester_name = 'Semester Lapan';
                break;
            }

            $semester = SemesterTerkini::create([
                'kursus_id' => $request->program_pengajian,
                'sesi_pengajian' => $request->tahun_pengajian,
                'sesi' => $request->nama_sesi_semasa,
                'semester_id' => $request->nama_semester,
                'semester_no' => $request->nama_semester,
                'semester_name' => $semester_name,
                'tarikh_daftar' => Carbon::createFromFormat('d/m/Y', $request->tarikh_daftar_pelajar)->format('Y-m-d'),
                'tarikh_mula_kuliah' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_kuliah)->format('Y-m-d'),
                'tarikh_akhir_kuliah' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_kuliah)->format('Y-m-d'),
                'tarikh_mula_daftar_kursus' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_daftar)->format('Y-m-d'),
                'tarikh_akhir_daftar_kursus' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_daftar)->format('Y-m-d'),
                'tarikh_mula_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_peperiksaan)->format('Y-m-d'),
                'tarikh_akhir_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_peperiksaan)->format('Y-m-d'),
                'tarikh_keputusan_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_keputusan_peperiksaan)->format('Y-m-d'),
                'status_keputusan' => $request->status_semester_1,
                'status_keputusan_2' => $request->status_semester_2,
                'status_keputusan_3' => $request->status_semester_3,
                'status_keputusan_4' => $request->status_semester_4,
                'status_keputusan_5' => $request->status_semester_5,
                'status_keputusan_6' => $request->status_semester_6,
                'status_keputusan_7' => $request->status_semester_7,
                'status_keputusan_8' => $request->status_semester_8,
                'status_keputusan_ulangan' => $request->status_keputusan_peperiksaan_ulangan,
                'status_semester' => $request->status,
            ]);

            //save into semester kursus table
            SemesterKursus::create([
                'kursus_id' => $request->program_pengajian,
                'semster_id' => $request->nama_semester,
                'status' => $request->status,
            ]);


            Alert::toast('Maklumat Semester Berjaya Ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.semester.index');

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

            $title = 'Semester';
            $action = route('pengurusan.akademik.semester.update', $id);
            $page_title = 'Pinda Semester';
            $breadcrumbs = [
                'Akademik' => false,
                'Maklumat Semester' => route('pengurusan.akademik.semester.index'),
                'Pinda Semester' => false,
            ];

            $model = SemesterTerkini::find($id);

            for ($i = 2005; $i <= 2040; $i++) {
                $sesi[] = strval($i).'/'.strval($i + 1);
            }

            $semesters = [
                1 => 'Semester Satu',
                2 => 'Semester Dua',
                3 => 'Semester Tiga',
                4 => 'Semester Empat',
                5 => 'Semester Lima',
                6 => 'Semester Enam',
                7 => 'Semester Tujuh',
                8 => 'Semester Lapan',
            ];

            $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');

            $statuses = [
                0 => 'Tiada Keputusan',
                1 => 'Dipaparkan Untuk Semakan Pelajar',
            ];

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'sesi', 'kursus', 'semesters', 'statuses', 'action'));

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

            $semester_name = '';
            switch ($request->nama_semester) {
                case '1':
                    $semester_name = 'Semester Satu';
                break;

                case '2':
                    $semester_name = 'Semester Dua';
                break;

                case '3':
                    $semester_name = 'Semester Tiga';
                break;

                case '4':
                    $semester_name = 'Semester Empat';
                break;

                case '5':
                    $semester_name = 'Semester Lima';
                break;

                case '6':
                    $semester_name = 'Semester Enam';
                break;

                case '7':
                    $semester_name = 'Semester Tujuh';
                break;

                case '8':
                    $semester_name = 'Semester Lapan';
                break;
            }

            SemesterTerkini::find($id)->update([
                'kursus_id' => $request->program_pengajian,
                'sesi_pengajian' => $request->tahun_pengajian,
                'sesi' => $request->nama_sesi_semasa,
                'semester_id' => $request->nama_semester,
                'semester_no' => $request->nama_semester,
                'semester_name' => $semester_name,
                'tarikh_daftar' => Carbon::createFromFormat('d/m/Y', $request->tarikh_daftar_pelajar)->format('Y-m-d'),
                'tarikh_mula_kuliah' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_kuliah)->format('Y-m-d'),
                'tarikh_akhir_kuliah' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_kuliah)->format('Y-m-d'),
                'tarikh_mula__kursus' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_daftar)->format('Y-m-d'),
                'tarikh_akhir__kursus' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_daftar)->format('Y-m-d'),
                'tarikh_mula_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_peperiksaan)->format('Y-m-d'),
                'tarikh_akhir_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_peperiksaan)->format('Y-m-d'),
                'tarikh_keputusan_peperiksaan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_keputusan_peperiksaan)->format('Y-m-d'),
                'status_keputusan' => $request->status_semester_1,
                'status_keputusan_2' => $request->status_semester_2,
                'status_keputusan_3' => $request->status_semester_3,
                'status_keputusan_4' => $request->status_semester_4,
                'status_keputusan_5' => $request->status_semester_5,
                'status_keputusan_6' => $request->status_semester_6,
                'status_keputusan_7' => $request->status_semester_7,
                'status_keputusan_8' => $request->status_semester_8,
                'status_keputusan_ulangan' => $request->status_keputusan_peperiksaan_ulangan,
                'status_semester' => $request->status,
            ]);

            SemesterKursus::updateOrCreate([
                'kursus_id' => $request->program_pengajian, 
                'semster_id' => $request->nama_semester,
            ],[
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat Semester Berjaya Dipinda!', 'success');

            return redirect()->route('pengurusan.akademik.semester.index');

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

            SemesterTerkini::find($id)->delete();

            Alert::toast('Maklumat semester berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
