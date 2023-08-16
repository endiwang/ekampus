<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PemantauanKehadiranController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.';
    protected $baseRoute = 'pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
            $title = 'Pemantaun Kehadiran';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Pemantaun Kehadiran' => false,
            ];

            if (request()->ajax()) {
                $data = KehadiranPelajar::with('pelajar', 'subjek');
                if ($request->has('nama_pelajar') && $request->nama_pelajar != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama_pelajar.'%');
                    });
                }
                if ($request->has('subjek') && $request->subjek != null) {
                    $data = $data->whereHas('subjek', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->subjek.'%');
                    });
                }
                if ($request->has('kelas') && $request->kelas != null) {
                    $data->where('kelas_id', $request->kelas);
                }

                return DataTables::of($data)
                    ->addColumn('pelajar_id', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        return Utils::formatDate($data->tarikh) ?? null;
                    })
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime($data->waktu) ?? null;
                    })
                    ->addColumn('status', function ($data) {
                        if($data->status == 'hadir')
                        {
                            return 'Hadir';
                        }
                        else if($data->status == 'tidak_hadir')
                        {
                            return 'Tidak Hadir';
                        }
                        else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat CLO PLO">
                                <i class="fa fa-eye"></i>
                            </a>
                           ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action', 'status'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'pelajar_id', 'name' => 'pelajar_id', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'traikh', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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
