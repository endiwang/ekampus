<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\SoalanPenilaian;
use App\Models\SoalanPenilaianRating;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianPensyarahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.penilaian_pensyarah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Soalan Penilaian Pensyarah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Soalan Penilaian Pensyarah" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Skala Penilaian", 
                    'route' => route('pengurusan.akademik.pengurusan.penilaian_pensyarah.rating'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
                [
                    'title' => "Tambah Soalan Penilaian", 
                    'route' => route('pengurusan.akademik.pengurusan.penilaian_pensyarah.create'), 
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = SoalanPenilaian::with('createdBy');
                return DataTables::of($data)
                ->addColumn('created_at', function($data) {
                    return !empty($data->created_at) ? Utils::formatDate($data->record_date) : null;
                })
                ->addColumn('created_by', function($data) {
                    return !empty($data->createdBy->nama) ? $data->createdBy->nama : null;
                })
                ->addColumn('active_status', function($data) {
                    switch ($data->active_status) {
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                          break;
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        default:
                          return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.pengurusan.penilaian_pensyarah.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.penilaian_pensyarah.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('order', 'asc');
                })
                ->rawColumns(['description', 'active_status', 'action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'description', 'name' => 'description', 'title' => 'Soalan', 'orderable'=> false ],
                ['data' => 'order', 'name' => 'order', 'title' => 'Turutan Soalan', 'orderable'=> false],
                ['data' => 'created_by', 'name' => 'created_by', 'title' => 'Dicipta Oleh', 'orderable'=> false],
                ['data' => 'active_status', 'name' => 'active_status', 'title' => 'Status', 'orderable'=> false],
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

            $title = 'Soalan Penilaian Pensyarah';
            $action = route('pengurusan.akademik.pengurusan.penilaian_pensyarah.store');
            $page_title = 'Tambah Soalan Penilaian Pensyarah';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Soalan Penilaian Pensyarah" =>  route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index'),
                "Tambah Soalan Penilaian Pensyarah" =>  false,
            ];

            $model = new SoalanPenilaian();

            return view($this->baseView.'create-update', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

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
            'description'   => 'required',
            'order'         => 'required',
        ],[
            'description.required'  => 'Sila masukkan maklumat soalan',
            'order.required'        => 'Sila masukkan maklumat turutan soalan',
        ]);
        
        try {

            $aktiviti = new SoalanPenilaian();
            $aktiviti->description  = $request->description;
            $aktiviti->order        = $request->order;
            $aktiviti->created_by   = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat Soalan Penilaian berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index');

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

            $title = 'Soalan Penilaian Pensyarah';
            $action = route('pengurusan.akademik.pengurusan.penilaian_pensyarah.update', $id);
            $page_title = 'Pinda Soalan Penilaian Pensyarah';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Soalan Penilaian Pensyarah" =>  route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index'),
                "Soalan Penilaian Pensyarah" =>  route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index'),
                "Pinda Soalan Penilaian Pensyarah" =>  false,
            ];

            $model = SoalanPenilaian::find($id);

            return view($this->baseView.'create-update', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));

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
            'description'   => 'required',
            'order'         => 'required',
        ],[
            'description.required'  => 'Sila masukkan maklumat soalan',
            'order.required'        => 'Sila masukkan maklumat turutan soalan',
        ]);
        
        try {

            $aktiviti = SoalanPenilaian::find($id);
            $aktiviti->description  = $request->description;
            $aktiviti->order        = $request->order;
            $aktiviti->created_by   = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat Soalan Penilaian berjaya dipinda!', 'success');
            return redirect()->back();

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
            SoalanPenilaian::find($id)->delete();

            Alert::toast('Maklumat Soalan berjaya dihapus!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function createRating(Builder $builder)
    {
        try {

            $title = 'Skala Penilaian';
            $page_title = 'Skala Penilaian';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Soalan Penilaian Pensyarah" =>  route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index'),
                "Skala Penilaian" =>  route('pengurusan.akademik.pengurusan.penilaian_pensyarah.rating'),
            ];

            $modals = [
                [
                    'title'         => "Tambah Skala Penilaian",  
                    'id'            => "#addSkalaPenilaian",
                    'button_class'  => "btn btn-sm btn-primary fw-bold",
                    'icon_class'    => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = SoalanPenilaianRating::query();
                return DataTables::of($data)
                ->addColumn('action', function($data){
                    return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.penilaian_pensyarah.rating.delete', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('order', 'desc');
                })
                ->rawColumns(['description', 'active_status', 'action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'description', 'name' => 'description', 'title' => 'Skala', 'orderable'=> false ],
                ['data' => 'order', 'name' => 'order', 'title' => 'Markah', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'create-rating', compact('title', 'breadcrumbs', 'modals','dataTable'));

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function storeRating(Request $request)
    {
        $validation = $request->validate([
            'description'   => 'required',
            'order'         => 'required',
        ],[
            'description.required'  => 'Sila masukkan maklumat soalan',
            'order.required'        => 'Sila masukkan maklumat turutan soalan',
        ]);
        
        try {

            $aktiviti = new SoalanPenilaianRating();
            $aktiviti->description  = $request->description;
            $aktiviti->order        = $request->order;
            $aktiviti->save();

            Alert::toast('Maklumat Skala Penilaian berjaya disimpan!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function deleteRating($id)
    {
        try {
            SoalanPenilaianRating::find($id)->delete();

            Alert::toast('Maklumat Skala berjaya dihapus!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }
}
