<?php

namespace App\Http\Controllers\Pengurusan\Pembangunan;

use App\Http\Controllers\Controller;
use App\Mail\AduanPenyelenggaraanProsesMail;
use App\Mail\AduanPenyelenggaraanProsesVendorMail;
use App\Models\AduanPenyelenggaraan;
use App\Models\AduanPenyelenggaraanDetail;
use App\Models\Bilik;
use App\Models\Blok;
use App\Models\Pelajar;
use App\Models\Staff;
use App\Models\Tingkat;
use App\Models\Vendor;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Mail;

class AduanPenyelenggaraanController extends Controller
{
    protected $baseView = 'pages.pengurusan.pembangunan.aduan_penyelenggaraan.';
    protected $baseRoute = 'pengurusan.pembangunan.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {

            $data = AduanPenyelenggaraan::query();

            if(!empty($request->carian))
            {
                $data->where('aduan_penyelenggaraan.no_siri', $request->carian);                
            }

            if(!empty($request->status))
            {
                $data->where('aduan_penyelenggaraan.status', $request->status);                
            }

            return DataTables::of($data)
                ->addColumn('no_siri', function ($data) {
                    return $data->no_siri;
                })
                ->addColumn('pengadu', function ($data) {
                })
                ->addColumn('lokasi', function ($data) {
                    $html = '';

                    if (! empty($data->type)) {
                        $html .= $data->lokasi_name.' / ';
                    }

                    if (! empty($data->blok)) {
                        $html .= $data->blok->nama.' / ';
                    }

                    if (! empty($data->tingkat)) {
                        $html .= $data->tingkat->nama.' / ';
                    }

                    if (! empty($data->bilik)) {
                        $html .= $data->bilik->nama_bilik;
                    }

                    return $html;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->kategori_name;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_name;
                })
                ->addColumn('action', function ($data) {
                    $html = '<button type="button" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 btn-show-aduan" data-url="'.route($this->baseRoute.'show', $data->id).'"><i class="fa fa-eye"></i></button>'.' ';
                    $html .= '<a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Proses"><i class="fa fa-pencil-alt"></i></a>';

                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        $dataTable = $builder
            ->parameters([])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'width' => '7%'],
                ['data' => 'no_siri', 'name' => 'no_siri', 'title' => 'No Siri Aduan', 'orderable' => false, 'width' => '10%'],
                ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable' => false, 'width' => '25%'],
                ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable' => false],
                ['data' => 'jenis_kerosakan', 'name' => 'jenis_kerosakan', 'title' => 'Jenis Kerosakan', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Aduan', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

            ])
            ->minifiedAjax('', null, [
                'carian' => '$("#maklumat_carian").val()',
                'status' => '$("#status").val()',
            ]);

        $data['dataTable'] = $dataTable;

        $data['title'] = 'Aduan Penyelenggaraan';
        $data['breadcrumbs'] = [
            'Pembangunan' => false,
            'Aduan Penyelenggaraan' => false,
        ];

        return view($this->baseView.'list')->with($data);
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
        $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
        $data['aduan_penyelenggaraan'] = $aduan_penyelenggaraan;

        return view($this->baseView.'show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Aduan Penyelenggaraan';
        $data['page_title'] = 'Proses Aduan Penyelenggaraan';
        $data['breadcrumbs'] = [
            'Pembangunan' => false,
            'Aduan Penyelenggaraan' => false,
        ];
        $data['action'] = route($this->baseRoute.'update', $id);
        $data['model'] = AduanPenyelenggaraan::find($id);

        $data += [
            'kategori_aduan' => AduanPenyelenggaraan::getKategoriSelection(),
            'lokasi' => AduanPenyelenggaraan::getLokasiSelection(),
            'blok' => Blok::pluck('nama', 'id')->toArray(),
            'tingkat' => Tingkat::pluck('nama', 'id')->toArray(),
            'bilik' => Bilik::pluck('nama_bilik', 'id')->toArray(),
            'status' => AduanPenyelenggaraan::getStatusSelection(),
            'vendor' => Vendor::where('status', 1)->pluck('nama_syarikat', 'id')->toArray(),
        ];

        $data['aduan_penyelenggaraan_details'] = AduanPenyelenggaraanDetail::where('aduan_penyelenggaraan_id', $id)
            ->where('is_submit', 1)
            ->get();

        return view($this->baseView.'form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //APPROVE KERJA VENDOR
        if (! empty($request->is_approve)) {
            $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
            $aduan_penyelenggaraan->status = 4;
            $aduan_penyelenggaraan->status_vendor = 3;
            $aduan_penyelenggaraan->save();

            $vendor = $aduan_penyelenggaraan->vendor;
            if(!empty($vendor) && !empty($vendor->emel_pengurus))
            {
                Mail::to($vendor->emel_pengurus)->send(new AduanPenyelenggaraanProsesVendorMail($aduan_penyelenggaraan, true));
            }

            Alert::toast('Maklumat aduan berjaya dikemaskini', 'success');
            return redirect(route($this->baseRoute.'index'));
        } 
        //REJECT KERJA VENDOR
        elseif (! empty($request->is_reject)) {
            $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
            $aduan_penyelenggaraan->status = 2;
            $aduan_penyelenggaraan->status_vendor = 1;
            $aduan_penyelenggaraan->save();

            $aduan_penyelenggaraan_detail = AduanPenyelenggaraanDetail::where('aduan_penyelenggaraan_id', $id)->orderBy('created_at', 'desc')->first();

            if (! empty($aduan_penyelenggaraan_detail)) {
                $aduan_penyelenggaraan_detail->reject_reason = $request->reject_reason;
                $aduan_penyelenggaraan_detail->save();
            }

            $vendor = $aduan_penyelenggaraan->vendor;
            if(!empty($vendor) && !empty($vendor->emel_pengurus))
            {
                Mail::to($vendor->emel_pengurus)->send(new AduanPenyelenggaraanProsesVendorMail($aduan_penyelenggaraan, true));
            }

            Alert::toast('Maklumat aduan berjaya dikemaskini', 'success');
            return redirect(route($this->baseRoute.'index'));
        }

        $validation = $request->validate([
            'kategori' => 'required',
            'type' => 'required',
            'blok_id' => 'required',
            'tingkat_id' => 'required',
            'bilik_id' => 'required',
            'jenis_kerosakan' => 'required',
            'butiran' => 'required',
            'vendor_id' => 'required',
        ], [
            'kategori.required' => 'Sila pilih kategori aduan',
            'type.required' => 'Sila pilih lokasi',
            'blok_id.required' => 'Sila pilih bangunan',
            'tingkat_id.required' => 'Sila pilih tingkat',
            'bilik_id.required' => 'Sila pilih bilik',
            'jenis_kerosakan.required' => 'Sila tulis jenis kerosakan',
            'butiran.required' => 'Sila tulis butiran aduan anda',
            'vendor_id.required' => 'Sila pilih vendor',
        ]);

        $result = true;

        try {
            DB::transaction(function () use ($request, $id) {

                $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
                $aduan_penyelenggaraan->kategori = $request->kategori;
                $aduan_penyelenggaraan->type = $request->type;
                $aduan_penyelenggaraan->blok_id = $request->blok_id;
                $aduan_penyelenggaraan->tingkat_id = $request->tingkat_id;
                $aduan_penyelenggaraan->bilik_id = $request->bilik_id;
                $aduan_penyelenggaraan->jenis_kerosakan = $request->jenis_kerosakan;
                $aduan_penyelenggaraan->butiran = $request->butiran;
                $aduan_penyelenggaraan->butiran_vendor = $request->butiran_vendor;
                $aduan_penyelenggaraan->vendor_id = $request->vendor_id;
                if (!empty($request->is_submit)) {
                    $aduan_penyelenggaraan->status = 2;
                    $aduan_penyelenggaraan->status_vendor = 1;
                }
                $aduan_penyelenggaraan->save();

                if (!empty($request->is_submit)) {
                    $user = $aduan_penyelenggaraan->user;
                    if($user->is_student == 1)
                    {
                        $pelajar = Pelajar::where('user_id', $user->id)->first();
                        if(!empty($pelajar) && !empty($pelajar->email))
                        {
                            Mail::to($pelajar->email)->send(new AduanPenyelenggaraanProsesMail($aduan_penyelenggaraan, false));
                        }
                    }
                    elseif($user->is_staff == 2)
                    {
                        $staff = Staff::where('user_id', $user->id)->first();
                        if(!empty($staff) && !empty($staff->email))
                        {
                            Mail::to($staff->email)->send(new AduanPenyelenggaraanProsesMail($aduan_penyelenggaraan, false));
                        }
                    }

                    $vendor = $aduan_penyelenggaraan->vendor;
                    if(!empty($vendor) && !empty($vendor->emel_pengurus))
                    {
                        Mail::to($vendor->emel_pengurus)->send(new AduanPenyelenggaraanProsesMail($aduan_penyelenggaraan, true));
                    }
                }

            });

        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            Alert::toast('Maklumat aduan berjaya dikemaskini', 'success');

            return redirect(route($this->baseRoute.'index'));
        } else {
            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

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
}
