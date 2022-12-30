<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\PusatPengajian;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class GuruTasmikController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.guru_tasmik.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Guru Tasmik";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Guru Tasmik" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Maklumat Guru Tasmik", 
                    'route' => route('pengurusan.akademik.guru_tasmik.create'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Staff::with('pusatPengajian', 'jabatan');
                return DataTables::of($data)
                ->addColumn('nama', function($data) {
                    return $data->nama ?? null;
                })
                ->addColumn('jabatan', function($data) {
                    if(!empty($data->jabatan_id))
                    {
                        return $data->jabatan->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('pusat_pengajian', function($data) {
                    if(!empty($data->pusat_pengajian_id))
                    {
                        return $data->pusatPengajian->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.guru_tasmik.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kehadiran">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pengurusan.akademik.guru_tasmik.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.guru_tasmik.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['kursus','status', 'action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama (Bilangan Pelajar Tasmik)', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic', 'name' => 'semasa_semester_id', 'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred', 'orderable'=> false],
                ['data' => 'jabatan', 'name' => 'jabatan', 'title' => 'Jabatan', 'orderable'=> false],
                ['data' => 'jawatan', 'name' => 'jumlah_pelajar', 'title' => 'Jawatan', 'orderable'=> false],
                ['data' => 'pusat_pengajian', 'name' => 'pusat_pengajian', 'title' => 'Pusat Pengajian', 'orderable'=> false],
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

            $title = 'Kelas';
            $action = route('pengurusan.akademik.guru_tasmik.store');
            $page_title = 'Maklumat Kakitangan Guru Tasmik';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Guru Tasmik" =>  false,
                "Tambah Guru Tasmik" =>  false,
            ];

            $model = new Staff();

            $genders = [
                'L' => 'Lelaki',
                'P' => 'Perempuan'
            ];

            $centers = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $departments = Jabatan::where('deleted_at', null)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name','kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id',$role_kakitangan->id)->whereNotIn('name', ['warden', 'tutor'])->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'genders', 'centers', 'departments', 'role_child_kakitangan' ));

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
