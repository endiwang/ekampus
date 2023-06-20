<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\IjazahLatihanIndustri;
use App\Models\Pelajar;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodLatihanIndustriController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_ijazah.latihan_industri.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Rekod Latihan Industri";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Latihan Industri" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Latihan Industri",
                    'route' => route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = IjazahLatihanIndustri::with('pelajar');
                if($request->has('pelajar') && $request->pelajar != NULL)
                {
                    $data = $data->whereHas('pelajar', function($data) use ($request){
                        $data->where('nama', 'LIKE', '%'. $request->pelajar . '%');
                    });
                }
                if($request->has('nombor_rujukan') && $request->nombor_rujukan != NULL)
                {
                    $data = $data->where('nombor_rujukan', 'LIKE', '%' . $request->nombor_rujukan . '%');
                }

                return DataTables::of($data)
                ->addColumn('pelajar_id', function($data) {
                   return $data->pelajar->nama ?? null;
                })
                ->addColumn('tarikh_mula', function($data) {
                    return Utils::formatDate($data->tarikh_mula) ?? null;
                })
                ->addColumn('tarikh_tamat', function($data) {
                    return Utils::formatDate($data->tarikh_tamat) ?? null;
                 })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['document_name','sesi', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'pelajar_id', 'name' => 'pelajar_id', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable'=> false],
                ['data' => 'nombor_rujukan', 'name' => 'nombor_rujukan', 'title' => 'Nombor Rujukan (Latihan Industri)', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_mula', 'name' => 'tarikh_mula', 'title' => 'Tarikh Mula', 'orderable'=> false],
                ['data' => 'tarikh_tamat', 'name' => 'tarikh_tamat', 'title' => 'Tarikh Tamat', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
        try {

            $title = 'Tambah Rekod Latihan Industri';
            $action = route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.store');
            $page_title = 'Maklumat Rekod Latihan Industri';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Latihan Industri" =>  route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index'),
                "Tambah Rekod Latihan Industri" => false,
            ];

            $model = new IjazahLatihanIndustri();

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', NULL)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'students'));


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'pelajar'           => 'required',
            'lokasi'            => 'required',
            'nombor_rujukan'    => 'required',
            'tarikh_mula'       => 'required',
            'tarikh_tamat'      => 'required',
        ],[
            'pelajar.required'          => 'Sila pilih pelajar',
            'lokasi.required'           => 'Sila masukkan maklumat lokasi',
            'nombor_rujukan.required'   => 'Sila masukkan maklumat nombor rujukan',
            'tarikh_mula.required'      => 'Sila pilih tarikh mula',
            'tarikh_tamat.required'     => 'Sila pilih tarikh akhir',
        ]);
        
        try {
            
            $latihan_industri = new IjazahLatihanIndustri();
            $latihan_industri->pelajar_id       = $request->pelajar;
            $latihan_industri->lokasi           = $request->lokasi;
            $latihan_industri->nombor_rujukan   = $request->nombor_rujukan;
            $latihan_industri->tarikh_mula      = Carbon::createFromFormat('d/m/Y',$request->tarikh_mula)->format('Y-m-d');
            $latihan_industri->tarikh_tamat     = Carbon::createFromFormat('d/m/Y',$request->tarikh_tamat)->format('Y-m-d');
            $latihan_industri->save();

            Alert::toast('Maklumat rekod latihan industri berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index');


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

            $title = 'Pinda Rekod Latihan Industri';
            $action = route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.update', $id);
            $page_title = 'Maklumat Rekod Latihan Industri';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Latihan Industri" =>  route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index'),
                "Pinda Rekod Latihan Industri" => false,
            ];

            $model = IjazahLatihanIndustri::find($id);

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', NULL)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'students'));


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
        try {
            
            $latihan_industri = IjazahLatihanIndustri::find($id);
            $latihan_industri->pelajar_id       = $request->pelajar;
            $latihan_industri->lokasi           = $request->lokasi;
            $latihan_industri->nombor_rujukan   = $request->nombor_rujukan;
            $latihan_industri->tarikh_mula      = Carbon::createFromFormat('d/m/Y',$request->tarikh_mula)->format('Y-m-d');
            $latihan_industri->tarikh_tamat     = Carbon::createFromFormat('d/m/Y',$request->tarikh_tamat)->format('Y-m-d');
            $latihan_industri->save();

            Alert::toast('Maklumat rekod latihan industri berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index');


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

            IjazahLatihanIndustri::find($id)->delete();

            Alert::toast('Maklumat rekod latihan industri berjaya dihapuskan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index');


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
