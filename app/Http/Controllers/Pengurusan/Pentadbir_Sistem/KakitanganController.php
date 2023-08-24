<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\User;
use Exception;
use Image;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;

class KakitanganController extends Controller
{
    public function index(Builder $builder)
    {
        try {

            $title = 'Kakitangan';
            $breadcrumbs = [
                'Pentadbir Sistem' => false,
                'Pengurusan Kakitangan' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Kakitangn',
                    'route' => route('pengurusan.pentadbir_sistem.kakitangan.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = Staff::where('is_deleted', 0);

                return DataTables::of($data)
                    ->addColumn('pusat_pengajian', function ($data) {
                        if (! empty($data->pusat_pengajian_id)) {
                            return $data->pusatPengajian->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('jawatan', function ($data) {
                        $user = User::find($data->user_id);
                        $jawatan = '<div class="d-flex flex-column">';
                        if ($user->hasRole('pensyarah')) {
                            $jawatan = $jawatan.'<li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah</li>';
                        }
                        if ($user->hasRole('pensyarah_tasmik')) {
                            $jawatan = $jawatan.'<li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah Tasmik</li>';
                        }
                        if ($user->hasRole('pensyarah_tasmik_jemputan')) {
                            $jawatan = $jawatan.'<li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah Tasmik Jemputan</li>';
                        }
                        if ($user->hasRole('warden')) {
                            $jawatan = $jawatan.'<li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Warden</li>';
                        }
                        if ($user->hasRole('tutor')) {
                            $jawatan = $jawatan.'<li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Tutor</li>';
                        }
                        $jawatan = $jawatan.'</div>';

                        return $jawatan;
                    })
                    ->addColumn('jabatan', function ($data) {
                        if (! empty($data->jabatan_id) && $data->jabatan != null) {
                            return $data->jabatan->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.pentadbir_sistem.kakitangan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Profil">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="'.route('pengurusan.pentadbir_sistem.kakitangan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hapus" onclick="remove('.$data->id.')">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kelas.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action', 'pusat_pengajian', 'jawatan', 'jabatan'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['data' => 'DT_RowIndex', 'name' => 'index', 'title' => 'No', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => true],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. K/P', 'orderable' => false],
                    ['data' => 'gred', 'name' => 'gred', 'title' => 'Gred', 'orderable' => false],
                    ['data' => 'jawatan', 'name' => 'jawatan', 'title' => 'Jawatan', 'orderable' => false],
                    ['data' => 'jabatan', 'name' => 'jabatan', 'title' => 'Jabatan', 'orderable' => false],
                    ['data' => 'pusat_pengajian', 'name' => 'pusat_pengajian', 'title' => 'Pusat Pengajian', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.pengurusan.pentadbir_sistem.kakitangan.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {

            $title = 'Profil Kakitangan';
            $breadcrumbs = [
                'Pentadbir Sistem' => false,
                'Kakitangan' => false,
                'Profil' => false,
            ];

            $staff = Staff::find($id);

            return view('pages.pengurusan.pentadbir_sistem.kakitangan.show', compact('title', 'breadcrumbs', 'staff'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {

            $title = 'Pinda Profil Kakitangan';
            $breadcrumbs = [
                'Pentadbir Sistem' => false,
                'Kakitangan' => false,
                'Profil' => false,
                'Pinda' => false,
            ];


            $staff = Staff::find($id);
            $action = route('pengurusan.pentadbir_sistem.kakitangan.update', $staff->id);
            $user_staff = User::find($staff->user_id);
            $pusat_pengajian = PusatPengajian::where('is_deleted', 0)->pluck('nama', 'id');
            $jabatan = Jabatan::where('is_deleted', 0)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name', 'kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id', $role_kakitangan->id)->get();

            return view('pages.pengurusan.pentadbir_sistem.kakitangan.edit', compact('title','action', 'breadcrumbs', 'staff', 'pusat_pengajian', 'jabatan', 'role_child_kakitangan', 'user_staff'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {

        $staff = Staff::find($id);


        $file_image_path = $staff->img_staff;
        if($request->has('avatar'))
        {
            $image_name = uniqid().'.'.$request->avatar->getClientOriginalExtension();
            $image_path = 'uploads/kakitangan/gambar_kakitangan';
            $file_image_path = $request->file('avatar')->storeAs($image_path, $image_name, 'public');
        }

        if($request->has('jawatan'))
        {
            $user = User::find($staff->user_id);
            $user->removeRole('pensyarah');
            $user->removeRole('pensyarah_jemputan');
            $user->removeRole('pensyarah_tasmik');
            $user->removeRole('pensyarah_tasmik_jemputan');
            $user->removeRole('warden');
            $user->removeRole('tutor');

            $pensyarah = 'N';
            $pensyarah_jemputan = 'N';
            $guru_tasmik = 'N';
            $guru_tasmik_jemputan = 'N';
            $tutor = 'N';
            $warden = 'N';

            foreach ($request->jawatan as $jwtn) {
                $role = Role::find($jwtn);
                if($role)
                {
                    switch ($role->name) {
                        case 'pensyarah':
                            $pensyarah = 'Y';
                            $user->assignRole('pensyarah');

                            break;
                        case 'pensyarah_jemputan':
                            $pensyarah_jemputan = 'Y';
                            $user->assignRole('pensyarah_jemputan');

                            break;
                        case 'pensyarah_tasmik':
                            $guru_tasmik = 'Y';
                            $user->assignRole('pensyarah_tasmik');

                            break;
                        case 'pensyarah_tasmik_jemputan';
                            $guru_tasmik_jemputan = 'Y';
                            $user->assignRole('pensyarah_tasmik_jemputan');

                            break;
                        case 'warden';
                            $warden = 'Y';
                            $user->assignRole('warden');

                            break;
                        case 'tutor';
                            $tutor = 'Y';
                            $user->assignRole('tutor');
                            break;
                    }
                }

            }
        }else{
            $pensyarah = $staff->is_pensyarah;
            $pensyarah_jemputan = $staff->is_pensyarah_jemputan;
            $guru_tasmik = $staff->is_guru_tasmik;
            $guru_tasmik_jemputan = $staff->is_guru_tasmik_jemputan;
            $tutor = $staff->is_tutor;
            $warden = $staff->is_warden;
        }


        $staff->nama = $request->nama;
        $staff->no_ic = $request->no_ic;
        $staff->alamat = $request->alamat;
        $staff->no_tel = $request->no_tel;
        $staff->jantina = $request->jantina;
        $staff->email = $request->email;
        $staff->pusat_pengajian_id = $request->pusat_pengajian;
        $staff->jabatan_id = $request->jabatan;
        $staff->jawatan = $request->nama_jawatan;
        $staff->img_staff = $file_image_path;
        $staff->is_pensyarah = $pensyarah;
        $staff->is_pensyarah_jemputan = $pensyarah_jemputan;
        $staff->is_guru_tasmik = $guru_tasmik;
        $staff->is_guru_tasmik_jemputan = $guru_tasmik_jemputan;
        $staff->is_tutor = $tutor;
        $staff->is_warden = $warden;
        $staff->gred = $request->gred;
        $staff->save();

        Alert::toast('Maklumat kakitangan berjaya dipinda!', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.kakitangan.index');

    }

    public function create()
    {

            $title = 'Cipta Profil Kakitangan';
            $breadcrumbs = [
                'Pentadbir Sistem' => false,
                'Kakitangan' => false,
                'Profil' => false,
                'Cipta' => false,
            ];

            $request->validate([
                'nama' => 'required',
                'no_ic' => 'required',
                'alamat' => 'required',
                'no_tel' => 'required',
                'email' => 'required',
                'pusat_pengajian' => 'required',
                'jabatan' => 'required',
            ], [
                'nama.required' => 'Sila masukkan nama',
                'no_ic.required' => 'Sila masukkan no ic',
                // 'no_ic.unique' => 'No ic ini telah didaftarkan',
                'alamat.required' => 'Sila masukkan alamat',
                'no_tel.required' => 'Sila masukkan no telefon',
                'email.required' => 'Sila masukkan email',
                'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
                'jabatan.required' => 'Sila pilih jabatan',
            ]);

            $action = route('pengurusan.pentadbir_sistem.kakitangan.store');

            $staff = new Staff;
            $user_staff = User::find($staff->user_id);
            $pusat_pengajian = PusatPengajian::where('is_deleted', 0)->pluck('nama', 'id');
            $jabatan = Jabatan::where('is_deleted', 0)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name', 'kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id', $role_kakitangan->id)->get();

            return view('pages.pengurusan.pentadbir_sistem.kakitangan.edit', compact('title', 'breadcrumbs', 'staff', 'pusat_pengajian', 'jabatan', 'role_child_kakitangan', 'user_staff','action'));
    }

    public function store(Request $request)
    {
        $pensyarah = 'N';
        $pensyarah_jemputan = 'N';
        $guru_tasmik = 'N';
        $guru_tasmik_jemputan = 'N';
        $tutor = 'N';
        $warden = 'N';



        $request->validate([
            'nama' => 'required',
            'no_ic' => 'required',
            'alamat' => 'required',
            'no_tel' => 'required',
            'email' => 'required',
            'pusat_pengajian' => 'required',
            'jabatan' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama',
            'no_ic.required' => 'Sila masukkan no ic',
            // 'no_ic.unique' => 'No ic ini telah didaftarkan',
            'alamat.required' => 'Sila masukkan alamat',
            'no_tel.required' => 'Sila masukkan no telefon',
            'email.required' => 'Sila masukkan email',
            'pusat_pengajian.required' => 'Sila pilih pusat pengajian',
            'jabatan.required' => 'Sila pilih jabatan',
        ]);

        $user = User::create([
            'username' => $request->no_ic,
            'password' => Hash::make($request->no_ic),
            'is_staff' => 1,
        ]);

        foreach ($request->jawatan as $jwtn) {
            $role = Role::find($jwtn);
            if($role)
            {
                switch ($role->name) {
                    case 'pensyarah':
                        $pensyarah = 'Y';
                        $user->assignRole('pensyarah');

                        break;
                    case 'pensyarah_jemputan':
                        $pensyarah_jemputan = 'Y';
                        $user->assignRole('pensyarah_jemputan');

                        break;
                    case 'pensyarah_tasmik':
                        $guru_tasmik = 'Y';
                        $user->assignRole('pensyarah_tasmik');

                        break;
                    case 'pensyarah_tasmik_jemputan';
                        $guru_tasmik_jemputan = 'Y';
                        $user->assignRole('pensyarah_tasmik_jemputan');

                        break;
                    case 'warden';
                        $warden = 'Y';
                        $user->assignRole('warden');

                        break;
                    case 'tutor';
                        $tutor = 'Y';
                        $user->assignRole('tutor');

                        break;
                  }
            }
        }

        // $path = 'uploads/kakitangan/gambar_kakitangan';

        // $image_name = uniqid().'.'.$request->avatar->getClientOriginalExtension();
        // $image_path = $path.$image_name;
        // $image = Image::make($request->avatar)->resize(320, 240)->save($image_path);

        $file_image_path = '';
        if($request->has('avatar'))
        {
            $image_name = uniqid().'.'.$request->avatar->getClientOriginalExtension();
            $image_path = 'uploads/kakitangan/gambar_kakitangan';
            $file_image_path = $request->file('avatar')->storeAs($image_path, $image_name, 'public');
        }

        Staff::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_ic' => $request->no_ic,
            'alamat' => $request->alamat,
            'no_tel' => $request->no_tel,
            'jantina' => $request->jantina,
            'email' => $request->email,
            'pusat_pengajian_id' => $request->pusat_pengajian,
            'jabatan_id' => $request->jabatan,
            'jawatan' => $request->nama_jawatan,
            'img_staff' => $file_image_path,
            'is_pensyarah' => $pensyarah,
            'is_pensyarah_jemputan' => $pensyarah_jemputan,
            'is_guru_tasmik' => $guru_tasmik,
            'is_guru_tasmik_jemputan' => $guru_tasmik_jemputan,
            'is_tutor' => $tutor,
            'is_warden' => $warden,
            'gred' => $request->gred,
        ]);

        Alert::toast('Maklumat kakitangan berjaya ditambah!', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.kakitangan.index');


    }


}
