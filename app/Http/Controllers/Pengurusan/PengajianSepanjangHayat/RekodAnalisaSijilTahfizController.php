<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PusatPeperiksaan;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class RekodAnalisaSijilTahfizController extends Controller
{
    public function index(Builder $builder, Request $request)
    {
        $title = 'Laporan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Laporan' => '#',
            'Senarai Laporan' => '#',
        ];

        $reports = [
            [
                'name' => 'Statistik Permohonan Mengikut Negeri',
                'action' => '
                        <a href="'.route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.show', 'negeri').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Rekod Permohonan Mengikut Zon Peperiksaan">
                            <i class="fa fa-eye"></i>
                        </a>',
            ],
            [
                'name' => 'Statistik Permohonan Mengikut Siri Peperiksaan',
                'action' => '
                        <a href="'.route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.show', 'siri_peperiksaan').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Rekod Permohonan Mengikut Siri Peperiksaan">
                            <i class="fa fa-eye"></i>
                        </a>',
            ],
            [
                'name' => 'Statistik Permohonan Mengikut Peringkat Kelulusan',
                'action' => '
                        <a href="'.route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.show', 'kelulusan').'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Rekod Permohonan Mengikut Siri Peperiksaan">
                            <i class="fa fa-eye"></i>
                        </a>',
            ],
        ];

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'reports' => $reports,
            // 'rekod_filter' => $rekod_filter,
            // 'age_filter' => $age_filter,
            // 'jenis_pengajian' => $jenis_pengajian,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.main', $data);
    }

    public function show($id)
    {
        $title = 'Rekod Analisa';
        $age_filter = [];
        for ($i = 17; $i <= 50; $i++) {
            $age_filter[$i] = $i;
        }

        $jenis_pengajian = [
            1 => 'Kerajaan',
            2 => 'Swasta',
        ];

        switch ($id) {
            case 'negeri':
                $breadcrumbs = [
                    'Akademik' => false,
                    'Laporan' => false,
                    'Rekod Permohonan Mengikut Zon Peperiksaan',
                ];

                $page_title = 'Rekod Permohonan Mengikut Zon Peperiksaan';
                $action = route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.analisa_negeri');

                $data = [
                    'age_filter' => $age_filter,
                    'jenis_pengajian' => $jenis_pengajian,
                    'breadcrumbs' => $breadcrumbs,
                    'title' => $title,
                    'action' => $action,
                    'page_title' => $page_title,
                ];

                return view('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.show', $data);
                break;

            case 'siri_peperiksaan':
                $breadcrumbs = [
                    'Akademik' => false,
                    'Laporan' => false,
                    'Rekod Permohonan Mengikut Siri Peperiksaan',
                ];

                $page_title = 'Rekod Permohonan Mengikut Siri Peperiksaan';
                $action = route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.analisa_siri_peperiksaan');

                $data = [
                    'age_filter' => $age_filter,
                    'jenis_pengajian' => $jenis_pengajian,
                    'breadcrumbs' => $breadcrumbs,
                    'title' => $title,
                    'action' => $action,
                    'page_title' => $page_title,
                ];

                return view('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.show', $data);
                break;

            case 'kelulusan':
                return redirect()->route('pengurusan.pengajian_sepanjang_hayat.laporan.rekod_analisa.analisa_peringkat_kelulusan');
                break;
        }
    }

    public function analisa_negeri(Request $request)
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        $generated_at = Carbon::now()->format('d/m/Y H:i A');
        $datas = PusatPeperiksaan::with('permohonanSijilTahfizs');
        $datas->whereHas('permohonanSijilTahfizs', function ($q) use ($request, $currentYear, $previousYear) {
            if (! empty($request->age)) {
                $q->where('age', $request->age);
            }
            if (! empty($request->jenis_pengajian)) {
                $q->where('jenis_pengajian', $request->jenis_pengajian);
            }
            if (! empty($request->gender)) {
                $q->where('gender', $request->gender);
            }
            $q->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            });
        });

        $datas = $datas->get();

        $data = [
            'generated_at' => $generated_at,
            'datas' => $datas,
        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.analisa_negeri_pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function analisa_siri_peperiksaan(Request $request)
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        $generated_at = Carbon::now()->format('d/m/Y H:i A');
        $datas = TetapanPeperiksaanSijilTahfiz::with('permohonanSijilTahfizs');
        $datas->whereHas('permohonanSijilTahfizs', function ($q) use ($request, $currentYear, $previousYear) {
            if (! empty($request->age)) {
                $q->where('age', $request->age);
            }
            if (! empty($request->jenis_pengajian)) {
                $q->where('jenis_pengajian', $request->jenis_pengajian);
            }
            if (! empty($request->gender)) {
                $q->where('gender', $request->gender);
            }
            $q->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            });
        });

        $datas = $datas->get();

        $data = [
            'generated_at' => $generated_at,
            'datas' => $datas,
        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.analisa_siri_peperiksaan_pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function analisa_peringkat_kelulusan(Request $request)
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        $generated_at = Carbon::now()->format('d/m/Y H:i A');

        $mumtaz = PemarkahanCalonSijilTahfiz::where('keputusan_peperiksaan', 'Mumtaz')
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            })->get()->count();
        $jayyid_jiddan = PemarkahanCalonSijilTahfiz::where('keputusan_peperiksaan', 'Jayyid Jiddan')
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            })->get()->count();
        $jayyid = PemarkahanCalonSijilTahfiz::where('keputusan_peperiksaan', 'Jayyid')
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            })->get()->count();
        $maqbul = PemarkahanCalonSijilTahfiz::where('keputusan_peperiksaan', 'Maqbul')
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            })->get()->count();
        $rasib = PemarkahanCalonSijilTahfiz::where('keputusan_peperiksaan', 'Rasib')
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                    ->orWhereYear('created_at', $previousYear);
            })->get()->count();

        $datas = [
            'Mumtaz' => $mumtaz,
            'Jayyid Jiddan' => $jayyid_jiddan,
            'Jayyid' => $jayyid,
            'Maqbul' => $maqbul,
            'Rasib' => $rasib,
        ];

        $data = [
            'generated_at' => $generated_at,
            'datas' => $datas,
        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.rekod_analisa.analisa_peringkat_kelulusan_pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
}
