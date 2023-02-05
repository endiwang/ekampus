<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\AktivitiKalendarAkademik;
use App\Models\KalendarAkademik;
use App\Models\Kursus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KalendarAkademikController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.kalendar_akademik.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Kalendar Akademik";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Kalendar Akademik" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Kalendar Akademik", 
                    'route' => route('pengurusan.akademik.kalendar_akademik.create'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = KalendarAkademik::with('kursus');
                return DataTables::of($data)
                ->addColumn('program_id', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.kalendar_akademik.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Aktiviti">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="'.route('pengurusan.akademik.kalendar_akademik.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kalendar_akademik.destroy', $data->id).'" method="POST">
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
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'program_id', 'name' => 'program_id', 'title' => 'Program Pengajian', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
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

            $title = 'Kalendar Akademik';
            $action = route('pengurusan.akademik.kalendar_akademik.store');
            $page_title = 'Maklumat Kalendar Akademik';
            $breadcrumbs = [
                "Akademik"                  =>  false,
                "Kalendar akademik"         =>  route('pengurusan.akademik.kalendar_akademik.index'),
                "Tambah Kalendar Akademik"  =>  false,
            ];

            $model = new KalendarAkademik();

            $programmes = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'programmes'));

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
            'name'              => 'required',
            'program'           => 'required',
        ],[
            'name.required'     => 'Sila masukkan maklumat nama kalendar akademik',
            'program.required'  => 'Sila pilih maklumat program',
        ]);

        try {

            $new_data = new KalendarAkademik();
            $new_data->name          = $request->name;
            $new_data->program_id    = $request->program;
            $new_data->save();

            Alert::toast('Maklumat kalendar akademik berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.kalendar_akademik.index');

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
    public function show(Builder $builder, $id)
    {
        try {

            $program_name = KalendarAkademik::with('kursus')->find($id);

            $title = "Kalendar Akademik - " . $program_name->kursus->nama;
            $breadcrumbs = [
                "Akademik"                      => false,
                "Kalendar Akademik"             => route('pengurusan.akademik.kalendar_akademik.index'),
                "Aktiviti Kalendar Akademik"    => false
            ];

            $buttons = [
                [
                    'title' => "Tambah Aktiviti", 
                    'route' => route('pengurusan.akademik.kalendar_akademik.create_activity', $id), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = AktivitiKalendarAkademik::where('kalendar_akademik_id', $id);
                return DataTables::of($data)
                ->addColumn('start_date', function($data) {
                    return Utils::formatDate($data->start_date) ?? null;
                })
                ->addColumn('end_date', function($data) {
                    return Utils::formatDate($data->end_date) ?? null;
                })
                ->addColumn('duration', function($data) {
                    return $data->duration . ' Hari';
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.kalendar_akademik.edit_activity',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Aktiviti">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kalendar_akademik.delete_activity', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('start_date', 'asc');
                })
                ->rawColumns(['duration','action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'aktiviti', 'name' => 'aktiviti', 'title' => 'Aktiviti', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'start_date', 'name' => 'start_date', 'title' => 'Tarikh Mula', 'orderable'=> false],
                ['data' => 'end_date', 'name' => 'end_date', 'title' => 'Tarikh Tamat', 'orderable'=> false],
                ['data' => 'duration', 'name' => 'duration', 'title' => 'Tempoh', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'activity_list', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));


        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
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

            $title = 'Kalendar Akademik';
            $action = route('pengurusan.akademik.kalendar_akademik.update', $id);
            $page_title = 'Maklumat Kalendar Akademik';
            $breadcrumbs = [
                "Akademik"                  =>  false,
                "Kalendar Akademik"         =>  route('pengurusan.akademik.kalendar_akademik.index'),
                "Pinda Kalendar Akademik"   =>  false,
            ];

            $model = KalendarAkademik::find($id);

            $programmes = Kursus::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'programmes'));

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
        try {

            KalendarAkademik::find($id)->update([
                'name'          => $request->name,
                'program_id'    => $request->program
            ]);

            Alert::toast('Maklumat kalendar akademik berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.kalendar_akademik.index');

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

            $aktiviti = AktivitiKalendarAkademik::where('kalendar_akademik_id',$id)->count();

            if($aktiviti != 0)
            {
                Alert::toast('Aktiviti wujud bagi kalendar akademik ini! Maklumat kalendar akademik tidak boleh dihapuskan!', 'error');
                return redirect()->back();
            }

            KalendarAkademik::find($id)->delete();

            Alert::toast('Maklumat kalendar akademik berjaya dihapus!', 'success');
            return redirect()->back();
        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function createActivity($id)
    {
        try {

            $title = 'Tambah Aktiviti Kalendar Akademik';
            $action = route('pengurusan.akademik.kalendar_akademik.store_activity', $id);
            $page_title = 'Maklumat Aktiviti Kalendar Akademik';
            $breadcrumbs = [
                "Akademik"                              =>  false,
                "Kalendar akademik"                     =>  route('pengurusan.akademik.kalendar_akademik.index'),
                "Aktiviti Kalendar Akademik"            =>  route('pengurusan.akademik.kalendar_akademik.show', $id),
                "Tambah Aktiviti Kalendar Akademik"     =>  false,
            ];

            $model = new KalendarAkademik();

            return view($this->baseView.'add_edit_activity_list', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function storeActivity(Request $request, $id)
    {
        $validation = $request->validate([
            'aktiviti'      => 'required',
            'tarikh_mula'   => 'required',
            'tarikh_tamat'  => 'required',
            'tempoh'        => 'required'
        ],[
            'aktiviti.required'         => 'Sila masukkan maklumat aktiviti',
            'tarikh_mula.required'      => 'Sila pilih tarikh mula',
            'tarikh_tamat.required'     => 'Sila pilih tarikh tamat',
            'tempoh.required'           => 'Sila masukkan maklumat tempoh',
        ]);

        try {

            $new_data = new AktivitiKalendarAkademik();
            $new_data->kalendar_akademik_id = $id;
            $new_data->aktiviti             = $request->aktiviti;
            $new_data->start_date           = Carbon::createFromFormat('d/m/Y',$request->tarikh_mula)->format('Y-m-d');
            $new_data->end_date             = Carbon::createFromFormat('d/m/Y',$request->tarikh_tamat)->format('Y-m-d');
            $new_data->duration             = $request->tempoh;
            $new_data->save();

            Alert::toast('Maklumat aktiviti berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.kalendar_akademik.show', $id);

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function editActivity($id)
    {
        try {

            $title = 'Aktiviti Kalendar Akademik';
            $action = route('pengurusan.akademik.kalendar_akademik.update_activity', $id);
            $page_title = 'Pinda Aktiviti Kalendar Akademik';
            $breadcrumbs = [
                "Akademik"                              =>  false,
                "Kalendar akademik"                     =>  route('pengurusan.akademik.kalendar_akademik.index'),
                "Aktiviti Kalendar Akademik"            =>  route('pengurusan.akademik.kalendar_akademik.show', $id),
                "Pinda Aktiviti Kalendar Akademik"     =>  false,
            ];

            $model = AktivitiKalendarAkademik::find($id);

            return view($this->baseView.'add_edit_activity_list', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function updateActivity(Request $request, $id)
    {
        try {

            $update_data = AktivitiKalendarAkademik::find($id);
            $update_data->aktiviti             = $request->aktiviti;
            $update_data->start_date           = Carbon::createFromFormat('d/m/Y',$request->tarikh_mula)->format('Y-m-d');
            $update_data->end_date             = Carbon::createFromFormat('d/m/Y',$request->tarikh_tamat)->format('Y-m-d');
            $update_data->duration             = $request->tempoh;
            $update_data->save();

            Alert::toast('Maklumat aktiviti berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.kalendar_akademik.show', $update_data->kalendar_akademik_id);

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function deleteActivity($id)
    {
        try {

            AktivitiKalendarAkademik::find($id)->delete();

            Alert::toast('Maklumat Aktiviti berjaya dihapus!', 'success');
            return redirect()->back();
        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
