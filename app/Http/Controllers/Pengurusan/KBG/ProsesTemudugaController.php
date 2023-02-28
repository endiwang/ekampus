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
use App\Models\PusatPengajian;
use App\Models\Temuduga;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class ProsesTemudugaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {


            $title = "Proses Temuduga";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Proses Temuduga" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Proses",
                    'route' => route('pengurusan.akademik.guru_tasmik.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Temuduga::all();
                return DataTables::of($data)

                ->addColumn('pusat_temuduga', function($data) {

                    $info = '<p>' . $data->nama_tempat . '<br/>'.$data->kursus->nama.'<br/> Ketua:</p>';

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
                            <a href="'.route('pengurusan.kbg.pengurusan.senarai_permohonan.pemohon',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
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

            return view('pages.pengurusan.kbg.proses_temuduga.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
        //
    }
}
