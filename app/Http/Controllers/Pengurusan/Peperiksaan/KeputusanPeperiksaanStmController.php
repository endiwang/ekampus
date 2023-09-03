<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\PusatPengajian;
use App\Models\PusatPeperiksaan;
use App\Models\Temuduga;
use App\Models\TemudugaMarkah;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KeputusanPeperiksaanStmController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.keputusan_peperiksaan_stm.';
    protected $baseRoute = 'pengurusan.peperiksaan.keputusan_peperiksaan_stm.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Keputusan Peperiksaan STM';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Keputusan Peperiksaan STM' => false,
            ];

            if (request()->ajax()) {
                $data = Temuduga::where('is_close', 0)->where('is_sph', 0)->whereDate('tarikh', '>=', Carbon::now('Asia/Kuala_Lumpur'))
                    ->get();

                return DataTables::of($data)
                    ->addColumn('pusat_temuduga', function ($data) {

                        $ketua = $data->ketua != null ? $data->ketua->nama : 'N/A';
                        $info = '<p>'.$data->nama_tempat.'<br/>'.$data->kursus->nama.'<br/> Ketua: <span class="text-capitalize">'.$ketua.'</span></p>';

                        return $info;
                    })
                    ->addColumn('kod', function ($data) {
                        $kod = PusatPengajian::find($data->pusat_pengajian_id);
                        if ($kod != null) {
                            return $kod->kod;

                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute . 'export_senarai', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak markah temuduga" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>
                            
                            <a href="'.route($this->baseRoute . 'kemas_kini_markah', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Masukkan markah">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="'.route($this->baseRoute . 'pemohon', $data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tutup & simpan maklumat temuduga">
                                <i class="fa fa-times"></i>
                            </a>';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['pusat_temuduga', 'kod', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'class' => 'min-w-10px'],
                    ['data' => 'pusat_temuduga',      'name' => 'pusat_temuduga',           'title' => 'Pusat Temuduga', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kod',     'name' => 'no_ic',          'title' => 'Kod', 'orderable' => false],
                    ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-10px'],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    public function index2(Builder $builder, Request $request)
    {
        try {
        $title = 'Keputusan Peperiksaan STM';
        $breadcrumbs = [
            'Peperiksaan' => false,
            'Keputusan Peperiksaan STM' => false,
        ];

        if (request()->ajax()) {
            $data = Temuduga::where('is_close', 0)->where('is_sph', 0)->whereDate('tarikh', '<=', Carbon::now('Asia/Kuala_Lumpur'))
                ->get();

            return DataTables::of($data)
                ->addColumn('pusat_temuduga', function ($data) {

                    $ketua = $data->ketua != null ? $data->ketua->nama : 'N/A';
                    $info = '<p>'.$data->nama_tempat.'<br/>'.$data->kursus->nama.'<br/> Ketua: <span class="text-capitalize">'.$ketua.'</span></p>';

                    return $info;
                })
                ->addColumn('kod', function ($data) {
                    $kod = PusatPengajian::find($data->pusat_pengajian_id);
                    if ($kod != null) {
                        return $kod->kod;

                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="'.route($this->baseRoute . 'export_senarai', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak markah temuduga" target="_blank">
                            <i class="fa fa-print"></i>
                            </a>
                            
                            <a href="'.route($this->baseRoute . 'kemas_kini_markah', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Masukkan markah">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="'.route($this->baseRoute . 'pemohon', $data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tutup & simpan maklumat temuduga">
                                <i class="fa fa-times"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['pusat_temuduga', 'kod', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'class' => 'min-w-10px'],
                ['data' => 'pusat_temuduga',      'name' => 'pusat_temuduga',           'title' => 'Pusat Temuduga', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'kod',     'name' => 'no_ic',          'title' => 'Kod', 'orderable' => false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-10px'],

            ])
            ->minifiedAjax();

        $courses = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');

        return view($this->baseView.'main2', compact('title', 'breadcrumbs', 'dataTable', 'courses'));

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
        try {

            $store = TemudugaMarkah::find($request->id);
            $store->hafazan     = $request->hafazan;
            $store->tajwid      = $request->tajwid;
            $store->akhlak      = $request->akhlak;
            $store->akademik    = $request->akademik;
            $store->jumlah      = $request->jumlah;
            $store->catatan     = $request->catatan;
            $store->save();

            Alert::toast('Markah temuduga berjaya dikemaskini!', 'success');

            return redirect()->back();

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
            $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();

            $title = 'Kemaskini Keputusan STM';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Keputusan STM' => route($this->baseRoute. 'inedx'),
                'Kemaskini Keputusan STM' => false,
            ];

            $temuduga = Temuduga::find($id);

            return view($this->baseView . 'edit', compact('title', 'breadcrumbs', 'markah_temuduga', 'temuduga'));

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

    public function export_senarai($id)
    {

        $temuduga = Temuduga::find($id);
        // $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();
        $title = 'Temuduga Program '.$temuduga->tajuk_borang;

        $datas = $this->exportDataProcess($id);
        $view_file = 'pages.pengurusan.peperiksaan.keputusan_temuduga.export_pdf';
        $orientation = 'landscape';

        return Utils::pdfGenerate($title, $datas, $view_file, $orientation);
    }

    private function exportDataProcess($id)
    {

        $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->with('pemohon')->get();

        $temuduga = Temuduga::find($id);

        $datas = [
            'temuduga' => $temuduga,
            'markah_temuduga' => $markah_temuduga,
        ];

        return $datas;

    }
}
