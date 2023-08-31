<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PermohonanSijilTahfiz;
use Illuminate\Http\Request;

class MainPengajianSepanjangHayatController extends Controller
{
    public function index()
    {
        $data['title'] = 'Pengajian Sepanjang Hayat';
        $data['breadcrumbs'] = [
            'Pengajian Sepanjang Hayat' => false,
        ];

        $data['permohonan_all'] = PermohonanSijilTahfiz::where('status', 2)->count();
        $data['lulus_all'] = PemarkahanCalonSijilTahfiz::where('status_kelulusan', 1)->where('approval', 1)->count();
        $data['hadir_temuduga_all'] = PermohonanSijilTahfiz::where('status_tawaran', 1)
            ->where('status_hadir_peperiksaan', 0)
            ->count();
        $data['markah_belum_disahkan'] = PemarkahanCalonSijilTahfiz::where('approval', 0)
            ->where('status_hadir_ujian_shafawi', 1)
            ->where('status_hadir_ujian_tahriri', 1)
            ->where('status_hadir_ujian_pengetahuan_islam', 1)
            ->count();
        return view('pages.pengurusan.pengajian_sepanjang_hayat.dashboard.main')->with($data);
    }
}
