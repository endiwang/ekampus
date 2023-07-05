<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\JabatanHafazanShafawi;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodHafazanShafawiController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.rekod_shafawi.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)",
                    'route' => route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = JabatanHafazanShafawi::with('pelajar');
                if($request->has('nama_pelajar') && $request->nama_pelajar != NULL)
                {
                    $data = $data->whereHas('pelajar', function($data) use ($request){
                        $data->where('nama', 'LIKE', '%'. $request->nama_pelajar . '%');
                    });
                }
                if($request->has('no_matrik') && $request->no_matrik != NULL)
                {
                    $data = $data->whereHas('pelajar', function($data) use ($request){
                        $data->where('no_matrik', 'LIKE', '%'. $request->no_matrik . '%');
                    });
                }

                return DataTables::of($data)
                ->addColumn('nama_pelajar', function($data) {
                   return $data->pelajar->nama ?? null;
                })
                ->addColumn('no_matrik', function($data) {
                    return $data->pelajar->no_matrik ?? null;
                })
                ->addColumn('created_at', function($data) {
                    return Utils::formatDate($data->created_at) ?? null;
                })
                ->addColumn('current_percentage', function($data) {
                    return number_format($data->current_percentage, 2) ?? null;
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['document_name','sesi', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable'=> false],
                ['data' => 'surah', 'name' => 'surah', 'title' => 'Hafazan Sehingga Surah', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Rekod Dicipta', 'orderable'=> false],
                ['data' => 'current_percentage', 'name' => 'current_percentage', 'title' => 'Peratus Pencapaian Semasa (%)', 'orderable'=> false],
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

            $title = 'Tambah Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.store');
            $page_title = 'Maklumat Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)" =>  route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index'),
                "Tambah Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)" => false,
            ];

            $model = new JabatanHafazanShafawi();

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', NULL)->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'students'));


        } catch (Exception $e) {
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
            'pelajar'               => 'required',
            'surah'                 => 'required|string',
            'juzuk'                 => 'required|string',
            'maqra'                 => 'required|string',
            'ayat_awal'             => 'required|string',
            'ayat_akhir'            => 'required|string',
            'muka_surat_semasa'     => 'required|integer',
            'muka_surat_akhir'      => 'required|integer',
            'baki_tasmik'           => 'required|integer',
        ],[
            'pelajar.required'              => 'Sila pilih pelajar',
            'surah.required'                => 'Sila masukkan maklumat surah',
            'juzuk.required'                => 'Sila masukkan maklumat juzuk',
            'maqra.required'                => 'Sila masukkan maklumat maqra',
            'ayat_awal.required'            => 'Sila masukkan maklumat ayat awal',
            'ayat_akhir.required'           => 'Sila masukkan maklumat ayat akhir',
            'muka_surat_semasa.required'    => 'Sila masukkan maklumat muka surat',
            'muka_surat_akhir.required'     => 'Sila masukkan maklumat muka surat',
            'baki_tasmik.required'          => 'Sila masukkan maklumat baki tasmik',
        ]);
        
        // try {
            $percentage = $request->muka_surat_semasa / $request->muka_surat_akhir * 100;
            
            $rekod = new JabatanHafazanShafawi();
            $rekod->pelajar_id          = $request->pelajar;
            $rekod->surah               = $request->surah;
            $rekod->juzuk               = $request->juzuk;
            $rekod->maqra               = $request->maqra;
            $rekod->ayat_awal           = $request->ayat_awal;
            $rekod->ayat_akhir          = $request->ayat_akhir;
            $rekod->current_page        = $request->muka_surat_semasa;
            $rekod->page_end            = $request->muka_surat_akhir;
            $rekod->remarks             = $request->catatan_tambahan;
            $rekod->page_remaining      = $request->baki_tasmik;
            $rekod->current_percentage  = $percentage ?? 0;
            $rekod->save();

            Alert::toast('Maklumat rekod hafazan lisan berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index');


        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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

            $title = 'Pinda Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.update', $id);
            $page_title = 'Maklumat Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)" =>  route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index'),
                "Pinda Rekod Hafazan Harian/Mingguan - Lisan (Shafawi)" => false,
            ];

            $model = JabatanHafazanShafawi::find($id);

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', NULL)->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'students'));


        } catch (Exception $e) {
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
            'pelajar'       => 'required',
            'surah'         => 'required|string',
            'juzuk'         => 'required|integer',
            'maqra'         => 'required|string',
            'ayat_awal'     => 'required|integer',
            'ayat_akhir'    => 'required|integer',
            'muka_surat'    => 'required|integer',
            'baki_tasmik'   => 'required|integer',
        ],[
            'pelajar.required'      => 'Sila pilih pelajar',
            'surah.required'        => 'Sila masukkan maklumat surah',
            'juzuk.required'        => 'Sila masukkan maklumat juzuk',
            'maqra.required'        => 'Sila masukkan maklumat maqra',
            'ayat_awal.required'    => 'Sila masukkan maklumat ayat awal',
            'ayat_akhir.required'   => 'Sila masukkan maklumat ayat akhir',
            'muka_surat.required'   => 'Sila masukkan maklumat muka surat',
            'baki_tasmik.required'  => 'Sila masukkan maklumat baki tasmik',
        ]);
        
        try {
            $percentage = $request->page / $request->baki_tasmik * 100;
            
            $rekod = JabatanHafazanShafawi::find($id);
            $rekod->pelajar_id          = $request->pelajar;
            $rekod->surah               = $request->surah;
            $rekod->juzuk               = $request->juzuk;
            $rekod->maqra               = $request->maqra;
            $rekod->ayat_awal           = $request->ayat_awal;
            $rekod->ayat_akhir          = $request->ayat_akhir;
            $rekod->page                = $request->muka_surat;
            $rekod->remarks             = $request->catatan_tambahan;
            $rekod->page_remaining      = $request->baki_tasmik;
            $rekod->current_percentage  = $percentage ?? 0;
            $rekod->save();

            Alert::toast('Maklumat rekod latihan industri berjaya dikemaskini!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index');


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
        try {

            JabatanHafazanShafawi::find($id)->delete();

            Alert::toast('Maklumat rekod hafazan lisan (shafawi) berjaya dihapuskan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index');


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
