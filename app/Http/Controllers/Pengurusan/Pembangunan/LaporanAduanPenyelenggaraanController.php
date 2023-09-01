<?php

namespace App\Http\Controllers\Pengurusan\Pembangunan;

use App\Http\Controllers\Controller;
use App\Models\AduanPenyelenggaraan;
use Illuminate\Http\Request;

class LaporanAduanPenyelenggaraanController extends Controller
{
    protected $baseView = 'pages.pengurusan.pembangunan.laporan.aduan_penyelenggaraan.';
    protected $baseRoute = 'pengurusan.pembangunan.laporan.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['title'] = 'Laporan Pembangunan';
        $data['breadcrumbs'] = [
            'Pembangunan' => false,
            'Laporan' => false,
            'Laporan Pembangunan' => false,
            'Laporan Aduan Penyelenggaraan' => false,
        ];
        $data['action'] = route('pengurusan.pembangunan.laporan.export_aduan_penyelenggaraan');

        return view($this->baseView . 'list')->with($data);
    }
    
    public function exportAduanPenyelenggaraan(Request $request)
    {
        // dd($request->all());
        $data['date_start'] = $request->date_start;
        $data['date_end'] = $request->date_end;
        $results = AduanPenyelenggaraan::where(\DB::raw('DATE(created_at)'), '>=', $request->date_start)->where(\DB::raw('DATE(created_at)'), '<=', $request->date_end);
        
        if(!empty($request->status))
        {
            $results->where('status', $request->status);
        }

        $data['results'] = $results->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView($this->baseView.'.export', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();

    }
}
