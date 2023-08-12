<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\User;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

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
                    'route' => route('pengurusan.akademik.kelas.create'),
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
            $user_staff = User::find($staff->user_id);
            $pusat_pengajian = PusatPengajian::where('is_deleted', 0)->pluck('nama', 'id');
            $jabatan = Jabatan::where('is_deleted', 0)->pluck('nama', 'id');
            $role_kakitangan = Role::where('name', 'kakitangan')->first();
            $role_child_kakitangan = Role::where('parent_category_id', $role_kakitangan->id)->get();

            return view('pages.pengurusan.pentadbir_sistem.kakitangan.edit', compact('title', 'breadcrumbs', 'staff', 'pusat_pengajian', 'jabatan', 'role_child_kakitangan', 'user_staff'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function update()
    {

    }
}
