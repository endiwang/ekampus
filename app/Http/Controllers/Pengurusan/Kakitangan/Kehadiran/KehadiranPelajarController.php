<?php

namespace App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPelajar;
use App\Models\Pelajar;
use App\Models\PensyarahKelas;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KehadiranPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.kakitangan.kehadiran.pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

        $title = 'Rekod Kehadiran Pelajar';
        $breadcrumbs = [
            'Akademik' => false,
            'Rekod Kehadiran Pelajar' => false,
        ];

        if (request()->ajax()) {
            $data = PensyarahKelas::with('subjek')->where('staff_id', auth()->user()->id);

            return DataTables::of($data)
                ->addColumn('kod_subjek', function ($data) {
                    return $data->subjek->kod_subjek ?? null;
                })
                ->addColumn('nama', function ($data) {
                    return $data->subjek->nama ?? null;
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="'.route('pengurusan.kakitangan.kehadiran.pelajar.show', $data->subjek_id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
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
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'kod_subjek', 'name' => 'nama', 'title' => 'Kod Subjek', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $title = 'Kehadiran Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Kehadiran Pelajar' => false,
            ];

            //to do generate URL to payment
            $date = Utils::formatDate2(now());
            $qr_code = QrCode::size(500)->generate(route('kehadiran.submit', [$id, $date]));

            $subjek = Subjek::find($id);
            $generated_at = Utils::formatDateTime(now());

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'qr_code', 'subjek', 'generated_at', 'id'));

        } catch (Exception $e) {
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

    public function downloadQr($id)
    {
        try {
            $route = route('kehadiran.submit', [$id, now()]);
            $subjek = Subjek::find($id);
            $generated_at = Utils::formatDateTime(now());

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.generated_qr_pdf', compact('route', 'subjek', 'generated_at'));

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function getKehadiranForm($subjek_id, $date)
    {
        try {

            $action = route('kehadiran.pelajar.submit');
            $subject = Subjek::find($subjek_id);

            return view($this->baseView.'attendance_form', compact('action', 'subjek_id', 'date', 'subject'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function submitKehadiran(Request $request)
    {
        try {
            //check if no matrik exist
            $student_exist = Pelajar::where('no_matrik', $request->no_matrik)->first();

            if (! empty($student_exist)) {
                $attendance = new KehadiranPelajar();
                $attendance->pelajar_id = $student_exist->id;
                $attendance->subjek_id = $request->subjek_id;
                $attendance->tarikh = now();
                $attendance->waktu = now();
                $attendance->save();

                return redirect()->route('kehadiran.pelajar.successful');
            } else {
                Alert::toast('Maklumat no matrik tidak sah!', 'error');

                return redirect()->back();
            }

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function successfulSubmission()
    {
        return view($this->baseView.'thank_you_page');
    }
}
