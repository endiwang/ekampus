<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\SemesterTerkini;
use App\Models\TarikhKeputusan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniPaparanKeputusanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.kemaskini_paparan_keputusan.';

    protected $baseRoute = 'pengurusan.peperiksaan.kemaskini_paparan_keputusan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Kemaskini Paparan Keputusan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini Paparan Keputusan' => false,
            ];

            // $buttons = [
            //     [
            //         'title' => 'Tambah Semester Baru',
            //         'route' => route($this->baseRoute . 'create'),
            //         'button_class' => 'btn btn-sm btn-primary fw-bold',
            //         'icon_class' => 'fa fa-plus-circle',
            //     ],
            // ];

            if (request()->ajax()) {
                $data = SemesterTerkini::with('kursus');
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('kursus_id', $request->program_pengajian);
                }

                return DataTables::of($data)
                    ->addColumn('program_pengajian_id', function ($data) {
                        return '<span>'.$data->kursus->nama.'<br>'.$data->sesi_pengajian.'</span>';

                        //return $data->kursus->nama ?? null;
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
                    ->addColumn('sem_1', function ($data) {
                        if ($data->status_keputusan == 1) {
                            $date = Utils::getTarikhPeperiksaan('1', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_2', function ($data) {
                        if ($data->status_keputusan_2 == 1) {
                            $date = Utils::getTarikhPeperiksaan('2', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_3', function ($data) {
                        if ($data->status_keputusan_3 == 1) {
                            $date = Utils::getTarikhPeperiksaan('3', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_4', function ($data) {
                        if ($data->status_keputusan_4 == 1) {
                            $date = Utils::getTarikhPeperiksaan('4', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_5', function ($data) {
                        if ($data->status_keputusan_5 == 1) {
                            $date = Utils::getTarikhPeperiksaan('5', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_6', function ($data) {
                        if ($data->status_keputusan_6 == 1) {
                            $date = Utils::getTarikhPeperiksaan('6', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_7', function ($data) {
                        if ($data->status_keputusan_7 == 1) {
                            $date = Utils::getTarikhPeperiksaan('7', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('sem_8', function ($data) {
                        if ($data->status_keputusan_8 == 1) {
                            $date = Utils::getTarikhPeperiksaan('8', $data->id);
                            $icon = '<i class="fa-solid fa-square-check" style="color:green;"></i>';

                            return '<span style="text-align:center">'.$icon.'<br>'.$date.'</span>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('status_keputusan_ulangan', function ($data) {
                        if ($data->status_keputusan_ulangan == 1) {
                            return '<i class="fa-solid fa-square-check" style="color:green;"></i>';
                        } else {
                            return '<i class="fa-solid fa-square-xmark" style="color:red;"></i>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['program_pengajian_id', 'sem_1', 'sem_2', 'sem_3', 'sem_4', 'sem_5', 'sem_6', 'sem_7', 'sem_8', 'status', 'status_keputusan_ulangan', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'program_pengajian_id', 'name' => 'program_pengajian_id', 'title' => 'Nama Pengajian/Tahun Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'semester_name', 'name' => 'semester_name', 'title' => 'Nama Semester Semasa', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_1', 'name' => 'sem_1', 'title' => 'Sem 1', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_2', 'name' => 'sem_2', 'title' => 'Sem 2', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_3', 'name' => 'sem_3', 'title' => 'Sem 3', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_4', 'name' => 'sem_4', 'title' => 'Sem 4', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_5', 'name' => 'sem_5', 'title' => 'Sem 5', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_6', 'name' => 'sem_6', 'title' => 'Sem 6', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_7', 'name' => 'sem_7', 'title' => 'Sem 7', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'sem_8', 'name' => 'sem_8', 'title' => 'Sem 8', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'status_keputusan_ulangan', 'name' => 'status_keputusan_ulangan', 'title' => 'Status Keputusan Ulangan', 'orderable' => false],
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

            $title = 'Kemaskini Paparan Peperiksaan';
            $action = route($this->baseRoute.'update', $id);
            $page_title = 'Kemaskini Paparan Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Paparan Peperiksaan' => route($this->baseRoute.'index'),
                'Kemaskini Paparan Peperiksaan' => false,
            ];

            //to do : improve data fetch flow
            $model = SemesterTerkini::with('kursus')->find($id);
            $tarikh_sem_1 = Utils::getTarikhPeperiksaan('1', $id);
            $tarikh_sem_2 = Utils::getTarikhPeperiksaan('2', $id);
            $tarikh_sem_3 = Utils::getTarikhPeperiksaan('3', $id);
            $tarikh_sem_4 = Utils::getTarikhPeperiksaan('4', $id);
            $tarikh_sem_5 = Utils::getTarikhPeperiksaan('5', $id);
            $tarikh_sem_6 = Utils::getTarikhPeperiksaan('6', $id);
            $tarikh_sem_7 = Utils::getTarikhPeperiksaan('7', $id);
            $tarikh_sem_8 = Utils::getTarikhPeperiksaan('8', $id);

            return view($this->baseView.'edit', compact('model',
                'title',
                'breadcrumbs',
                'page_title',
                'action',
                'model',
                'tarikh_sem_1',
                'tarikh_sem_2',
                'tarikh_sem_3',
                'tarikh_sem_4',
                'tarikh_sem_5',
                'tarikh_sem_6',
                'tarikh_sem_7',
                'tarikh_sem_8',
            ));

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
            $update = SemesterTerkini::find($id);
            $update->status_keputusan = $request->status_sem_1 ?? 0;
            $update->status_keputusan_2 = $request->status_sem_2 ?? 0;
            $update->status_keputusan_3 = $request->status_sem_3 ?? 0;
            $update->status_keputusan_4 = $request->status_sem_4 ?? 0;
            $update->status_keputusan_5 = $request->status_sem_5 ?? 0;
            $update->status_keputusan_6 = $request->status_sem_6 ?? 0;
            $update->status_keputusan_7 = $request->status_sem_7 ?? 0;
            $update->status_keputusan_8 = $request->status_sem_8 ?? 0;
            $update->status_keputusan_ulangan = $request->status_kep_ulangan ?? 0;
            $update->save();

            $dates = $request->tarikh_sem;

            foreach ($dates as $key => $value) {
                TarikhKeputusan::updateOrCreate([
                    'semester_no' => $key,
                    'semester_terkini_id' => $id,
                ], [
                    'tarikh_keputusan' => ! empty($value) ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null,
                ]);
            }

            Alert::toast('Maklumat sesi pengajian berjaya dikemaskini!', 'success');

            return redirect()->back();

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
