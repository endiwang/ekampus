<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\Permohonan;
use App\Models\OldDatabase\sis_tblpermohonan;
use App\Helpers\Utils;
use App\Models\Negeri;
use App\Models\OldDatabase\sis_tblpermohonan_pelajaran;
use App\Models\PermohonanXHantarKelulusanAkademik;
use App\Models\Temuduga;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use App\Models\SubjekSPM;
use App\Models\Kursus;
use App\Models\Sesi;

class SenaraiTapisanPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {

        try {


            $title = "Senarai Tapisan Permohonan";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Senarai Tapisan Permohonan" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Proses Pemilihan",
                    'route' => route('pengurusan.kbg.pengurusan.senarai_tapisan_permohonan.proses_pemilihan'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
            $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');


            if (request()->ajax()) {
                $data = Permohonan::where('is_submitted',1)->where('is_deleted',0)->where('is_selected',1)->where('is_tawaran',0)->where('is_interview',0);
                if($request->has('kursus') && $request->kursus != NULL)
                {
                    $data = $data->where('kursus_id', $request->kursus);
                }
                if($request->has('sesi') && $request->sesi != NULL)
                {
                    $data = $data->where('sesi_id', $request->sesi);
                }
                return DataTables::of($data->get())
                ->addColumn('nama', function($data) {
                    return $data->nama ?? null;
                })
                ->addColumn('kursus', function($data) {
                    if(!empty($data->kursus_id))
                    {
                        return $data->kursus->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('tarikh_permohonan', function($data){
                    $tarikh_permohonan = Utils::formatDate($data->submitted_date);
                    return $tarikh_permohonan;
                })
                // ->addColumn('action', function($data){
                //     return '
                //             <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                //                 <i class="fa fa-pencil-alt"></i>
                //             </a>';

                // })
                ->addIndexColumn()
                ->rawColumns(['nama','kursus','status', 'action','tarikh_permohonan'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pemohon', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'kursus',      'name' => 'kursus',         'title' => 'Jenis Permohonan', 'orderable'=> false],
                ['data' => 'tarikh_permohonan',   'name' => 'tarik_permohonan',   'title' => 'Tarikh Permohonan', 'orderable'=> false],
                // ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'min-w-100px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.senarai_tapisan_permohonan.main', compact('title', 'breadcrumbs','buttons','dataTable','kursus','sesi'));

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

    }

    public function proses_pemilihan(Builder $builder, Request $request)
    {
        $kursus = Kursus::where('is_deleted',0)->pluck('nama', 'id');
        $sesi = Sesi::where('is_deleted',0)->pluck('nama', 'id');


        $sesi_id = $request->sesi;
        $kursus_id = $request->kursus;

        $subjek_spm = SubjekSPM::where('status',0)->get();

        $permohonan = Permohonan::where('kursus_id',$kursus_id)->where('sesi_id', $sesi_id)->where('is_deleted' ,0)->where('is_submitted' , 1)->where('is_selected' , 0)->where('is_interview',0)->where('is_tawaran',0)->with('akademik');

        if($subjek_spm)
        {
            foreach($subjek_spm as $subjek)
            {
                if($request->has($subjek->slug) && $request->input($subjek->slug) != NULL)
                {
                    $permohonan->whereHas('akademik', function ($query) use ($subjek,$request) {
                            $query  ->where('type', '=', 'spm')
                                    ->where('matapelajaran', '=',$subjek->nama)
                                    ->where('gred', '=', $request->input($subjek->slug));

                    });
                }
            }
        }

        $permohonan->get();




        $title = "Proses Pemilihan";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Senarai Tapisan Permohonan" =>  false,
                "Proses Pemilihan" =>  false,
            ];

            // $buttons = [
            //     [
            //         'title' => "Proses Pemilihan",
            //         'route' => route('pengurusan.kbg.pengurusan.senarai_tapisan_permohonan.proses_pemilihan'),
            //         'button_class' => "btn btn-sm btn-primary fw-bold",
            //         'icon_class' => "fa fa-plus-circle"
            //     ],
            // ];

            // if ($permohonan) {
            if (request()->ajax() && $permohonan) {
                    $data = $permohonan->get();
                return DataTables::of($data)
                ->addColumn('nama', function($data) {
                    return $data->nama ?? null;
                })
                ->addColumn('kursus', function($data) {
                    if(!empty($data->kursus_id))
                    {
                        return $data->kursus->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('tarikh_permohonan', function($data){
                    $tarikh_permohonan = Utils::formatDate($data->submitted_date);
                    return $tarikh_permohonan;
                })
                // ->addColumn('action', function($data){
                //     return '
                //             <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                //                 <i class="fa fa-pencil-alt"></i>
                //             </a>';

                // })
                ->addIndexColumn()
                ->rawColumns(['nama','kursus','status', 'action','tarikh_permohonan'])
                ->toJson();
            }


            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pemohon', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'kursus',      'name' => 'kursus',         'title' => 'Jenis Permohonan', 'orderable'=> false],
                ['data' => 'tarikh_permohonan',   'name' => 'tarik_permohonan',   'title' => 'Tarikh Permohonan', 'orderable'=> false],
                // ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'min-w-100px'],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.senarai_tapisan_permohonan.proses_memilih', compact('title', 'breadcrumbs','dataTable','kursus','sesi','subjek_spm'));


        // dd($permohonan->get());

    }
}
