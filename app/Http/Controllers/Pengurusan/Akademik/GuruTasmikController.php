<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Image, File;

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
                    return '
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

            $title = 'Guru Tasmik';
            $action = route('pengurusan.akademik.guru_tasmik.store');
            $page_title = 'Maklumat Kakitangan Guru Tasmik';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Guru Tasmik" =>  false,
                "Tambah Guru Tasmik" =>  false,
            ];

            $model = new Staff();

            $assignation = [];

            $genders = [
                'L' => 'Lelaki',
                'P' => 'Perempuan'
            ];

            $centers = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $departments = Jabatan::where('deleted_at', null)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name','kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id',$role_kakitangan->id)->whereNotIn('name', ['warden', 'tutor'])->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'genders', 'centers', 'departments', 'role_child_kakitangan','assignation'));

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
            'no_ic'             => 'required|unique:staff,no_ic',
            'nama'              => 'required',
            'alamat'            => 'required',
            'no_tel'            => 'required',
            'jantina'           => 'required',
            'email'             => 'required|unique:staff,email',
            'pusat_pengajian'   => 'required',
            'jabatan'           => 'required',
            'nama_jawatan'      => 'required',
            'gred'              => 'required',
            'jawatan'           => 'required',
        ],[
            'no_ic.required'            => 'Sila masukkan maklumat no. kad pengenalan',
            'nama.required'             => 'Sila masukkan maklumat nama',
            'alamat.required'           => 'Sila masukkan maklumat alamat',
            'no_tel.required'           => 'Sila masukkan maklumat no telefon',
            'jantina.required'          => 'Sila pilih jantina',
            'email.required'            => 'Sila masukkan maklumat emel',
            'pusat_pengajian.required'  => 'Sila pilih pusat pengajian',
            'jabatan.required'          => 'Sila pilih jabatan',
            'nama_jawatan.required'     => 'Sila masukkan maklumat nama jawatan',
            'gred.required'             => 'Sila pilih gred',
            'jawatan.required'          => 'Sila pilih jawatan',
        ]);

        try {

            $pensyarah = 'N';
            $pensyarah_jemputan = 'N';
            $guru_tasmik = 'N';
            $guru_tasmik_jemputan = 'N';

            foreach($request->jawatan as $jwtn)
            {
                if($jwtn == 14)
                {
                    $pensyarah = 'Y';
                }
                if($jwtn == 15)
                {
                    $pensyarah_jemputan = 'Y';
                }
                if($jwtn == 16)
                {
                    $guru_tasmik = 'Y';
                }
                if($jwtn == 17)
                {
                    $guru_tasmik_jemputan = 'Y';
                }
            }

            $user = User::create([
                'username'      => $request->no_ic,
                'password'      => Hash::make($request->no_ic),
            ]);

            //image

            $image_name = uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            $image_path = 'uploads/' . $image_name;
            Image::make($request->avatar)->resize(320, 240)->save(public_path($image_path));
            $image = $image_path;

            Staff::create([
                'user_id'                   => $user->id,
                'nama'                      => $request->nama,
                'no_ic'                     => $request->no_ic,
                'alamat'                    => $request->alamat,
                'no_tel'                    => $request->no_tel,
                'jantina'                   => $request->jantina,
                'email'                     => $request->email,
                'pusat_pengajian_id'        => $request->pusat_pengajian,
                'jabatan_id'                => $request->jabatan,
                'jawatan'                   => $request->nama_jawatan,
                'img_staff'                 => $image,
                'is_pensyarah'              => $pensyarah,
                'is_pensyarah_jemputan'     => $pensyarah_jemputan,
                'is_guru_tasmik'            => $guru_tasmik,
                'is_guru_tasmik_jemputan'   => $guru_tasmik_jemputan,
            ]);

            Alert::toast('Maklumat guru tasmik berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.guru_tasmik.index');

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

            $title = 'Guru Tasmik';
            $action = route('pengurusan.akademik.guru_tasmik.update', $id);
            $page_title = 'Maklumat Kakitangan Guru Tasmik';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Guru Tasmik" =>  false,
                "Pinda Guru Tasmik" =>  false,
            ];

            $model = Staff::find($id);

            $genders = [
                'L' => 'Lelaki',
                'P' => 'Perempuan'
            ];

            $centers = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $departments = Jabatan::where('deleted_at', null)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name','kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id',$role_kakitangan->id)->whereNotIn('name', ['warden', 'tutor'])->get();

            $is_pensyarah = $model->is_pensyarah;
            $is_pensyarah_jemputan = $model->is_pensyarah_jemputan;
            $is_pensyarah_tasmik = $model->is_pensyarah_tasmik;
            $is_pensyarah_tasmik_jemputan = $model->is_pensyarah_tasmik_jemputan;

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  
                                                    'action', 'genders', 'centers', 'departments', 'role_child_kakitangan',
                                                    'is_pensyarah', 'is_pensyarah_jemputan', 'is_pensyarah_tasmik', 'is_pensyarah_tasmik_jemputan'  ));

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

            $staff = Staff::find($id);

            $image = '';
            if ($request->has('avatar')) {
                unlink(public_path($staff->img_staff));
                $image_name = uniqid() . '.' . $request->avatar->getClientOriginalExtension();
                $image_path = 'uploads/' . $image_name;
                Image::make($$request->avatar)->resize(320, 240)->save(public_path($image_path));
                $image = $image_path;
            } else {
                $image = $staff->img_staff;
            }

            $staff = $staff->update([
                'nama'                      => $request->nama,
                'no_ic'                     => $request->no_ic,
                'alamat'                    => $request->alamat,
                'no_tel'                    => $request->no_tel,
                'jantina'                   => $request->jantina,
                'email'                     => $request->email,
                'pusat_pengajian_id'        => $request->pusat_pengajian,
                'jabatan_id'                => $request->jabatan,
                'jawatan'                   => $request->nama_jawatan,
                'img_staff'                 => $image,
                'is_pensyarah'              => $request->is_pensyarah ?? 'N',
                'is_pensyarah_jemputan'     => $request->is_pensyarah_jemputan ?? 'N',
                'is_guru_tasmik'            => $request->is_guru_tasmik ?? 'N',
                'is_guru_tasmik_jemputan'   => $request->is_guru_tasmik_jemputan ?? 'N',
            ]);

            Alert::toast('Maklumat guru tasmik berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.guru_tasmik.index');

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

            $staff = Staff::find($id);

            $staff = $staff->delete();

            Alert::toast('Maklumat guru tasmik berjaya dihapus!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
