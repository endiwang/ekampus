<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Pengurusan\KursusDataTable;
use App\DataTables\UsersDataTable;
use App\Helpers\Utils;
use App\Models\Kursus;
use Exception;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KursusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Kursus";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Kursus" =>  false,
            ];

            $buttons = [];
            // $buttons = [
            //     [
            //         'title' => "Tambah Kursus", 
            //         'route' => route('pengurusan.akademik.kursus.create'), 
            //         'button_class' => "btn btn-sm btn-primary fw-bold",
            //         'icon_class' => "fa fa-plus-circle"
            //     ],
            // ];

            if (request()->ajax()) {
                $data = Kursus::query();
                return DataTables::of($data)
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
                ->addColumn('created_at', function($data) {
                    $format_date = Utils::formatDateTime($data->created_at);
    
                    return $format_date;
                })
                ->addColumn('action', function($data){
                    $btn = '<a href="'.route('pengurusan.pentadbir_sistem.sesi.edit',$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Pinda</a>';
    
                    return '<div class="btn-group btn-group-sm">
                        '.$btn.'
                    </div>';
                    //return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('created_at', 'desc');
                })
                ->rawColumns(['kursus','status','action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'orderable'=> false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            $courses = Kursus::where('is_deleted',0)->pluck('nama', 'id');
    
            return view('pages.pengurusan.akademik.kursus.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'courses'));

        }catch (Exception $e) {
            report($e);
    
            alert('Error', 'Uh oh! Something went Wrong', 'error');
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
        // try {

        //     $title = 'Kursus';
        //     $action = route('pengurusan.akademik.kursus.store');
        //     $page_title = 'Tambah Kursus Baru';
        //     $breadcrumbs = [
        //         "Akademik" =>  false,
        //         "Pengurusan Kursus" =>  false,
        //         "Tambah Kursus" =>  false,
        //     ];

        //     $model = new Kursus();

        //     return view('pages.pengurusan.akademik.kursus.add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

        // }catch (Exception $e) {
        //     report($e);

        //     alert('Error', 'Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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

    public function table_kursus(KursusDataTable $dataTable)
    {
        return $dataTable->render('pages.pengurusan.akademik.kursus.main');
    }
}
