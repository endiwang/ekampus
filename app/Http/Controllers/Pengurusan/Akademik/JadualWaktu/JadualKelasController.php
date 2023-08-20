<?php

namespace App\Http\Controllers\Pengurusan\Akademik\JadualWaktu;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Bilik;
use App\Models\JadualPensyarah;
use App\Models\JadualPensyarahDetail;
use App\Models\JadualWaktu;
use App\Models\JadualWaktuDetail;
use App\Models\Kelas;
use App\Models\PensyarahKelas;
use App\Models\Staff;
use App\Models\Subjek;
use App\Services\CalendarService;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class JadualKelasController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.jadual.jadual_kelas.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Jadual Waktu Kelas';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual Waktu Kelas' => false,
            ];

            if (request()->ajax()) {
                $data = Kelas::with('jadualKelas', 'pusatPengajian', 'currentSemester')->where('deleted_at', null)->where('status', 0);

                return DataTables::of($data)
                    ->addColumn('pusat_pengajian_id', function ($data) {
                        return $data->pusatPengajian->nama ?? null;
                    })
                    ->addColumn('sesi', function ($data) {
                        return $data->sesi ?? null;
                    })
                    ->addColumn('semasa_semester_id', function ($data) {
                        return $data->currentSemester->nama ?? null;
                    })
                    ->addColumn('status', function ($data) {
                        if (! empty($data->jadualKelas->status)) {
                            if ($data->jadualKelas->status == 1) {
                                return 'Belum Disahkan';
                            } elseif ($data->jadualKelas->status == 2) {
                                return 'Telah Disahkan';
                            }
                        } else {
                            return 'Tiada Maklumat Jadual';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.jadual.jadual_kelas.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Kelas', 'orderable' => false],
                    ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'semasa_semester_id', 'name' => 'semasa_semester_id', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'pusat_pengajian_id', 'name' => 'pusat_pengajian_id', 'title' => 'Pusat Pengajian', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
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
        //dd($request->all());
        // $validation = $request->validate([
        //     'hari'          => 'required',
        //     'subjek'        => 'required',
        //     'masa_mula'     => 'required',
        //     'masa_tamat'    => 'required',
        // ],[
        //     'hari.required'         => 'Sila pilih hari',
        //     'subjek.required'       => 'Sila pilih subjek',
        //     'masa_mula.required'    => 'Sila pilih masa mula',
        //     'masa_tamat.required'   => 'Sila pilih masa tamat',
        // ]);

        // try {
        $kelas = Kelas::find($request->kelas_id);

        $jadual_waktu = JadualWaktu::updateOrCreate([
            'kelas_id' => $request->kelas_id,
            'pengajian_id' => $request->pusat_pengajian_id,
            'semester_id' => $kelas->semasa_semester_id,
        ]);

        $subjek = Subjek::select('kredit')->find($request->subjek);

        $jadual_detail = new JadualWaktuDetail();
        $jadual_detail->jadual_waktu_id = $jadual_waktu->id;
        $jadual_detail->subjek_id = $request->subjek;
        $jadual_detail->jam_kredit = $subjek->kredit;
        $jadual_detail->staff_id = $request->pensyarah;
        $jadual_detail->hari = $request->hari;
        $jadual_detail->masa_mula = $request->masa_mula;
        $jadual_detail->masa_akhir = $request->masa_tamat;
        $jadual_detail->lokasi = $request->lokasi;
        $jadual_detail->jenis = $request->jenis;
        $jadual_detail->save();

        //save into pensyarah_kelas table
        $pensyarah_kelas = new PensyarahKelas();
        $pensyarah_kelas->staff_id = $request->pensyarah;
        $pensyarah_kelas->subjek_id = $request->subjek;
        $pensyarah_kelas->kelas_id = $request->kelas_id;
        $pensyarah_kelas->save();

        //save into pensyarah table
        $pensyarah = JadualPensyarah::updateOrCreate([
            'jadual_waktu_id' => $jadual_waktu->id,
            'staff_id' => $request->pensyarah,
            'semester_id' => $kelas->semasa_semester_id,
            'sesi_id' => $kelas->sesi,
        ]);

        $jadual_pensyarah_detail = new JadualPensyarahDetail();
        $jadual_pensyarah_detail->jadual_pensyarah_id = $pensyarah->id;
        $jadual_pensyarah_detail->jadual_waktu_detail_id = $jadual_detail->id;
        $jadual_pensyarah_detail->staff_id = $request->pensyarah;
        $jadual_pensyarah_detail->subjek_id = $request->subjek;
        $jadual_pensyarah_detail->kelas_id = $request->kelas_id;
        $jadual_pensyarah_detail->hari = $request->hari;
        $jadual_pensyarah_detail->masa_mula = $request->masa_mula;
        $jadual_pensyarah_detail->masa_akhir = $request->masa_tamat;
        $jadual_pensyarah_detail->lokasi = $request->lokasi;
        $jadual_pensyarah_detail->save();

        Alert::toast('Maklumat Subjek berjaya disimpan!', 'success');

        return redirect()->back();

        // }catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
            $timetable = JadualWaktu::with('kelas')->where('kelas_id', $id)->where('status_pengajian', 1)->first();

            $class = Kelas::find($id);
            $title = 'Jadual Waktu Bagi '.$class->nama;
            $action = route('pengurusan.akademik.jadual.jadual_kelas.update_status', $id);
            $page_title = 'Maklumat Jadual Waktu';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual Waktu Kelas' => route('pengurusan.akademik.jadual.jadual_kelas.index'),
                'Maklumat Jadual Waktu' => false,
            ];

            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');
            $locations = Bilik::where('is_deleted', 0)->get()->pluck('nama_bilik', 'id');
            $days = Utils::days();
            $times = Utils::times();
            $lecturers = Staff::all()->pluck('nama', 'id');

            $statuses = [
                1 => 'Belum Diluluskan',
                2 => 'Telah Diluluskan',
            ];

            $types = [
                'kuliah' => 'Kuliah',
                'tutorial' => 'Tutorial',
            ];

            if (request()->ajax()) {
                if (! empty($timetable->id)) {
                    $data = JadualWaktuDetail::with('subjek', 'staff')->where('jadual_waktu_id', $timetable->id);
                } else {
                    $data = [];
                }

                return DataTables::of($data)
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('staff_id', function ($data) {
                        return $data->staff->nama ?? null;
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
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime2($data->masa_mula).' - '.Utils::formatTime2($data->masa_akhir);
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.jadual.jadual_kelas.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('hari', 'asc')->orderBy('masa_mula', 'asc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'subjek_id', 'name' => 'file_name', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'jam_kredit', 'name' => 'created_at', 'title' => 'Jam Kredit', 'orderable' => false],
                    ['data' => 'staff_id', 'name' => 'created_at', 'title' => 'Pensyarah', 'orderable' => false],
                    ['data' => 'hari', 'name' => 'created_at', 'title' => 'Hari', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'created_at', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'lokasi', 'name' => 'created_at', 'title' => 'Lokasi', 'orderable' => false],
                    ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'create-update', compact(
                'title',
                'breadcrumbs',
                'dataTable',
                'page_title',
                'action',
                'subjects',
                'locations',
                'days',
                'timetable',
                'statuses',
                'id',
                'class',
                'times',
                'lecturers',
                'types'
            ));

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
            JadualWaktu::updateOrCreate([
                'kelas_id' => $id,
                'pengajian_id' => $request->pusat_pengajian_id,
            ], [
                'status' => $request->status,
                'created_by' => auth()->user()->id,
            ]);

            Alert::toast('Maklumat status jadual berjaya dikemaskini!', 'success');

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
            $jadual_detail = JadualWaktuDetail::find($id);

            $pensyarah = PensyarahKelas::where('staff_id', $jadual_detail->staff_id)->where('subjek_id', $jadual_detail->subjek_id)->first();
            $pensyarah = $pensyarah->delete();

            $jadual_pensyarah = JadualPensyarahDetail::where('jadual_waktu_detail_id', $id)->first();
            $jadual_pensyarah = $jadual_pensyarah->delete();

            $jadual_detail = $jadual_detail->delete();

            Alert::toast('Maklumat subjek berjaya dipadam!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadTimetable(CalendarService $calendarService, $id)
    {
        try {
            $detail = JadualWaktu::where('kelas_id', $id)->first();
            $kelas = Kelas::find($detail->kelas_id);

            $status = '';
            if ($detail->status == 1) {
                $status = 'Belum Disahkan';
            } elseif ($detail->status == 2) {
                $status = 'Telah Disahkan';
            } else {
                $status = 'Tiada Status';
            }

            $days = Utils::days();
            $calendarData = $calendarService->generateCalendarData($days, $detail->id);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.timetable_pdf', compact('detail', 'days', 'status', 'kelas', 'calendarData'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
