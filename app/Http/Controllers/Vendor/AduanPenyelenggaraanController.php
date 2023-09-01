<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\AduanPenyelenggaraanProsesVendorMail;
use App\Models\AduanPenyelenggaraan;
use App\Models\AduanPenyelenggaraanDetail;
use App\Models\Bilik;
use App\Models\Blok;
use App\Models\Staff;
use App\Models\Tingkat;
use App\Models\Vendor;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class AduanPenyelenggaraanController extends Controller
{
    protected $baseView = 'pages.vendor.aduan_penyelenggaraan.';

    protected $baseRoute = 'vendor.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {

            info($request->all());

            $vendor = Vendor::where('user_id', Auth::id())->first();
            $data = AduanPenyelenggaraan::where('vendor_id', $vendor->id)->orderBy('id', 'desc');

            if (! empty($request->carian)) {
                $data->where('no_siri', $request->carian);
            }
            if (! empty($request->status_vendor)) {
                $data->where('status_vendor', $request->status_vendor);
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
                ->addColumn('status_vendor', function ($data) {
                    return $data->status_vendor_badge;
                })
                ->addColumn('tarikh_aduan', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('action', function ($data) {
                    $html = '<button type="button" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 btn-show-aduan" data-url="'.route($this->baseRoute.'show', $data->id).'"><i class="fa fa-eye"></i></button> ';
                    $html .= '<a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kemaskini Kerja"><i class="fa fa-pencil-alt"></i></a>';

                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status_vendor'])
                ->toJson();
        }

        $columns = [
            ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'width' => '7%'],
            ['data' => 'no_siri', 'name' => 'no_siri', 'title' => 'No Siri Aduan', 'orderable' => false, 'width' => '10%'],
            ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable' => false, 'width' => '25%'],
            ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable' => false],
            ['data' => 'jenis_kerosakan', 'name' => 'jenis_kerosakan', 'title' => 'Jenis Kerosakan', 'orderable' => false],
            ['data' => 'status_vendor', 'name' => 'status_vendor', 'title' => 'Status Kerja', 'orderable' => false, 'searchable' => false],
            ['data' => 'tarikh_aduan', 'name' => 'tarikh_aduan', 'title' => 'Tarikh Aduan', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],
        ];

        $dataTable = $builder
            ->parameters([])
            ->columns($columns)
            ->minifiedAjax('', null, [
                'carian' => '$("#maklumat_carian").val()',
                'status_vendor' => '$("#status_vendor").val()',
            ]);

        $data['dataTable'] = $dataTable;

        $data['title'] = 'Aduan Penyelenggaraan';
        $data['breadcrumbs'] = [
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

        $is_vendor = false;
        if (Auth::user()->is_vendor) {
            $is_vendor = true;
        }
        $data['is_vendor'] = $is_vendor;

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
        $user = Auth::user();
        if (! empty($user->is_vendor)) {
            $vendor = Vendor::where('user_id', $user->id)->first();
            $aduan_penyelenggaraan = AduanPenyelenggaraan::where('id', $id)->where('vendor_id', $vendor->id)->first();

            if (empty($aduan_penyelenggaraan)) {
                abort(404);
            }

            $data['title'] = 'Aduan Penyelenggaraan';
            $data['page_title'] = 'Kemaskini Kerja';
            $data['breadcrumbs'] = [
                'Aduan Penyelenggaraan' => false,
            ];
            $data['action'] = route($this->baseRoute.'update', $id);
            $data += [
                'kategori_aduan' => AduanPenyelenggaraan::getKategoriSelection(),
                'lokasi' => AduanPenyelenggaraan::getLokasiSelection(),
                'blok' => Blok::pluck('nama', 'id')->toArray(),
                'tingkat' => Tingkat::pluck('nama', 'id')->toArray(),
                'bilik' => Bilik::pluck('nama_bilik', 'id')->toArray(),
                'status' => AduanPenyelenggaraan::getStatusSelection(),
                'vendor' => Vendor::where('status', 1)->pluck('nama_syarikat', 'id')->toArray(),
            ];

            $aduan_penyelenggaraan_detail = AduanPenyelenggaraanDetail::where('aduan_penyelenggaraan_id', $id)
                ->where(function ($where) {
                    $where->whereNull('is_submit');
                    $where->orWhere('is_submit', '0');
                })
                ->first();

            $data['model'] = (! empty($aduan_penyelenggaraan_detail)) ? $aduan_penyelenggaraan_detail : new AduanPenyelenggaraanDetail;

            $data['aduan_penyelenggaraan'] = $aduan_penyelenggaraan;
            $data['aduan_penyelenggaraan_details'] = AduanPenyelenggaraanDetail::where('aduan_penyelenggaraan_id', $id)
                ->where('vendor_id', $vendor->id)
                ->where('is_submit', 1)
                ->get();

            return view($this->baseView.'form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (! empty($user->is_vendor)) {
            $vendor = Vendor::where('user_id', $user->id)->first();
            $validation = $request->validate([
                'tarikh_kerja' => 'required',
                'butiran' => 'required',
            ], [
                'tarikh_kerja.required' => 'Sila pilih tarikh kerja',
                'butiran.required' => 'Sila tulis butiran kerja',
            ]);

            $result = true;
            try {
                DB::transaction(function () use ($request, $id, $vendor) {
                    $aduan_penyelenggaraan_detail = AduanPenyelenggaraanDetail::where('aduan_penyelenggaraan_id', $id)
                        ->where(function ($where) {
                            $where->whereNull('is_submit');
                            $where->orWhere('is_submit', '0');
                        })
                        ->first();

                    if (empty($aduan_penyelenggaraan_detail)) {
                        $aduan_penyelenggaraan_detail = new AduanPenyelenggaraanDetail;
                        $aduan_penyelenggaraan_detail->aduan_penyelenggaraan_id = $id;
                    }

                    $aduan_penyelenggaraan_detail->vendor_id = $vendor->id;
                    $aduan_penyelenggaraan_detail->tarikh_kerja = $request->tarikh_kerja;
                    $aduan_penyelenggaraan_detail->butiran = $request->butiran;
                    if (! empty($request->is_submit)) {
                        $aduan_penyelenggaraan_detail->is_submit = 1;
                    }
                    if ($aduan_penyelenggaraan_detail->save()) {

                        $datetime_now = strtotime(now());

                        if (! empty($request->gambar)) {
                            $images = [];
                            $image_counter = 1;
                            foreach ($request->gambar as $key => $file) {
                                $original_name = $file->getClientOriginalName();
                                $file_name = pathinfo($original_name, PATHINFO_FILENAME);
                                $extension = pathinfo($original_name, PATHINFO_EXTENSION);
                                $file_name = $aduan_penyelenggaraan_detail->id.'_'.$file_name.'_'.$datetime_now.'.'.$extension;
                                $file_path = 'aduan_penyelenggaaraan/vendor/'.$file_name;
                                Storage::disk('local')->put('public/'.$file_path, fopen($file, 'r+'), 'public');
                                $images[$image_counter] = $file_path;
                                $image_counter++;
                            }
                            $aduan_penyelenggaraan_detail->gambar = json_encode($images);
                            $aduan_penyelenggaraan_detail->save();
                        }

                        $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
                        if ($aduan_penyelenggaraan_detail->is_submit == 1) {
                            $aduan_penyelenggaraan->status = 3;
                            $aduan_penyelenggaraan->status_vendor = 3;
                        } else {
                            $aduan_penyelenggaraan->status_vendor = 2;
                        }
                        $aduan_penyelenggaraan->save();

                        if ($aduan_penyelenggaraan_detail->is_submit == 1) {
                            $staff_pembangunan = Staff::whereNotNull('email')->where('jabatan_id', 21)->get();
                            foreach ($staff_pembangunan as $staff) {
                                Mail::to($staff->email)->send(new AduanPenyelenggaraanProsesVendorMail($aduan_penyelenggaraan));
                            }
                        }
                    }

                });

            } catch (\Exception $e) {
                $result = false;
            }

            if ($result) {
                if (! empty($request->is_submit)) {
                    Alert::toast('Kemaskini kerja berjaya dihantar', 'success');
                } else {
                    Alert::toast('Kemaskini kerja berjaya disimpan', 'success');
                }

                return redirect(route($this->baseRoute.'index'));
            } else {
                Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

                return redirect()->back();
            }
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
        abort(404);
    }
}
