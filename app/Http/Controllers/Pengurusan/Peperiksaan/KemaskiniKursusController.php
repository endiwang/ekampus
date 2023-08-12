<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniKursusController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.senarai_kursus.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Senarai Maklumat Pengajian';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Pengajian' => false,
            ];

            if (request()->ajax()) {
                $data = Kursus::query();
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('nama', 'LIKE', '%'.$request->program_pengajian.'%');
                }

                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                                break;
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.peperiksaan.kemaskini.senarai_kursus.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Program Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'bil_sem_keseluruhan', 'name' => 'bil_sem_keseluruhan', 'title' => 'Jumlah Semester', 'orderable' => false],
                    ['data' => 'status', 'name' => 'kelas', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

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
        try {

            $title = 'Kemaskini Kursus';
            $action = route('pengurusan.peperiksaan.kemaskini.senarai_kursus.update', $id);
            $page_title = 'Kemaskini Kursus';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Pengajian' => route('pengurusan.peperiksaan.kemaskini.senarai_kursus.index'),
                'Kemaskini Kursus' => false,
            ];

            $model = Kursus::find($id);

            $statuses = [
                ['kod' => 'D', 'nama' => 'Diploma'],
                ['kod' => 'S', 'nama' => 'Sijil'],
                ['kod' => 'I', 'nama' => 'Ijazah'],
                ['kod' => 'ST', 'nama' => 'Sijil Tahfiz'],
            ];

            $yearly_semesters = [
                1 => '1 Semester',
                2 => '2 Semester',
                3 => '3 Semester',
            ];

            $views = [
                1 => 'Log Masuk',
            ];

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'statuses', 'yearly_semesters', 'views'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $update = Kursus::find($id);
            $update->kod = $request->kod_kursus;
            $update->nama = $request->nama_pengajian;
            $update->maklumat_cetakan = $request->maklumat_cetakan;
            $update->bil_sem_keseluruhan = $request->jumlah_semester;
            $update->bil_sem_setahun = $request->semester_setahun;
            $update->status = $request->status;
            $update->is_paparan_login = $request->paparan_log_masuk;
            $update->save();

            Alert::toast('Maklumat kursus berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.peperiksaan.kemaskini.senarai_kursus.index');

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
        //
    }
}
