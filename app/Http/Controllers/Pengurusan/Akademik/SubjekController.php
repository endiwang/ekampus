<?php

namespace App\Http\Controllers\Pengurusan\Akademik;

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
                "Maklumat Subjek" =>  false,
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

                })
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
    
            return view('pages.pengurusan.akademik.subjek.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
    public function show($id, Builder $builder)
    {
        try{

            $title = "Subjek";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Maklumat Subjek" =>  false,
            ];

            $buttons = [];

            if (request()->ajax()) {
                $data = Subjek::where('kursus_id', $id);
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

                })
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['nama','bil_subjek','action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek'],
                ['data' => 'maklumat_tambahan', 'name' => 'maklumat_tambahan', 'title' => 'Maklumat'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view('pages.pengurusan.akademik.subjek.all_subjek', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

            
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
