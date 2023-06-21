<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Http\Controllers\Controller;
use App\Models\IjazahTesis;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodTesisController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_ijazah.projek_ilmiah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Rekod Tesis/Projek Ilmiah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Tesis/Projek Ilmiah" =>  false,
            ];

            if (request()->ajax()) {
                $data = IjazahTesis::query();
                if($request->has('nama_fail') && $request->nama_fail != NULL)
                {
                    $data = $data->where('file_name', 'LIKE', '%' . $request->nama_fail . '%');
                }
                if($request->has('jenis_dokumen') && $request->jenis_dokumen != NULL)
                {
                    $data = $data->where('document_type',  $request->jenis_dokumen);
                }

                return DataTables::of($data)
                ->addColumn('status', function($data) {
                    switch($data->status)
                    {
                        case 1 :
                            return 'Serahan Baru';
                        break;

                        case 2 :
                            return 'Dalam Proses';
                        break;

                        case 3 :
                            return 'Lulus';
                        break;

                        case 3 :
                            return 'Gagal';
                        break;
                    }
                  
                })
                ->addColumn('uploaded_document', function($data) {
                    return '<a href="'. route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.download', $data->id) .'" target="_blank">'. $data->file_name.'</a>';
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['uploaded_document', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'project_name', 'name' => 'project_name', 'title' => 'Nama Projek', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'project_title', 'name' => 'project_title', 'title' => 'Tajuk Tesis', 'orderable'=> false],
                ['data' => 'uploaded_document', 'name' => 'uploaded_document', 'title' => 'Fail Tesis/Projek Ilmiah', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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
        // try {

            $title = 'Pinda Rekod Tesis/Projek Ilmiah';
            $action = route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.update', $id);
            $page_title = 'Maklumat Rekod Tesis/Projek Ilmiah';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Maklumat Graduasi" =>  route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index'),
                "Pinda Rekod Maklumat Graduasi" => false,
            ];

            $model = IjazahTesis::find($id);

            $statuses = [
                1 => 'Serahan Baru',
                2 => 'Dalam Proses',
                3 => 'Lulus',
                4 => 'Gagal'
            ];

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'statuses', 'id'));


        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
        try {
            
            $data = IjazahTesis::find($id);
            $data->status       = $request->status;
            $data->remarks           = $request->komen;
            $data->save();

            Alert::toast('Maklumat rekod tesis/projek ilmiah berjaya dipinda!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index');


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

    public function download($id)
    {
        $download = IjazahTesis::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
