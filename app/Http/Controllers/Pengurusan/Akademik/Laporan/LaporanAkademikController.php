<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PusatPengajian;
use App\Models\SemesterTerkini;
use App\Models\Sesi;
use App\Models\Syukbah;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanAkademikController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.laporan.akademik.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $title = 'Laporan Akademik';
            $page_title = 'Senarai Laporan Akademik';
            $breadcrumbs = [
                'Akademik' => false,
                'Laporan' => false,
                'Laporan Akademik' => false,
            ];

            $reports = [
                [
                    'name' => 'Senarai Pelajar Mengulang',
                    'action' => '
                            <a href="'.route('pengurusan.akademik.laporan.akademik.show', 'pelajar_mengulang').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Laporan Pelajar Mengulang">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Senarai Pelajar Gagal & Ulangan',
                    'action' => '
                            <a href="'.route('pengurusan.akademik.laporan.akademik.show', 'pelajar_gagal_dan_ulangan').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Laporan Pelajar Gagal & Ulangan">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
                [
                    'name' => 'Senarai Pendaftaran Pelajar',
                    'action' => '
                            <a href="'.route('pengurusan.akademik.laporan.akademik.show', 'pendaftaran_pelajar').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Laporan Pendaftaran Pelajar">
                                <i class="fa fa-eye"></i>
                            </a>',
                ],
            ];

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'page_title', 'reports'));

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // try {
        $title = 'Laporan Akademik';

        $type = $id;

        $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        $campuses = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
        $exam_sessions = SemesterTerkini::where('deleted_at', null)->pluck('sesi', 'id');
        $syukbah = Syukbah::where('deleted_at', null)->pluck('nama', 'id');
        $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');

        switch ($type) {
            case 'pelajar_mengulang':
                $breadcrumbs = [
                    'Akademik' => false,
                    'Laporan' => false,
                    'Laporan Akademik' => route('pengurusan.akademik.laporan.akademik.index'),
                    'Laporan Senarai Pelajar Mengulang' => false,
                ];

                $page_title = 'Laporan Senarai Pelajar Mengulang';
                $action = route('pengurusan.akademik.laporan.akademik.export_senarai_pelajar_mengulang');

                return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'courses', 'campuses', 'exam_sessions', 'syukbah', 'sessions', 'action'));
                break;

            case 'pelajar_gagal_dan_ulangan':
                $breadcrumbs = [
                    'Akademik' => false,
                    'Laporan' => false,
                    'Laporan Akademik' => route('pengurusan.akademik.laporan.akademik.index'),
                    'Laporan Senarai Pelajar Gagal dan Ulangan' => false,
                ];

                $page_title = 'Laporan Senarai Pelajar Gagal dan Ulangan';
                $action = route('pengurusan.akademik.laporan.akademik.export_senarai_pelajar_gagal_dan_ulangan');

                return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'courses', 'campuses', 'exam_sessions', 'syukbah', 'sessions', 'action'));
                break;

            case 'pendaftaran_pelajar':
                $breadcrumbs = [
                    'Akademik' => false,
                    'Laporan' => false,
                    'Laporan Akademik' => route('pengurusan.akademik.laporan.akademik.index'),
                    'Laporan Senarai Pendaftaran Pelajar' => false,
                ];
                $page_title = 'Laporan Senarai Pendaftaran Pelajar';
                $action = route('pengurusan.akademik.laporan.akademik.export_senarai_pendaftaran_pelajar');

                return view($this->baseView.'senarai_pendaftaran_pelajar', compact('title', 'breadcrumbs', 'page_title', 'courses', 'campuses', 'syukbah', 'sessions', 'action'));
                break;
        }

        // }catch (Exception $e) {
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

    public function exportPelajarMengulang(Request $request)
    {
        try {
            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $datas = Pelajar::select('id', 'user_id', 'nama', 'kursus_id', 'syukbah_id', 'sesi_id', 'semester', 'pusat_pengajian_id', 'no_matrik',
                'no_ic', 'jantina', )
                ->with('syukbah')->where('is_berhenti', 0)->where('is_deleted', 0);
            if (! empty($request->program_pengajian)) {
                $datas = $datas->where('kursus_id', $request->program_pengajian);
            }
            if (! empty($request->pusat_pengajian)) {
                $datas = $datas->where('pusat_pengajian_id', $request->pusat_pengajian);
            }
            if (! empty($request->syukbah)) {
                $datas = $datas->where('syukbah_id', $request->syukbah);
            }
            if (! empty($request->sesi)) {
                $datas = $datas->where('sesi_id', $request->sesi);
            }
            if (! empty($request->sesi_peperiksaan)) {
                $datas = $datas->where('sesi_id', $request->sesi);
            }
            $datas = $datas->get();

            $sesi = $request->sesi;
            $program_pengajian = Kursus::find($request->program_pengajian);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.pelajar_mengulang_pdf', compact('generated_at', 'datas', 'program_pengajian', 'sesi'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportPelajarGagalDanUlangan(Request $request)
    {
        try {
            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $datas = Pelajar::select('id', 'user_id', 'nama', 'kursus_id', 'syukbah_id', 'sesi_id', 'semester', 'pusat_pengajian_id', 'no_matrik',
                'no_ic', 'jantina', )
                ->with('syukbah')->where('is_berhenti', 0)->where('is_deleted', 0);
            if (! empty($request->program_pengajian)) {
                $datas = $datas->where('kursus_id', $request->program_pengajian);
            }
            if (! empty($request->pusat_pengajian)) {
                $datas = $datas->where('pusat_pengajian_id', $request->pusat_pengajian);
            }
            if (! empty($request->syukbah)) {
                $datas = $datas->where('syukbah_id', $request->syukbah);
            }
            if (! empty($request->sesi)) {
                $datas = $datas->where('sesi_id', $request->sesi);
            }
            if (! empty($request->sesi_peperiksaan)) {
                $datas = $datas->where('sesi_id', $request->sesi);
            }
            $datas = $datas->get();

            $sesi = $request->sesi;
            $program_pengajian = Kursus::find($request->program_pengajian);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.pelajar_gagal_dan_ulangan_pdf', compact('generated_at', 'datas', 'program_pengajian', 'sesi'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function exportPendaftaranPelajar(Request $request)
    {
        try {

            $generated_at = Carbon::now()->format('d/m/Y H:i A');

            $datas = Pelajar::select('id', 'user_id', 'nama', 'kursus_id', 'syukbah_id', 'sesi_id', 'semester', 'pusat_pengajian_id', 'no_matrik',
                'no_ic', 'jantina', )
                ->with('syukbah')->where('is_berhenti', 0)->where('is_deleted', 0);
            if (! empty($request->program_pengajian)) {
                $datas = $datas->where('kursus_id', $request->program_pengajian);
            }
            if (! empty($request->pusat_pengajian)) {
                $datas = $datas->where('pusat_pengajian_id', $request->pusat_pengajian);
            }
            if (! empty($request->syukbah)) {
                $datas = $datas->where('syukbah_id', $request->syukbah);
            }
            if (! empty($request->sesi)) {
                $datas = $datas->where('sesi_id', $request->sesi);
            }
            $datas = $datas->get();

            $sesi = $request->sesi;
            $program_pengajian = Kursus::find($request->program_pengajian);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.pendaftaran_pelajar_pdf', compact('generated_at', 'datas', 'program_pengajian', 'sesi'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
