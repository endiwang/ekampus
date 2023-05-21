<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Temuduga;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\PusatPengajian;
use App\Models\TemudugaMarkah;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;


class KeputusanTemudugaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {


            $title = "Keputusan Temuduga";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Keputusan Temuduga" =>  false,
            ];

            if (request()->ajax()) {
                $data = Temuduga::where('is_close',0)->where('is_sph',0)->whereDate('tarikh', '>=', Carbon::now('Asia/Kuala_Lumpur'))
                ->get();
                return DataTables::of($data)

                ->addColumn('pusat_temuduga', function($data) {

                    $ketua = $data->ketua != NULL ? $data->ketua->nama : 'N/A';
                    $info = '<p>' . $data->nama_tempat . '<br/>'.$data->kursus->nama.'<br/> Ketua: <span class="text-capitalize">'.$ketua.'</span></p>';

                    return $info;
                })
                ->addColumn('kod', function($data){
                    $kod = PusatPengajian::find($data->pusat_pengajian_id);
                    if($kod != NULL)
                    {
                        return $kod->kod;

                    }
                })

                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak markah temuduga">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-warning btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hantar senarai keputusan ke format Excel">
                                <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.keputusan_temuduga.kemas_kini_markah',$data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Masukkan markah">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tutup & simpan maklumat temuduga">
                                <i class="fa fa-times"></i>
                            </a>';
                })

                ->addIndexColumn()
                ->rawColumns(['pusat_temuduga','kod','action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'class'=>'min-w-10px'],
                ['data' => 'pusat_temuduga',      'name' => 'pusat_temuduga',           'title' => 'Pusat Temuduga', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kod',     'name' => 'no_ic',          'title' => 'Kod', 'orderable'=> false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'max-w-10px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.keputusan_temuduga.main', compact('title', 'breadcrumbs', 'dataTable'));

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

        $markah = TemudugaMarkah::updateOrCreate(
            [
                'id'     => $request->id,
            ],
            [
                'hafazan'           => $request->hafazan,
                'tajwid'            => $request->tajwid,
                'akhlak'            => $request->akhlak,
                'akademik'          => $request->akademik,
                'jumlah'            => $request->jumlah,
                'catatan'            => $request->catatan,
            ]);
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

    public function kemas_kini_markah($id)
    {
        $markah_temuduga = TemudugaMarkah::where('temuduga_id', $id)->get();

        $title = "Kemas Kini Markah Temuduga";
        $breadcrumbs = [
            "Kemasukan Biasiswa Graduasi" =>  false,
            "Keputusan Temuduga" =>  false,
            "Kemas Kini Markah" =>  false,
        ];

        $temuduga = Temuduga::find($id);

        return view('pages.pengurusan.kbg.keputusan_temuduga.kemas_kini_markah', compact('title', 'breadcrumbs', 'markah_temuduga','temuduga'));


    }
}
