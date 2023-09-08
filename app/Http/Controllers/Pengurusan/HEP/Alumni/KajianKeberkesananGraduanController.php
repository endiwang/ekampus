<?php

namespace App\Http\Controllers\Pengurusan\HEP\Alumni;

use App\Http\Controllers\Controller;
use App\Models\JawapanKajianKeberkesananGraduan;
use App\Models\KajianKeberkesananGraduan;
use Hashids\Hashids;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class KajianKeberkesananGraduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Kajian Keberkesanan Graduan';
        $breadcrumbs = [
            'Utama' => false,
            'Hal Ehwal Pelajar' => false,
            'Alumni' => false,
            'Kajian Keberkesanan Graduan' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Kaji Selidik',
                'route' => route('pengurusan.hep.alumni.kajian_keberkesanan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = KajianKeberkesananGraduan::query();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->is_active) {
                        case 0:
                            return '<span class="badge badge-danger">Tidak Aktif</span>';

                        case 1:
                            return '<span class="badge badge-success">Aktif</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $hashids = new Hashids('', 20);

                    return '
                            <a href="' . route('pengurusan.akademik.permohonan.pelepasan_kuliah.show', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="' . route('pengurusan.hep.alumni.kajian_keberkesanan.design_form', $data->id) . '" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cipta Borang">
                                <i class="fa fa-copy"></i>
                            </a>
                            <a href="' . route('public.kaji_selidik.index', $hashids->encodeHex($data->id)) . '" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" target="_blank" data-bs-toggle="tooltip" title="Lihat Borang">
                                <i class="fa fa-eye"></i>
                            </a>
                            <!--a href="' . route('pengurusan.hep.alumni.kajian_keberkesanan.data_chart', $data->id) . '" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" target="_blank" data-bs-toggle="tooltip" title="Data Borang">
                                <i class="fa fa-eye"></i>
                            <a-->
                            <a href="' . route('pengurusan.hep.alumni.kajian_keberkesanan.analisa', $data->id) . '" class="edit btn btn-icon btn-warning btn-sm hover-elevate-up mb-1" target="_blank" data-bs-toggle="tooltip" title="Data Borang">
                                <i class="fa fa-chart-pie"></i>
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
                ['data' => 'title', 'name' => 'title', 'title' => 'Tajuk Kaji Selidik', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.hep.alumni.kajian_keberkesanan.main', compact('title', 'breadcrumbs', 'dataTable', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Kajian Keberkesanan Graduan';
        $action = route('pengurusan.hep.alumni.kajian_keberkesanan.store');
        $page_title = 'Tambah Borang Kaji Selidik';
        $breadcrumbs = [
            'Utama' => false,
            'Hal Ehwal Pelajar' => false,
            'Alumni' => false,
            'Kajian Keberkesanan Graduan' => false,
            'Tambah Borang' => false,
        ];

        $model = new KajianKeberkesananGraduan();

        return view('pages.pengurusan.hep.alumni.kajian_keberkesanan.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_borang' => 'required',
        ], [
            'nama_borang.required' => 'Sila masukkan nama borang kaji selidik',
        ]);

        KajianKeberkesananGraduan::create([
            'title' => $request->nama_borang,
            'is_active' => $request->status,
        ]);

        Alert::toast('Maklumat borang berjaya ditambah!', 'success');

        return redirect()->route('pengurusan.hep.alumni.kajian_keberkesanan.index');
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

    public function design_form($id)
    {

        $title = 'Kajian Keberkesanan Graduan';
        $page_title = 'Borang Kaji Selidik';
        $breadcrumbs = [
            'Utama' => false,
            'Hal Ehwal Pelajar' => false,
            'Alumni' => false,
            'Kajian Keberkesanan Graduan' => false,
            'Reka Bentuk Borang' => false,
        ];

        $form = KajianKeberkesananGraduan::find($id);

        if ($form->json != null) {
            $form_array = json_decode($form->json)[0];
        } else {
            $form_array = [];
        }

        return view('pages.pengurusan.hep.alumni.kajian_keberkesanan.design_form', compact('title', 'breadcrumbs', 'page_title', 'form', 'form_array'));
    }

    public function design_update(Request $request, $id)
    {

        $form = KajianKeberkesananGraduan::find($id);
        $form->json = $request->json;
        $form->save();

        Alert::toast('Borang berjaya ubahsuai!', 'success');

        return redirect()->route('pengurusan.hep.alumni.kajian_keberkesanan.index');
    }

    public function fill_store(Request $request, $id)
    {
        $form = KajianKeberkesananGraduan::find($id);

        if ($form) {
            $client_emails = [];
            $array = $form->getFormArray();
            foreach ($array as &$rows) {

                foreach ($rows as &$row) {
                    if ($row->type == 'checkbox-group') {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'radio-group') {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'select') {
                        if (isset($row->multiple) & !empty($row->multiple)) {
                            foreach ($row->values as &$value) {
                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {
                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'date') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'number') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'textarea') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'text') {
                        $client_email = '';
                        if ($row->subtype == 'email') {
                            if (isset($row->is_client_email) && $row->is_client_email) {

                                $client_emails[] = $request->{$row->name};
                            }
                        }
                        $row->value = $request->{$row->name};
                    }
                }
            }
            $data = [];
            $data['borang_kaji_selidik_id'] = $form->id;
            $data['json'] = json_encode($array);


            if (auth()->user()) {
                $data['user_id'] =  auth()->user()->id;
            } else {
                $data['user_id'] =  null;
            }
            dd($data);

            $form_value = JawapanKajianKeberkesananGraduan::create($data);

            return response()->json(
                [
                    'is_success' => true,
                    'message' => __('berjaya_1'),
                    'redirect' => route('public.index'),
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => __('Form not found'),
                ],
                200
            );
        }
    }

    public function data_chart($form_id)
    {
        $chartArray = [];
        $form_values = JawapanKajianKeberkesananGraduan::select('kajian_keberkesanan_graduan.json as form_json', 'jawapan_kajian_keberkesanan_graduan.*')
            ->where('borang_kaji_selidik_id', $form_id)
            ->join('kajian_keberkesanan_graduan', 'kajian_keberkesanan_graduan.id', '=', 'jawapan_kajian_keberkesanan_graduan.borang_kaji_selidik_id');
        $form_values = $form_values->get();
        foreach ($form_values as $form_value) {
            $array1 = json_decode($form_value->form_json);
            if (isset($array1)) {
                foreach ($array1 as $rows1) {
                    foreach ($rows1 as $row_key1 => $row1) {
                        $options = [];

                        if ($row1->type != 'header' && $row1->type != 'paragraph' && $row1->type != 'date' && $row1->type != 'number' && $row1->type != 'text' && $row1->type != 'textarea') {

                            if ($row1->type == 'radio-group' || $row1->type == 'select' || $row1->type == 'checkbox-group') {
                                foreach ($row1->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row1->value)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row1->type == 'starRating') {
                                $options = [
                                    '0' => 0,
                                    '0.5' => 0,
                                    '1' => 0,
                                    '1.5' => 0,
                                    '2' => 0,
                                    '2.5' => 0,
                                    '3' => 0,
                                    '3.5' => 0,
                                    '4' => 0,
                                    '4.5' => 0,
                                    '5' => 0,
                                ];
                            } elseif ($row1->type == 'date' || $row1->type == 'number') {
                                $options = [];
                            }
                            $tmp = [
                                'label' => $row1->label,
                                'options' => $options,
                                // 'is_enable_chart' => $row1->is_enable_chart,
                                // 'chart_type' => $row1->chart_type
                            ];
                            $chartArray[$row1->name] = $tmp;
                        }
                    }
                }
            }
            $array = json_decode($form_value->json);
            foreach ($array as $rows) {

                foreach ($rows as $row_key => $row) {
                    if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                        if (!isset($chartArray[$row->name])) {
                            $options = [];
                            if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                                foreach ($row->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row->value)) {
                                    $options['other'] = 0;
                                }
                                if (isset($row->other)) {
                                    $options['other'] = 0;
                                }
                            }
                            $tmp = [
                                'label' => $row->label,
                                'options' => $options,
                                // 'is_enable_chart' => $row->is_enable_chart,
                                // 'chart_type' => $chartArray
                            ];
                            $chartArray[$row->name] = $tmp;
                        }
                        if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                            foreach ($row->values as $value) {
                                if (isset($value->selected)) {
                                    $chartArray[$row->name]['options'][$value->label]++;
                                }
                            }
                            if (isset($row->value)) {
                                if (!isset($chartArray[$row->name]['options']['other'])) {
                                    $chartArray[$row->name]['options']['other'] = 0;
                                }
                                $chartArray[$row->name]['options']['other']++;
                            }
                        }
                    }
                }
            }
        }

        return $chartArray;
    }

    public function result_survey($id)
    {

        $forms = KajianKeberkesananGraduan::all();
        $chartData = $this->data_chart($id);
        $forms_details = KajianKeberkesananGraduan::find($id);

        return view('pages.pengurusan.hep.alumni.kajian_keberkesanan.analisa', compact('forms', 'chartData', 'forms_details'));
    }
}
