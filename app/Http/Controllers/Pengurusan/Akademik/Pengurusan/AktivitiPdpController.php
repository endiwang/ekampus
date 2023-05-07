<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\AktivitiPdp;
use App\Models\Kelas;
use App\Models\Subjek;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class AktivitiPdpController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.aktiviti_pdp.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Rekod Aktiviti PDP";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Rekod Aktiviti PDP" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Aktiviti PDP", 
                    'route' => route('pengurusan.akademik.pengurusan.aktiviti_pdp.create'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = AktivitiPdp::with('kelas', 'subjek');
                return DataTables::of($data)
                ->addColumn('subjek_id', function($data) {
                    return $data->subjek->nama ?? null;
                })
                ->addColumn('kelas_id', function($data) {
                    return $data->kelas->nama ?? null;
                })
                ->addColumn('record_date', function($data) {
                    return !empty($data->record_date) ? Utils::formatDate($data->record_date) : null;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.pengurusan.aktiviti_pdp.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.aktiviti_pdp.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'title', 'name' => 'title', 'title' => 'Tajuk', 'orderable'=> false ],
                ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable'=> false],
                ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable'=> false],
                ['data' => 'record_date', 'name' => 'record_date', 'title' => 'Tarikh Rekod', 'orderable'=> false],
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

            $title = 'Rekod Aktiviti PDP';
            $action = route('pengurusan.akademik.pengurusan.aktiviti_pdp.store');
            $page_title = 'Tambah Rekod Aktiviti PDP';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Rekod Aktiviti PDP" =>  route('pengurusan.akademik.pengurusan.aktiviti_pdp.index'),
                "Tambah Rekod Aktiviti PDP" =>  false,
            ];

            $model = new AktivitiPdp();

            $classes = Kelas::where('deleted_at', NULL)->get()->pluck('nama', 'id');

            $subjects = Subjek::where('deleted_at', NULL)->get()->pluck('nama', 'id');

            return view($this->baseView.'create-update', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'classes', 'subjects'));

        }catch (Exception $e) {
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
            'title'             => 'required',
            'subjek'            => 'required',
            'kelas'             => 'required',
            'tarikh_rekod'      => 'required',
            'description'       => 'required',
        ],[
            'title.required'        => 'Sila masukkan maklumat tajuk',
            'subjek.required'       => 'Sila pilih subjek',
            'kelas.required'        => 'Sila pilih kelas',
            'tarikh_rekod.required' => 'Sila pilih tarikh rekod',
            'description.required'  => 'Sila masukkan deskripsi rekod aktiviti',
        ]);
        
        try {

            $aktiviti = new AktivitiPdp();
            $aktiviti->title        = $request->title;
            $aktiviti->kelas_id     = $request->kelas;
            $aktiviti->subjek_id    = $request->subjek;
            $aktiviti->description  = $request->description;
            $aktiviti->record_date  = Carbon::createFromFormat('d/m/Y',$request->tarikh_rekod)->format('Y-m-d');
            $aktiviti->created_by   = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat Aktiviti PDP berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan.aktiviti_pdp.index');

        }catch (Exception $e) {
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

            $title = 'Rekod Aktiviti PDP';
            $action = route('pengurusan.akademik.pengurusan.aktiviti_pdp.update', $id);
            $page_title = 'Pinda Rekod Aktiviti PDP';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Rekod Aktiviti PDP" =>  route('pengurusan.akademik.pengurusan.aktiviti_pdp.index'),
                "Pinda Rekod Aktiviti PDP" =>  false,
            ];

            $model = AktivitiPdp::find($id);

            $classes = Kelas::where('deleted_at', NULL)->get()->pluck('nama', 'id');

            $subjects = Subjek::where('deleted_at', NULL)->get()->pluck('nama', 'id');

            return view($this->baseView.'create-update', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'classes', 'subjects'));

        }catch (Exception $e) {
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
        $validation = $request->validate([
            'title'             => 'required',
            'subjek'            => 'required',
            'kelas'             => 'required',
            'tarikh_rekod'      => 'required',
            'description'       => 'required',
        ],[
            'title.required'        => 'Sila masukkan maklumat tajuk',
            'subjek.required'       => 'Sila pilih subjek',
            'kelas.required'        => 'Sila pilih kelas',
            'tarikh_rekod.required' => 'Sila pilih tarikh rekod',
            'description.required'  => 'Sila masukkan deskripsi rekod aktiviti',
        ]);
        
        try {

            $aktiviti = AktivitiPdp::find($id);
            $aktiviti->title        = $request->title;
            $aktiviti->kelas_id     = $request->kelas;
            $aktiviti->subjek_id    = $request->subjek;
            $aktiviti->description  = $request->description;
            $aktiviti->record_date  = Carbon::createFromFormat('d/m/Y',$request->tarikh_rekod)->format('Y-m-d');
            $aktiviti->created_by   = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat Aktiviti PDP berjaya dipinda!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
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
            AktivitiPdp::find($id)->delete();

            Alert::toast('Maklumat Aktiviti PDP berjaya dihapus!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
