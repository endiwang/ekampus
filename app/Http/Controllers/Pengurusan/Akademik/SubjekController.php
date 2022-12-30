<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Constants\Generic;
use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SubjekController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.subjek.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Subjek";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Maklumat Kursus Bagi Maklumat Subjek" =>  false,
            ];

            $buttons = [];

            if (request()->ajax()) {
                $data = Kursus::query();
                return DataTables::of($data)
                ->addColumn('bil_subjek', function($data) {
                    return '0';
                })
                ->addColumn('action', function($data)
                {
                    return '<div class="btn-group btn-group-sm">
                            <a href="'.route('pengurusan.akademik.subjek.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Subjek">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>';
                })
                ->addColumn('bil_subjek', function($data)
                {
                    $total_subject = Subjek::where('kursus_id', $data->id)->count();

                    return '<span class="dt-center">' .$total_subject .'</span>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['nama','bil_subjek','action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kursus', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'bil_subjek', 'name' => 'bil_subjek', 'title' => 'Bilangan Subjek', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        }catch (Exception $e) {
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
    public function create($id)
    {
        try {

            $title = "Subjek";
            $action = route('pengurusan.akademik.pengurusan_subjek.store');
            $page_title = 'Tambah Maklumat Subjek';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Maklumat Kursus Bagi Maklumat Subjek" =>  route('pengurusan.akademik.subjek.index'),
                "Maklumat Subjek" =>  route('pengurusan.akademik.subjek.show', $id),
                "Tambah Maklumat Subjek" => false
            ];

            $buttons = [];

            $course = Kursus::select('id','nama')->find($id);

            $al_quran = [
                Generic::TIDAK              => 'Tidak',
                Generic::SYAFAWI_TAHRIRI_90 => 'Syafawi / Tahriri (A >= 90)',
                Generic::SYAFAWI_TAHRIRI_80 => 'Syafawi / Tahriri (A >= 80)',
            ];

            $count_info = [
                Generic::JAM_KREDIT_DIKIRA          => 'Jam Kredit Dikira Dalam Pengiraan Markah',
                Generic::JAM_KREDIT_TIDAK_DIKIRA    => 'Tidak Termasuk Dalam Pengiraan'
            ];

            $print_info = [
                Generic::DICETAK_DALAM_SLIP         => 'Dicetak Dalam Slip Keputusan',
                Generic::TIDAK_DICETAK_DALAM_SLIP   => 'Tidak Dicetak'
            ];

            $model = new Subjek();


            return view($this->baseView.'add_edit', compact('title', 'action', 'page_title', 'breadcrumbs', 'buttons', 
                    'course', 'model', 'al_quran', 'count_info', 'print_info', 'id'));

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
            'kod_subjek'        => 'required',
            'nama_subjek'       => 'required',
            'kredit'            => 'required',
            'jumlah_markah'     => 'required',
            'al_quran'          => 'required',
            'count_info'        => 'required',
            'print_info'        => 'required',
            'status'            => 'required',
        ],[
            'kod_subjek.required'      => 'Sila masukkan maklumat kod subjek',
            'nama_subjek.required'     => 'Sila masukkan maklumat nama subjek',
            'kredit.required'          => 'Sila pilih jam kredit',
            'jumlah_markah.required'   => 'Sila masukkan maklumat jumlah markah',
            'al_quran.required'        => 'Sila pilih maklumat al quran',
            'count_info.required'      => 'Sila pilih maklumat pengiraan',
            'print_info.required'      => 'Sila pilih maklumat cetakan',
        ]);

        try {
           
            Subjek::create([
                'nama'              => $request->nama_subjek,
                'kursus_id'         => $request->kursus_id,
                'kod_subjek'        => $request->kod_subjek,
                'maklumat_tambahan' => $request->kenyataan,
                'kredit'            => $request->kredit,
                'jumlah_markah'     => $request->jumlah_markah,
                'is_alquran'        => $request->al_quran,
                'is_calc'           => $request->count_info,
                'is_print'          => $request->print_info,
                'status'            => $request->status,
            ]);


            Alert::toast('Maklumat subjek berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.subjek.show', $request->kursus_id);


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
    public function show($id, Builder $builder)
    {
        try{

            $title = "Subjek";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Maklumat Kursus Bagi Maklumat Subjek" =>  route('pengurusan.akademik.subjek.index'),
                "Maklumat Subjek" =>  false,
            ];

            $buttons = [
                [
                    'title'         => "Tambah Subjek", 
                    'route'         => route('pengurusan.akademik.pengurusan_subjek.create', $id), 
                    'button_class'  => "btn btn-sm btn-primary fw-bold",
                    'icon_class'    => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Subjek::where('kursus_id', $id);
                return DataTables::of($data)
                ->addColumn('is_alquran', function($data) {
                    switch ($data->is_alquran) {
                        case 1:
                            return 'Quran [A >= 90]';
                          break;
                        case 2:
                            return 'Quran [A >= 80]';
                        default:
                          return '-';
                    }
                })
                ->addColumn('is_calc', function($data) {
                    switch ($data->is_calc) {
                        case 0:
                            return 'Ya';
                          break;
                        case 1:
                            return '-';
                        default:
                          return '-';
                    }
                })
                ->addColumn('is_print', function($data) {
                    switch ($data->is_calc) {
                        case 0:
                            return 'Ya';
                          break;
                        case 1:
                            return '-';
                        default:
                          return '-';
                    }
                })
                ->addColumn('status', function($data) {
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
                ->addColumn('action', function($data)
                {
                    return '<a href="'.route('pengurusan.akademik.pengurusan_subjek.edit',[$data->id, $data->kursus_id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.subjek.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status','action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek'],
                ['data' => 'maklumat_tambahan', 'name' => 'maklumat_tambahan', 'title' => 'Maklumat'],
                ['data' => 'kredit', 'name' => 'kredit', 'title' => 'Kredit'],
                ['data' => 'is_alquran', 'name' => 'is_alquran', 'title' => 'Al-Quran'],
                ['data' => 'is_calc', 'name' => 'is_calc', 'title' => 'Pengiraan'],
                ['data' => 'is_print', 'name' => 'is_print', 'title' => 'Cetakan'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

            
        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $course_id)
    {
        try {

            $title = "Subjek";
            $action = route('pengurusan.akademik.subjek.update', $id);
            $page_title = 'Selenggara Maklumat Subjek';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Maklumat Kursus Bagi Maklumat Subjek" =>  route('pengurusan.akademik.subjek.index'),
                "Maklumat Subjek" =>  route('pengurusan.akademik.subjek.show', $id),
                "Selenggara Maklumat Subjek" => false
            ];

            $buttons = [];

            $course = Kursus::select('id', 'nama')->find($course_id);

            $al_quran = [
                Generic::TIDAK              => 'Tidak',
                Generic::SYAFAWI_TAHRIRI_90 => 'Syafawi / Tahriri (A >= 90)',
                Generic::SYAFAWI_TAHRIRI_80 => 'Syafawi / Tahriri (A >= 80)',
            ];

            $count_info = [
                Generic::JAM_KREDIT_DIKIRA          => 'Jam Kredit Dikira Dalam Pengiraan Markah',
                Generic::JAM_KREDIT_TIDAK_DIKIRA    => 'Tidak Termasuk Dalam Pengiraan'
            ];

            $print_info = [
                Generic::DICETAK_DALAM_SLIP         => 'Dicetak Dalam Slip Keputusan',
                Generic::TIDAK_DICETAK_DALAM_SLIP   => 'Tidak Dicetak'
            ];

            $model = Subjek::find($id);


            return view($this->baseView.'add_edit', compact('title', 'action', 'page_title', 'breadcrumbs', 'buttons', 
                    'course', 'model', 'al_quran', 'count_info', 'print_info', 'id'));

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
        $validation = $request->validate([
            'kod_subjek'        => 'required',
            'nama_subjek'       => 'required',
            'kredit'            => 'required',
            'jumlah_markah'     => 'required',
            'al_quran'          => 'required',
            'count_info'        => 'required',
            'print_info'        => 'required',
            'status'            => 'required',
        ],[
            'kod_subjek.required'      => 'Sila masukkan maklumat kod subjek',
            'nama_subjek.required'     => 'Sila masukkan maklumat nama subjek',
            'kredit.required'          => 'Sila pilih jam kredit',
            'jumlah_markah.required'   => 'Sila masukkan maklumat jumlah markah',
            'al_quran.required'        => 'Sila pilih maklumat al quran',
            'count_info.required'      => 'Sila pilih maklumat pengiraan',
            'print_info.required'      => 'Sila pilih maklumat cetakan',
        ]);

        try {
           
            Subjek::where('id', $id)->update([
                'nama'              => $request->nama_subjek,
                'kursus_id'         => $request->kursus_id,
                'kod_subjek'        => $request->kod_subjek,
                'maklumat_tambahan' => $request->kenyataan,
                'kredit'            => $request->kredit,
                'jumlah_markah'     => $request->jumlah_markah,
                'is_alquran'        => $request->al_quran,
                'is_calc'           => $request->count_info,
                'is_print'          => $request->print_info,
                'status'            => $request->status,
            ]);


            Alert::toast('Maklumat subjek berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_subjek.edit', [$id, $request->kursus_id]);

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

            Subjek::find($id)->delete();

            Alert::toast('Maklumat subjek berjaya dihapuskan!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
