<?php

namespace App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPensyarah;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KehadiranPensyarahController extends Controller
{
    protected $baseView = 'pages.pengurusan.kakitangan.kehadiran.pensyarah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Rekod Kehadiran Pensyarah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Rekod Kehadiran Pensyarah" =>  false,
            ];

            $modals = [
                [
                    'title'         => "Imbas Kod QR",  
                    'id'            => "#kodQr",
                    'button_class'  => "btn btn-sm btn-primary fw-bold",
                    'icon_class'    => "fa-solid fa-qrcode"
                ],
            ];

            if (request()->ajax()) {
                $data = KehadiranPensyarah::with('staff')->where('staff_id', auth()->user()->id);
                return DataTables::of($data)
                ->addColumn('nama', function($data){
                    return $data->staff->nama ?? null;
                })
                ->addColumn('staff_id', function($data){
                    return $data->staff->staff_id ?? null;
                })
                ->addColumn('tarikh_masuk', function($data){
                    return Utils::formatDate($data->tarikh_masuk) ?? null;
                })
                ->addColumn('masa_masuk', function($data){
                    return Utils::formatTime($data->masa_masuk) ?? null;
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.kakitangan.kehadiran.pelajar.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
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
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'staff_id', 'name' => 'staff_id', 'title' => 'No. Kakitangan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh', 'orderable'=> false],
                ['data' => 'masa_masuk', 'name' => 'masa_masuk', 'title' => 'Masa', 'orderable'=> false],
                // ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

            $date = Utils::formatMonth(now());

            $qr_code = QrCode::size(500)->generate(route('pensyarah.kehadiran.submit', [auth()->user()->id, $date]));

            $generated_at = Utils::formatDate(now());
    
            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'qr_code', 'modals', 'generated_at'));

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

    public function getKehadiranForm($staff_id, $date)
    {
        
        try{

            $action = route('pensyarah.kehadiran.submit');

            return view($this->baseView.'attendance_form', compact('action', 'staff_id', 'date'));

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function submitKehadiran(Request $request)
    {
        try{
            $staff_exist = Staff::where('staff_id', $request->staff_id)->first();

            if(!empty($staff_exist))
            {
                $attendance = new KehadiranPensyarah();
                $attendance->staff_id       = $staff_exist->id;
                $attendance->tarikh_masuk   = now();
                $attendance->masa_masuk     = now();
                $attendance->save();

                return redirect()->route('pensyarah.kehadiran.successful');
            }
            else {
                Alert::toast('Maklumat no kakitangan tidak sah!', 'error');
                return redirect()->back();
            }

        }catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function successfulSubmission()
    {
        return view('pages.pengurusan.kakitangan.kehadiran.pelajar.thank_you_page');
    }
}
