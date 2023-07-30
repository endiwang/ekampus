<?php

namespace App\Http\Controllers\Pengurusan\Akademik\eLearning;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\ELearningSyllabus;
use App\Models\ELearningSyllabusContent;
use App\Models\Kursus;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use File;

class PengurusanKandunganController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.e_learning.pengurusan_kandungan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = "Pengurusan Kandungan Pembelajaran";
            $breadcrumbs = [
                "Akademik" =>  false,
                "E-Learning" =>  false,
                "Pengurusan Kandungan Pembelajaran" => false
            ];

            $buttons = [
                [
                    'title' => "Tambah Kandungan Pembelajaran", 
                    'route' => route('pengurusan.akademik.e_learning.pengurusan_kandungan.create'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = ELearningSyllabus::with('kursus', 'createdBy', 'subjek')->where('deleted_at', NULL)->where('status', 0);
                return DataTables::of($data)
                ->addColumn('kursus', function($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('subjek', function($data) {
                    return $data->subjek->nama ?? null;
                })
                ->addColumn('created_by', function($data) {
                    return $data->createdBy->nama ?? null;
                })
                ->addColumn('status', function($data) {
                    if($data->status == 0)
                    {
                        return 'Aktif';
                    }
                    elseif($data->status == 1)
                    {
                        return 'Tidak Aktif';
                    }
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.e_learning.pengurusan_kandungan.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.e_learning.pengurusan_kandungan.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kandungan', 'orderable'=> false ],
                ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'orderable'=> false],
                ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable'=> false],
                ['data' => 'created_by', 'name' => 'created_by', 'title' => 'Dicipta Oleh', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons'));

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

            $title = 'Hebahan Aktiviti';
            $action = route('pengurusan.akademik.e_learning.pengurusan_kandungan.store');
            $page_title = 'Tambah Hebahan Aktiviti';
            $breadcrumbs = [
                "Akademik" =>  false,
                "E-Learning" =>  route('pengurusan.akademik.e_learning.pengurusan_kandungan.index'),
                "Tambah Kandungan Pembelajaran" =>  false,
            ];

            $model = new ELearningSyllabus();

            $types = [
                'bahan_sokongan' => 'Bahan Sokongan',
                'tugasan' => 'Tugasan'
            ];

            $subjects = Subjek::select('id', 'nama', 'kod_subjek')->where('deleted_at', NULL)->where('status', 1)->get();

            return view($this->baseView.'create', compact('title', 'action', 'page_title', 'breadcrumbs', 'model', 'types', 'subjects'));

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
        try {

            $kursus = Subjek::find($request->kursus);

            $data = new ELearningSyllabus();
            $data->kursus_id    = $kursus->id;
            $data->subjek_id    = $request->kursus;
            $data->nama         = $request->nama_kandungan;
            $data->penerangan   = $request->penerangan;
            $data->status       = $request->status;
            $data->created_by   = auth()->user()->id;
            $data->save();

            foreach($request->data as $value)
            {
                if(!empty($value['file']))
                { 
                    $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                    $file_extension = $value['file']->getClientOriginalExtension();
                    $file_path = 'uploads/elearning/kandungan_pembelajaran';
                    $file_data = $value['file'];
                    $file = $value['file'];
                    $file->move($file_path, $file_name);
                    $file = $file_path . '/' .$file_name;

                    ELearningSyllabusContent::create([
                        'e_learning_syllabus_id'=> $data->id,
                        'type'                  => $value['type'],
                        'file_name'             => $value['file_name'],
                        'file_mime_type'        => $file_extension,
                        'file_path'             => $file,
                        'status'                => $value['status'],
                        'created_by'            => auth()->user()->id
                    ]);
                }
            }

            Alert::toast('Kandungan Pembelajaran berjaya dicipta!', 'success');
            return redirect()->route('pengurusan.akademik.e_learning.pengurusan_kandungan.index');


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
    public function edit(Builder $builder, $id)
    {
        try {

            $title = 'Kandungan Pembelajaran';
            $action = route('pengurusan.akademik.e_learning.pengurusan_kandungan.update_kandungan_pemebelajaran', $id);
            $page_title = 'Kemaskini Kandungan Pembelajaran';
            $breadcrumbs = [
                "Akademik" =>  false,
                "E-Learning" => false,
                "Pengurusan Kandungan Pembelajaran" =>  route('pengurusan.akademik.e_learning.pengurusan_kandungan.index'),
                "Pinda Laporan Mesyuarat" =>  false,
            ];

            $model = ELearningSyllabus::find($id);
            $types = [
                'bahan_sokongan' => 'Bahan Sokongan',
                'tugasan' => 'Tugasan'
            ];
            $subjects = Subjek::select('id', 'nama', 'kod_subjek')->where('deleted_at', NULL)->where('status', 1)->get();

            if (request()->ajax()) {
                $data = ELearningSyllabusContent::where('e_learning_syllabus_id', $id);
                return DataTables::of($data)
                ->addColumn('type', function($data) {
                    $type = '';

                    if($data->type == 'bahan_sokongan')
                    {
                        $type = 'Bahan Sokongan';
                    }
                    elseif($data->type == 'tugasan')
                    {
                        $type = 'Assignment/Tugasan';
                    }
                    return $type;
                })
                ->addColumn('created_at', function($data) {
                    return Utils::formatDate($data->created_at);
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.e_learning.pengurusan_kandungan.download',$data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.e_learning.pengurusan_kandungan.delete_file', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'file_name', 'name' => 'file_name', 'title' => 'Nama Fail', 'orderable'=> false, ],
                ['data' => 'type', 'name' => 'type', 'title' => 'Jenis Kandungan', 'orderable'=> false, ],
                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Muat Naik', 'orderable'=> false, ],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'types', 'subjects','id', 'dataTable'));

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
        try {

            $kursus = Subjek::find($request->kursus);

            $data = ELearningSyllabus::findOrFail($id);
            $data->kursus_id    = $kursus->id;
            $data->subjek_id    = $request->kursus;
            $data->nama         = $request->nama_kandungan;
            $data->penerangan   = $request->penerangan;
            $data->status       = $request->status;
            $data->created_by   = auth()->user()->id;
            $data->save();

            Alert::toast('Kandungan Pembelajaran berjaya dikemaskini!', 'success');
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
        try {
            $syllable_files = ELearningSyllabusContent::where('e_learning_syllabus_id', $id)->count();

            //detach, delete file from server
            if($syllable_files != 0)
            {
                ELearningSyllabusContent::where('e_learning_syllabus_id', $id)->delete();
            }

            $delete = ELearningSyllabus::find($id)->delete();
            
            Alert::toast('Maklumat kandungan pembelajaran berjaya dihapuskan!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function uploadFile(Request $request, $id)
    {
        try {

            $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $file_extension = $request->file->getClientOriginalExtension();
            $file_path = 'uploads/elearning/kandungan_pembelajaran';
            $file = $request->file;
            $file->move($file_path, $file_name);
            $file = $file_path . '/' .$file_name;

            ELearningSyllabusContent::create([
                'e_learning_syllabus_id'=> $id,
                'type'                  => $request->type,
                'file_name'             => $request->file_name,
                'file_mime_type'        => $file_extension,
                'file_path'             => $file,
                'status'                => $request->status,
                'created_by'            => auth()->user()->id
            ]);

            Alert::toast('Kandungan Pembelajaran berjaya ditambah!', 'success');
            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function download(Request $request, $id)
    {
        try {
            $download = ELearningSyllabusContent::find($id);

            return response()->file(public_path($download->file_path));
            
        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function deleteFile($id)
    {
        try {

            $check_file = ELearningSyllabusContent::find($id);

            if(File::exists(public_path($check_file->file_path))){
                File::delete(public_path($check_file->file_path));

                $delete_file = $check_file->delete();
            }else{
                Alert::toast('File does not exist', 'error');
                return redirect()->back();
            }

            Alert::toast('Fail Kandungan Pembelajaran Berjaya Dihapuskan!', 'success');
            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
