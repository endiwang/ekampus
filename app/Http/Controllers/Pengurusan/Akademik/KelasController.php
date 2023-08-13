<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KelasController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.kelas.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Kelas';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Kelas' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Kelas',
                    'route' => route('pengurusan.akademik.kelas.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = Kelas::with('currentSemester', 'currentSyukbah');

                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        if (! empty($data->nama)) {
                            $jantina = '';
                            switch ($data->semasa_jantina) {
                                case 'BN':
                                    $jantina = 'Lelaki';
                                    break;
                                case 'BT':
                                    $jantina = 'Perempuan';
                            }

                            return $data->nama.' ('.$jantina.')';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('semasa_semester_id', function ($data) {
                        if (! empty($data->semasa_semester_id)) {
                            return $data->currentSemester->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('semasa_syukbah_id', function ($data) {
                        if (! empty($data->semasa_syukbah_id)) {
                            return $data->currentSyukbah->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('jumlah_pelajar', function ($data) {
                        return $data->count_pelajar ?? 0;
                    })
                    ->addColumn('status_guru_tasmik', function ($data) {
                        return 'Tiada';
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
                        return '<a href="'.route('pengurusan.pentadbir_sistem.kakitangan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kehadiran">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pengurusan.akademik.kelas.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kelas.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['kursus', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kelas', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'semasa_semester_id', 'name' => 'semasa_semester_id', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Tahun', 'orderable' => false],
                    ['data' => 'semasa_syukbah_id', 'name' => 'semasa_syukbah_id', 'title' => 'Syukbah', 'orderable' => false],
                    ['data' => 'jumlah_pelajar', 'name' => 'jumlah_pelajar', 'title' => 'Bil Pelajar', 'orderable' => false],
                    ['data' => 'status_guru_tasmik', 'name' => 'status_guru_tasmik', 'title' => 'Status Guru Tasmik', 'orderable' => false],
                    ['data' => 'kapasiti_pelajar', 'name' => 'kapasiti_pelajar', 'title' => 'Kuota Pelajar', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

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
    public function create(Builder $builder)
    {
        try {

            $title = 'Kelas';
            $action = route('pengurusan.akademik.pengurusan_kelas.store');
            $page_title = 'Tambah Kelas Baru';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Kelas' => false,
                'Tambah Kelas' => false,
            ];

            $model = new Kelas();

            $genders = [
                'BN' => 'Kelas Banin (Lelaki)',
                'BT' => 'Kelas Banat (Perempuan)',
            ];

            $dataTable = $builder->columns([]);

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'genders', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = $request->validate([
            'nama_kelas' => 'required',
            'bilangan_pelajar' => 'required',
            'jantina_pelajar' => 'required',
        ], [
            'nama_kelas.required' => 'Sila masukkan maklumat nama kelas',
            'bilangan_pelajar.required' => 'Sila masukkan maklumat bilangan pelajar',
            'jantina_pelajar.required' => 'Sila pilih jantina',
        ]);

        try {

            Kelas::create([
                'nama' => $request->nama_kelas,
                'kapasiti_pelajar' => $request->bilangan_pelajar,
                'semasa_jantina' => $request->jantina_pelajar,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat kelas berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.kelas.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Builder $builder)
    {
        try {

            $model = Kelas::find($id);

            $title = 'Kelas';
            $action = route('pengurusan.akademik.kelas.update', $id);
            $page_title = 'Pinda Kelas'.$model->name;
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Kelas' => route('pengurusan.akademik.kelas.index'),
                'Pinda Kelas' => false,
            ];

            $genders = [
                'BN' => 'Kelas Banin (Lelaki)',
                'BT' => 'Kelas Banat (Perempuan)',
            ];

            if (request()->ajax()) {
                $data = Pelajar::with('sesi', 'kursus')->where('kelas_id', $id);

                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        $student_name = $data->nama ?? '';
                        $tasmik = $data->nama ?? '';

                        return '<p>'.$student_name.' <br/> <span style="font-style:italic">GT : '.$tasmik.'</span></p>';
                    })
                    ->addColumn('kursus_id', function ($data) {
                        if (! empty($data->kursus_id)) {
                            return $data->kursus->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('sesi_id', function ($data) {
                        if (! empty($data->sesi_id)) {
                            return $data->sesi->nama ?? 'N/A';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('semester', function ($data) {
                        return '<p class="text-center">'.$data->semester.'</p>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['nama', 'semester'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar / Guru Tasmik', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No Kad Pengenalan', 'orderable' => false],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian [Syukbah]', 'orderable' => false],
                    ['data' => 'sesi_id', 'name' => 'semasa_syukbah_id', 'title' => 'Sesi Pengajian', 'orderable' => false],
                    ['data' => 'semester', 'name' => 'semester', 'title' => 'Semester', 'orderable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'genders', 'dataTable'));

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

        $validation = $request->validate([
            'nama_kelas' => 'required',
            'bilangan_pelajar' => 'required',
            'jantina_pelajar' => 'required',
        ], [
            'nama_kelas.required' => 'Sila masukkan maklumat nama kelas',
            'bilangan_pelajar.required' => 'Sila masukkan maklumat bilangan pelajar',
            'jantina_pelajar.required' => 'Sila pilih jantina',
        ]);

        try {

            Kelas::where('id', $id)->update([
                'nama' => $request->nama_kelas,
                'kapasiti_pelajar' => $request->bilangan_pelajar,
                'semasa_jantina' => $request->jantina_pelajar,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat kelas berjaya dipinda!', 'success');

            return redirect()->route('pengurusan.akademik.kelas.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

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

            $kelas = Kelas::find($id);

            if ($kelas->count_pelajar == 0) {
                $kelas = $kelas->delete();

                Alert::toast('Maklumat kelas berjaya dihapus!', 'success');

                return redirect()->back();
            } else {
                Alert::toast('Pelajar wujud di dalam kelas! Kelas tidak boleh dihapuskan!', 'error');

                return redirect()->back();
            }

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

            return redirect()->back();
        }
    }

    public function exportStudentByClass(Request $request)
    {
        try {
            $class_detail = Kelas::select('nama')->find($request->class_id);
            $title = 'Senarai Pelajar bagi '.$class_detail->nama;

            $type = $request->export_type;
            switch ($type) {
                case 'pdf':

                    $datas = $this->exportDataProcess($request->class_id);
                    $view_file = $this->baseView.'export_pdf';
                    $orientation = 'landscape';

                    return Utils::pdfGenerate($title, $datas, $view_file, $orientation);

                    break;

                case 'excel':

                    break;
            }

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

            return redirect()->back();
        }
    }

    private function exportDataProcess($class_id)
    {

        $students = Pelajar::with('sesi', 'kursus')->where('kelas_id', $class_id)->get();

        $class = Kelas::find($class_id);

        $datas = [
            'class_name' => $class->nama,
            'max_student' => $class->kapasiti_pelajar,
            'status' => $class->status == 0 ? 'Aktif' : 'Tidak Aktif',
            'students' => $students,
        ];

        return $datas;

    }
}
