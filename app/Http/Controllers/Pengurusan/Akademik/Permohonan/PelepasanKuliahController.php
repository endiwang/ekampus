<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\PelepasanKuliah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PelepasanKuliahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.permohonan.pelepasan_kuliah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Pelepasan Kuliah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => false,
            ];

            if (request()->ajax()) {
                $data = PelepasanKuliah::with('pelajar');

                return DataTables::of($data)
                    ->addColumn('nama_pelajar', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        $tarikh = Utils::formatDate($data->tarikh_mula).' - '.Utils::formatDate($data->tarikh_akhir);

                        return $tarikh;
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return 'Baru Diterima';
                                break;

                            case 2:
                                return 'Dalam Proses';
                                break;

                            case 3:
                                return 'Lulus';
                                break;

                            case 4:
                                return 'Tolak';
                                break;
                        }
                    })
                    ->addColumn('status_pengesahan_pensyarah', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return 'Menunggu Pengesahan Pensyarah';
                                break;

                            case 2:
                                return 'Lulus';
                                break;

                            case 3:
                                return 'Tolak';
                                break;

                            default:
                                return 'Tiada Status';
                                break;
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.permohonan.pelepasan_kuliah.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['no_ic', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_permohonan', 'name' => 'nama_permohonan', 'title' => 'Nama Permohonan', 'orderable' => false],
                    ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pemohon', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Pelepasan', 'orderable' => false],
                    ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable' => false],
                    // ['data' => 'status_pengesahan_pensyarah', 'name' => 'status_pengesahan_pensyarah', 'title' => 'Pengesahan Pensyarah', 'orderable'=> false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

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
        try {

            $title = 'Pelepasan Kuliah';
            $page_title = 'Maklumat Permohonan Pelepasan Kuliah';
            $action = route('pengurusan.akademik.permohonan.pelepasan_kuliah.update', $id);
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => route('pengurusan.akademik.permohonan.pelepasan_kuliah.biodata', [$id, auth()->user()->id]),
                'Maklumat Permohonan Pelepasan Kuliah' => false,
            ];

            $buttons = [
                [
                    'title' => 'Biodata Pelajar',
                    'route' => route('pengurusan.akademik.pengurusan.aktiviti_pdp.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa-solid fa-circle-info',
                ],
            ];

            $data = PelepasanKuliah::find($id);

            $statuses = [
                1 => 'Baru Diterima',
                2 => 'Proses',
                3 => 'Lulus',
                4 => 'Tolak',
            ];

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'action', 'data', 'buttons', 'statuses'));

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
        try {

            $update = PelepasanKuliah::with('user')->find($id);
            $update->komen = $request->komen;
            $update->status = $request->status_permohonan;
            $update->tandatangan_oleh = $request->tandatangan_oleh;
            $update->salinan_kepada = $request->salinan_kp;
            $update->tarikh_sokongan = now();
            $update->save();

            $description = '';
            if ($request->status_permohonan == 3) {
                $description = 'Status Permohonan pelepasan kuliah anda DILULUSKAN, sila cetak surat kebenaran';
            } elseif ($request->status_permohonan == 4) {
                $description = 'Status Permohonan pelepasan kuliah anda DITOLAK';
            }
            Utils::notify($update->user_id, $description);

            //send email to notify
            //to do to confirm either pelajar need email to register
            // $mail_data = [
            //    'description' => $description
            // ];
            //$email = $update->user->email;
            //Mail::to($email)->send(new sendEmail($mail_data));

            Alert::toast('Keputusan permohonan pelepasan kuliah berjaya disimpan!', 'success');

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
        //
    }

    public function suratPelepasan($id)
    {
        try {
            $data = PelepasanKuliah::with('pelajar', 'pelajar.kursus', 'pelajar.semester')->find($id);
            $export_data = [
                'data' => $data,
                'date' => Utils::formatDate($data->tarikh_sokongan),
            ];
            $title = 'Surat Kebenaran Pelepasan Kuliah '.$data->pelajar->nama;

            $view_file = $this->baseView.'export_pdf';
            $orientation = 'portrait';

            return Utils::pdfGenerate($title, $export_data, $view_file, $orientation);

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

            return redirect()->back();
        }
    }

    public function biodata($id, $user_id)
    {

    }
}
