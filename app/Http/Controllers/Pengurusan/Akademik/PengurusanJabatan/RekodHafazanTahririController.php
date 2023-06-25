<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\JabatanHafazanTahriri;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodHafazanTahririController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Rekod Bertulis (Tahriri)";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Bertulis (Tahriri)" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Bertulis (Tahriri)",
                    'route' => route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = JabatanHafazanTahriri::with('pelajar');
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
                    return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.destroy', $data->id).'" method="POST">
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
                ['data' => 'ayat', 'name' => 'ayat', 'title' => 'Ayat', 'orderable'=> false, 'class'=>'text-bold'],
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

            $title = 'Tambah Rekod Bertulis (Tahriri)';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.store');
            $page_title = 'Maklumat Rekod Bertulis (Tahriri)';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Bertulis (Tahriri)" =>  route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index'),
                "Tambah Rekod Bertulis (Tahriri)" => false,
            ];

            $model = new JabatanHafazanTahriri();

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
            'juzuk'                 => 'required|integer',
            'ayat'                  => 'required|string',
            'mukasurat_semasa'      => 'required|integer',
            'mukasurat_sepatutnya'  => 'required|integer',
            'baki'                  => 'required|integer',
        ],[
            'pelajar.required'              => 'Sila pilih pelajar',
            'juzuk.required'                => 'Sila masukkan maklumat juzuk',
            'ayat.required'                 => 'Sila masukkan maklumat ayat',
            'mukasurat_semasa.required'     => 'Sila masukkan maklumat mukasurat semasa',
            'mukasurat_sepatutnya.required' => 'Sila masukkan maklumat mukasurat sepatutnya',
            'baki.required'                 => 'Sila masukkan maklumat muka surat',
        ]);
        
        try {
            $percentage = $request->mukasurat_semasa / $request->mukasurat_sepatutnya * 100;
            
            $rekod = new JabatanHafazanTahriri();
            $rekod->pelajar_id          = $request->pelajar;
            $rekod->juzuk               = $request->juzuk;
            $rekod->ayat                = $request->ayat;
            $rekod->current_page        = $request->mukasurat_semasa;
            $rekod->designated_page     = $request->mukasurat_sepatutnya;
            $rekod->balance             = $request->baki;
            $rekod->current_percentage  = $percentage ?? 0;
            $rekod->created_by          = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat rekod bertulis (tahriri) berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index');


        } catch (Exception $e) {
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

            $title = 'Pinda Rekod Bertulis (Tahriri)';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.update', $id);
            $page_title = 'Maklumat Rekod Bertulis (Tahriri)';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Jabatan" =>  false,
                "Rekod Rekod Bertulis (Tahriri)" =>  route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index'),
                "Pinda Rekod Bertulis (Tahriri)" => false,
            ];

            $model = JabatanHafazanTahriri::find($id);

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
            'pelajar'               => 'required',
            'juzuk'                 => 'required|integer',
            'ayat'                  => 'required|string',
            'mukasurat_semasa'      => 'required|integer',
            'mukasurat_sepatutnya'  => 'required|integer',
            'baki'                  => 'required|integer',
        ],[
            'pelajar.required'              => 'Sila pilih pelajar',
            'juzuk.required'                => 'Sila masukkan maklumat juzuk',
            'ayat.required'                 => 'Sila masukkan maklumat ayat',
            'mukasurat_semasa.required'     => 'Sila masukkan maklumat mukasurat semasa',
            'mukasurat_sepatutnya.required' => 'Sila masukkan maklumat mukasurat sepatutnya',
            'baki.required'                 => 'Sila masukkan maklumat muka surat',
        ]);
        
        try {
            $percentage = $request->baki / $request->mukasurat_sepatutnya * 100;
            
            $rekod = JabatanHafazanTahriri::find($id);
            $rekod->pelajar_id          = $request->pelajar;
            $rekod->juzuk               = $request->juzuk;
            $rekod->ayat                = $request->ayat;
            $rekod->current_page        = $request->mukasurat_semasa;
            $rekod->designated_page     = $request->mukasurat_sepatutnya;
            $rekod->balance             = $request->baki;
            $rekod->current_percentage  = $percentage ?? 0;
            $rekod->save();

            Alert::toast('Maklumat rekod bertulis (tahriri) berjaya dikemaskini!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index');


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

            JabatanHafazanTahriri::find($id)->delete();

            Alert::toast('Maklumat rekod bertulis (tahriri) berjaya dihapuskan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index');


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
