<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniSesiPengajianController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.sesi_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Senarai Maklumat Sesi Pengajian';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Sesi Pengajian' => false,
            ];

            if (request()->ajax()) {
                $data = Sesi::with('kursus');
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
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
                        return '<a href="'.route('pengurusan.peperiksaan.kemaskini.sesi_pengajian.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Sesi', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Nama Kursus', 'orderable' => false],
                    ['data' => 'status', 'name' => 'kelas', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses'));

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

            $title = 'Kemaskini Sesi pengajian';
            $action = route('pengurusan.peperiksaan.kemaskini.sesi_pengajian.update', $id);
            $page_title = 'Kemaskini Sesi Pengajian';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Sesi Pengajian' => route('pengurusan.peperiksaan.kemaskini.sesi_pengajian.index'),
                'Kemaskini Sesi Pengajian' => false,
            ];

            $model = Sesi::find($id);

            $courses = Kursus::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'courses'));

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

            $update = Sesi::find($id);
            $update->nama = $request->nama_sesi_pengajian;
            $update->kursus_id = $request->program_pengajian;
            $update->status = $request->status;
            $update->save();

            Alert::toast('Maklumat sesi pengajian berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.peperiksaan.kemaskini.sesi_pengajian.index');

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
