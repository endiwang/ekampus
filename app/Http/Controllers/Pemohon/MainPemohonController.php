<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\TetapanPermohonanPelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MainPemohonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permohonan = TetapanPermohonanPelajar::whereDate('tutup_permohonan', '>=', Carbon::now('Asia/Kuala_Lumpur'))->get();
        $kursus_pilihan = TetapanPermohonanPelajar::select('kursus_id')->whereDate('tutup_permohonan', '>=', Carbon::now('Asia/Kuala_Lumpur'))->groupBy('kursus_id')->get();
        return view('pages.pemohon.dashboard.main', compact('permohonan','kursus_pilihan'));
    }


}
