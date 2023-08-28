<?php

namespace App\Http\Controllers\Main_Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\AduanPenyelenggaraanMail;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Mail;

class AduanPenyelenggaraanController extends Controller
{
    protected $baseView = 'pages.main_dashboard.aduan_penyelenggaraan.';

    protected $baseRoute = 'aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {

            $data = AduanPenyelenggaraan::where('user_id', Auth::id())->orderBy('id', 'desc');          

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
                    return $data->status_badge;
                })
                ->addColumn('tarikh_aduan', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('action', function ($data) {
                    $html = '<button type="button" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 btn-show-aduan" data-url="'.route($this->baseRoute.'show', $data->id).'"><i class="fa fa-eye"></i></button> ';

                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        $columns = [
            ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'width' => '7%'],
            ['data' => 'no_siri', 'name' => 'no_siri', 'title' => 'No Siri Aduan', 'orderable' => false, 'width' => '10%'],
            ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable' => false, 'width' => '25%'],
            ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable' => false],
            ['data' => 'jenis_kerosakan', 'name' => 'jenis_kerosakan', 'title' => 'Jenis Kerosakan', 'orderable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status Aduan', 'orderable' => false, 'searchable' => false],
            ['data' => 'tarikh_aduan', 'name' => 'tarikh_aduan', 'title' => 'Tarikh Aduan', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],
        ];        

        $dataTable = $builder
            ->parameters([])
            ->columns($columns)
            ->minifiedAjax();

        $data['dataTable'] = $dataTable;

        $data['title'] = 'Aduan Penyelenggaraan';
        $data['breadcrumbs'] = [
            'Aduan Penyelenggaraan' => false,
        ];
        $data['buttons'] = [
            [
                'title' => 'Tambah Aduan',
                'route' => route($this->baseRoute.'create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
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
        $data['title'] = 'Aduan Penyelenggaraan';
        $data['page_title'] = 'Tambah Aduan Penyelenggaraan';
        $data['breadcrumbs'] = [
            'Aduan Penyelenggaraan' => false,
        ];
        $data['action'] = route($this->baseRoute.'store');
        $data['model'] = new AduanPenyelenggaraan;

        $data += [
            'kategori_aduan' => AduanPenyelenggaraan::getKategoriSelection(),
            'lokasi' => AduanPenyelenggaraan::getLokasiSelection(),
            'blok' => Blok::pluck('nama', 'id')->toArray(),
            'tingkat' => Tingkat::pluck('nama', 'id')->toArray(),
            'bilik' => Bilik::pluck('nama_bilik', 'id')->toArray(),
            'status' => AduanPenyelenggaraan::getStatusSelection(),
        ];

        return view($this->baseView.'form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'kategori' => 'required',
            'type' => 'required',
            'blok_id' => 'required',
            'tingkat_id' => 'required',
            'bilik_id' => 'required',
            'jenis_kerosakan' => 'required',
            'butiran' => 'required',
        ], [
            'kategori.required' => 'Sila pilih kategori aduan',
            'type.required' => 'Sila pilih lokasi',
            'blok_id.required' => 'Sila pilih bangunan',
            'tingkat_id.required' => 'Sila pilih tingkat',
            'bilik_id.required' => 'Sila pilih bilik',
            'jenis_kerosakan.required' => 'Sila tulis jenis kerosakan',
            'butiran.required' => 'Sila tulis butiran aduan anda',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $count_aduan = AduanPenyelenggaraan::count();
                $request['no_siri'] = sprintf('%04d', $count_aduan + 1);
                $request['user_id'] = Auth::id();
                $request['status'] = 1;

                $aduan = AduanPenyelenggaraan::create($request->except('gambar'));

                if (! empty($aduan)) {

                    $datetime_now = strtotime(now());

                    if (! empty($request->gambar)) {
                        $images = [];
                        $image_counter = 1;
                        foreach ($request->gambar as $key => $file) {
                            $original_name = $file->getClientOriginalName();                            
                            $file_name = pathinfo($original_name, PATHINFO_FILENAME);
                            $extension = pathinfo($original_name, PATHINFO_EXTENSION);
                            $file_name = $aduan->id . '_' . $file_name . '_' . $datetime_now . '.' . $extension;
                            $file_path = 'aduan_penyelenggaaraan/' . $file_name;
                            Storage::disk('local')->put('public/' . $file_path, fopen($file, 'r+'), 'public');
                            $images[$image_counter] = $file_path;
                            $image_counter++;
                        }
                        $aduan->gambar = json_encode($images);
                        $aduan->save();

                        $user = $aduan->user;
                        if($user->is_student == 1)
                        {
                            $pelajar = Pelajar::where('user_id', $user->id)->first();
                            if(!empty($pelajar) && !empty($pelajar->email))
                            {
                                Mail::to($pelajar->email)->send(new AduanPenyelenggaraanMail($aduan, false));
                            }
                        }
                        elseif($user->is_staff == 2)
                        {
                            $staff = Staff::where('user_id', $user->id)->first();
                            if(!empty($staff) && !empty($staff->email))
                            {
                                Mail::to($staff->email)->send(new AduanPenyelenggaraanMail($aduan, false));
                            }
                        }

                        $staff_pembangunan = Staff::whereNotNull('email')->where('jabatan_id', 21)->get();
                        foreach($staff_pembangunan as $staff)
                        {
                            Mail::to($staff->email)->send(new AduanPenyelenggaraanMail($aduan, true));
                        }        
                    }
                }
            });

        } catch (\Exception $e) {
            $result = false;
        }

        Alert::toast('Aduan berjaya dihantar!', 'success');

        return redirect()->route($this->baseRoute.'index');
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
        abort(404);
    }

    public function getBlok(Request $request)
    {
        $blok = [];
        if (! empty($request->type)) {
            $blok = Blok::where('type', $request->type)->pluck('nama', 'id')->toArray();
        }
        $data['blok'] = $blok;

        return $data;
    }

    public function getBilik(Request $request)
    {
        $bilik = [];
        if (! empty($request->blok_id) && ! empty($request->tingkat_id)) {
            $bilik = Bilik::where('blok_id', $request->blok_id)->where('tingkat_id', $request->tingkat_id)->pluck('nama_bilik', 'id')->toArray();
        }
        $data['bilik'] = $bilik;

        return $data;
    }
}
