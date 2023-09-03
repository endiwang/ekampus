<?php

namespace App\Http\Controllers\Pemohon\Sijil_Tahfiz;

use App\Http\Controllers\Controller;
use App\Mail\PermohonanBaruSijilTahfiz;
use App\Models\Negeri;
use App\Models\Pelajar;
use App\Models\PermohonanSijilTahfiz;
use App\Models\PermohonanSijilTahfizFile;
use App\Models\PusatPeperiksaan;
use App\Models\PusatPeperiksaanNegeri;
use App\Models\Staff;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use App\Models\VenuePeperiksaanSijilTahfiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanSijilTahfizController extends Controller
{
    public function index(Builder $builder)
    {

        $user = Auth::guard('pemohon')->user();

        $now = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d');

        //check tetapan peperiksaan sijil tahfiz
        $availableSiri = TetapanPeperiksaanSijilTahfiz::where('tarikh_permohonan_dibuka', '>=', $now)
            ->whereDate('tarikh_permohonan_ditutup', '<=', $now)
            ->first();

        // $buttons = [
        //     [
        //         'title' => "Permohonan Baru",
        //         'route' => route('pelajar.permohonan.sijil_tahfiz.create'),
        //         'button_class' => "btn btn-sm btn-primary fw-bold",
        //         'icon_class' => "fa fa-plus-circle"
        //     ],
        // ];

        // $sql_with_bindings = Str::replaceArray('?', $availableSiri->getBindings(), $availableSiri->toSql());
        // dd($sql_with_bindings);
        // if(!empty($availableSiri)){

        // } else {
        //     $buttons = [];
        // }

        if (request()->ajax()) {
            $data = PermohonanSijilTahfiz::where('pemohon_id', $user->id)->get();

            return DataTables::of($data)
                ->addColumn('permohonan', function ($data) {
                    return 'Permohonan';

                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    return Carbon::parse($data->created_at)->format('d/m/Y');

                })
                ->addColumn('status', function ($data) {
                    if ($data->status_hadir_peperiksaan) {
                        return '<span class="badge py-3 px-4 fs-7 badge-light-info">Sudah Ditemuduga</span>';
                    } else {
                        if ($data->status_tawaran) {
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Terima Tawaran</span>';
                        } else {
                            switch ($data->status) {
                                case 1:
                                    return '<span class="badge py-3 px-4 fs-7 badge-light-success">Layak</span>';
                                    break;
                                case 2:
                                    return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                                    break;
                                case 0:
                                    return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Layak</span>';
                                default:
                                    return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                            }
                        }
                    }
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a href="'.route('pemohon.permohonan_sijil_tahfiz.show', $data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                    if ($data->status == 2) {
                        $btn .= ' <a href="'.route('pemohon.permohonan_sijil_tahfiz.edit', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';

                        $btn .= ' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pemohon.permohonan_sijil_tahfiz.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                    } elseif ($data->status == 1) {
                        if (! $data->status_tawaran) {
                            $btn .= ' <a href="'.route('pemohon.permohonan_sijil_tahfiz.setujuTerima.tawaran', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Setuju terima tawaran"><i class="fa fa-check-double"></i></a>';
                        } else {
                            $btn .= ' <a href="'.route('pemohon.permohonan_sijil_tahfiz.setujuTerima.tawaran.download.slip', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Muat Turun Slip"><i class="fa fa-download"></i></a>';
                        }
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    // $data->orderBy('id', 'desc');
                })
                ->rawColumns(['tempoh_permohonan', 'status', 'action'])
                ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $html = $builder
            ->parameters([
                // 'language' => '{ "lengthMenu": "Show _MENU_", }',
                // 'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'permohonan', 'name' => 'permohonan', 'title' => 'Permohonan', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => true],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pemohon.sijil_tahfiz.main', compact('html'));
    }

    public function create()
    {
        $user = Auth::guard('pemohon')->user();

        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeri = Negeri::pluck('nama', 'id');

        $data = [
            'user' => $user,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeri' => $negeri,
            'maklumat_pemohon' => '',
        ];

        return view('pages.pemohon.sijil_tahfiz.add_new', $data);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'postcode' => 'required|numeric',
            'negeri_id' => 'required',
            'phone_no' => 'required|numeric',
            'gender' => 'required',
            'masalah_penglihatan' => 'required',
            'siri_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
            'nama_tahfiz' => 'required|max:255',
            'alamat_tahfiz' => 'required',
            'poskod_tahfiz' => 'required|numeric',
            'negeri_tahfiz' => 'required',
            'jenis_pengajian' => 'required',
            'tahun_mula' => 'required|numeric',
            'tahun_tamat' => 'required|numeric',
            'tahap_pencapaian_hafazan' => 'required',
            'mykad' => 'required',
            'dokumen_sokongan' => 'required',
            // 'resit_bayaran' => 'required',
        ], [
            'name.required' => 'Ruangan ini perlu diisi.',
            'dob.required' => 'Ruangan ini perlu diisi.',
            'address.required' => 'Ruangan ini perlu diisi.',
            'postcode.required' => 'Ruangan ini perlu diisi.',
            'negeri_id.required' => 'Ruangan ini perlu diisi.',
            'phone_no.required' => 'Ruangan ini perlu diisi.',
            'gender.required' => 'Ruangan ini perlu diisi.',
            'masalah_penglihatan.required' => 'Ruangan ini perlu diisi.',
            'siri_id.required' => 'Sila pilih siri peperiksaan sijil tahfiz yang ingin dipohon.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'alamat_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.Numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:53999).',
            'negeri.required' => 'Sila pilih negeri',
            'tahun_mula.required' => 'Ruangan ini perlu diisi.',
            'tahun_mula.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahun_tamat.required' => 'Ruangan ini perlu diisi.',
            'tahun_tamat.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahap_pencapaian_hafazan.required' => 'Ruangan ini perlu diisi.',
            'mykad.required' => 'Sila lampirkan salinan MyKad anda.',
            'dokumen_sokongan.required' => 'Sila lampirkan dokumen sokongan yang telah disahkan.',
            // 'resit_bayaran.required'    => 'Sila lampirkan resit/bukti pembayaran.',
        ]);

        $pemohon = Auth::guard('pemohon')->user();
        $request['created_by'] = Auth::id();
        $request['pemohon_id'] = $pemohon->id;
        $request['dob'] = Carbon::parse($request->dob);
        $request['age'] = Carbon::parse($request->dob)->age;
        $request['status'] = 2;

        if ($request['age'] < 17) {
            Alert::toast('Umur minimum untuk memohon 17 tahun', 'error');

            return redirect()->back();
        }

        $temp_pusat_total = PermohonanSijilTahfiz::where('siri_id', $request->siri_id)->where('pusat_peperiksaan_id', $request->pusat_peperiksaan_id)->count();

        $ppeperiksaan = PusatPeperiksaan::where('id', $request->pusat_peperiksaan_id)->first();

        if ($temp_pusat_total >= $ppeperiksaan->had_jumlah_calon) {
            Alert::toast('Pusat Peperiksaan Penuh', 'error');

            return redirect()->back();
        }

        DB::beginTransaction();

        try {

            $permohonan = PermohonanSijilTahfiz::create($request->except('_token', 'mykad', 'dokumen_sokongan', 'resit_bayaran', 'pusat_peperiksaan_negeri', 'pusat_peperiksaan'));

            $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pemohon->id.'/document';
            if ($request->mykad) {
                $file_name = uniqid().'.'.$request->mykad->getClientOriginalExtension();
                $file = $request->file('mykad');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->mykad->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'mykad',
                ]);
            }

            if ($request->dokumen_sokongan) {
                $file_name = uniqid().'.'.$request->dokumen_sokongan->getClientOriginalExtension();
                $file = $request->file('dokumen_sokongan');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->dokumen_sokongan->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'dokumen',
                ]);
            }

            //get jabatan sepanjang hayat staff email
            $jsh = Staff::join('jabatan as j', 'j.id', '=', 'staff.jabatan_id')
                ->where('j.nama', 'Jabatan Pengajian Sepanjang Hayat')
                ->whereNull('staff.deleted_at')
                ->get();

            foreach ($jsh as $staff) {
                if (! empty($staff->email)) {
                    Mail::to($staff->email)->send(new PermohonanBaruSijilTahfiz($permohonan));
                }
            }

            DB::commit();
            Alert::toast('Maklumat Permohonan Berjaya Dihantar!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Alert::toast('Maklumat Permohonan Tidak Berjaya Dihantar!', 'error');
        }

        return redirect()->route('pemohon.permohonan_sijil_tahfiz.index');
    }

    public function show($id)
    {
        $pemohon = Auth::guard('pemohon')->user();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeri = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id', $id)->latest()->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'pemohon' => $pemohon,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeri' => $negeri,
            'permohonan' => $permohonan,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pemohon.sijil_tahfiz.view', $data);
    }

    public function edit($id)
    {

        $pemohon = Auth::guard('pemohon')->user();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeri = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id', $id)->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'pemohon' => $pemohon,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeri' => $negeri,
            'permohonan' => $permohonan,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pemohon.sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'postcode' => 'required|numeric',
            'negeri_id' => 'required',
            'phone_no' => 'required|numeric',
            'gender' => 'required',
            'masalah_penglihatan' => 'required',
            'siri_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
            'nama_tahfiz' => 'required|max:255',
            'alamat_tahfiz' => 'required',
            'poskod_tahfiz' => 'required|numeric',
            'negeri_tahfiz' => 'required',
            'jenis_pengajian' => 'required',
            'tahun_mula' => 'required|numeric',
            'tahun_tamat' => 'required|numeric',
            'tahap_pencapaian_hafazan' => 'required',
            'mykad' => 'required',
            'dokumen_sokongan' => 'required',
            // 'resit_bayaran' => 'required',
        ], [
            'name.required' => 'Ruangan ini perlu diisi.',
            'dob.required' => 'Ruangan ini perlu diisi.',
            'address.required' => 'Ruangan ini perlu diisi.',
            'postcode.required' => 'Ruangan ini perlu diisi.',
            'negeri_id.required' => 'Ruangan ini perlu diisi.',
            'phone_no.required' => 'Ruangan ini perlu diisi.',
            'gender.required' => 'Ruangan ini perlu diisi.',
            'masalah_penglihatan.required' => 'Ruangan ini perlu diisi.',
            'siri_id.required' => 'Sila pilih siri peperiksaan sijil tahfiz yang ingin dipohon.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'alamat_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.Numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:53999).',
            'negeri.required' => 'Sila pilih negeri',
            'tahun_mula.required' => 'Ruangan ini perlu diisi.',
            'tahun_mula.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahun_tamat.required' => 'Ruangan ini perlu diisi.',
            'tahun_tamat.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahap_pencapaian_hafazan.required' => 'Ruangan ini perlu diisi.',
            'mykad.required' => 'Sila lampirkan salinan MyKad anda.',
            'dokumen_sokongan.required' => 'Sila lampirkan dokumen sokongan yang telah disahkan.',
            // 'resit_bayaran.required'    => 'Sila lampirkan resit/bukti pembayaran.',
        ]);

        $temp_pusat_total = PermohonanSijilTahfiz::where('id', '!=', $id)->where('siri_id', $request->siri_id)->where('pusat_peperiksaan_id', $request->pusat_peperiksaan_id)->count();     
        
        $ppeperiksaan = PusatPeperiksaan::where('id', $request->pusat_peperiksaan_id)->first();

        if ($temp_pusat_total >= $ppeperiksaan->had_jumlah_calon) {
            Alert::toast('Pusat Peperiksaan Penuh', 'error');

            return redirect()->back();
        }

        $permohonan = PermohonanSijilTahfiz::where('id', $id)->first();

        DB::beginTransaction();

        try {

            $permohonan->update($request->except('_token', 'mykad', 'dokumen_sokongan', 'resit_bayaran'));
            $file_path = 'uploads/permohonan/sijil_tahfiz/'.$permohonan->pemohon_id.'/document';

            if ($request->mykad) {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id', $id)->where('document_type', 'mykad')->delete();
                $file_name = uniqid().'.'.$request->mykad->getClientOriginalExtension();
                $file = $request->file('mykad');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->mykad->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'mykad',
                ]);
            }

            if ($request->dokumen_sokongan) {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id', $id)->where('document_type', 'dokumen')->delete();
                $file_name = uniqid().'.'.$request->dokumen_sokongan->getClientOriginalExtension();
                $file = $request->file('dokumen_sokongan');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->dokumen_sokongan->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'dokumen',
                ]);
            }

            DB::commit();
            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Maklumat permohonan Tidak berjaya dihantar!', 'error');
        }

        return redirect()->route('pemohon.permohonan_sijil_tahfiz.index');
    }

    public function destroy($id)
    {
        PermohonanSijilTahfiz::where('id', $id)->delete();
        PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id', $id)->delete();

        Alert::toast('Permohonan berjaya dipadamkan', 'success');

        return redirect()->route('pemohon.permohonan_sijil_tahfiz.index');
    }

    public function fetchPusatPeperiksaan(Request $request)
    {
        $tetapan = TetapanPeperiksaanSijilTahfiz::where('id', $request->siri_id)->first();
        $temp_ppeperiksaan = PusatPeperiksaan::whereIn('id', json_decode($tetapan->lokasi_peperiksaan))
            ->get();

        $temp_pusat_total = [];
        foreach ($temp_ppeperiksaan as $pusat) {
            $temp_pusat_total[$pusat->id] = PermohonanSijilTahfiz::where('siri_id', $request->siri_id)->where('pusat_peperiksaan_id', $pusat->id)->count();
        }

        $ppeperiksaan = PusatPeperiksaan::whereIn('id', json_decode($tetapan->lokasi_peperiksaan))
            ->get(['id', 'name as text']);

        foreach ($ppeperiksaan as $pusat) {
            $temp_pusat = $temp_ppeperiksaan->where('id', $pusat->id)->first();
            if ($temp_pusat_total[$pusat->id] < $temp_pusat->had_jumlah_calon) {
                //
            } else {
                $pusat['text'] = $pusat['text'].' (Penuh)';
            }
        }

        return $ppeperiksaan;
    }

    public function fetchPusatPeperiksaanNegeri(Request $request)
    {
        $ppnegeri = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $request->pusat_peperiksaan_id)
            ->get(['pusat_peperiksaan_negeris.id', 'negeri.nama as text']);

        return $ppnegeri;
    }

    public function setujuTerimaTawaran($id)
    {
        $title = 'Setuju Terima Tawaran';
        $breadcrumbs = [
            'Pelajar' => '#',
            'Permohonan' => '#',
            'Sijil Tahfiz' => '#',
            'Setuju Terima Tawaran' => '#',
        ];

        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id', $id)->first();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('id', $permohonan->siri_id)->first();
        $venue = VenuePeperiksaanSijilTahfiz::where('negeri_id', $permohonan->pusatPeperiksaanNegeri->state_id)
            ->where('status', 1)->first();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'permohonan' => $permohonan,
            'siri_peperiksaan' => $siri_peperiksaan,
            'venue' => $venue,
        ];

        return view('pages.pemohon.sijil_tahfiz.setuju_terima', $data);
    }

    public function setujuTerimaTawaranJawapan(Request $request, $id)
    {
        $validated = $request->validate([
            'resit_bayaran' => 'required_if:status_tawaran,1',
        ], [
            'resit_bayaran.required_if' => 'Sila lampirkan resit/bukti pembayaran.',
        ]);

        $permohonan = PermohonanSijilTahfiz::where('id', $id)->first();

        DB::beginTransaction();

        try {

            if ($request->status_tawaran) {
                $permohonan->update($request->except('_token', '_method', 'resit_bayaran'));
            }

            $file_path = 'uploads/permohonan/sijil_tahfiz/'.$permohonan->pemohon_id.'/document';
            if ($request->resit_bayaran) {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id', $id)->where('document_type', 'resit')->delete();
                $file_name = uniqid().'.'.$request->resit_bayaran->getClientOriginalExtension();
                $file = $request->file('resit_bayaran');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->resit_bayaran->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'resit',
                ]);
            }

            DB::commit();
            Alert::toast('Permohonan berjaya dikemaskini!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Permohonan tidak berjaya dikemaskini!', 'error');
        }

        return redirect()->route('pemohon.permohonan_sijil_tahfiz.index');
    }

    public function exportPdf($id)
    {
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id', $id)->first();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('id', $permohonan->siri_id)->first();
        $venue = VenuePeperiksaanSijilTahfiz::where('negeri_id', $permohonan->pusatPeperiksaanNegeri->state_id)
            ->where('status', 1)->first();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pemohon.sijil_tahfiz.export_pdf', compact('permohonan', 'siri_peperiksaan', 'venue'))
            ->setPaper('a4', 'potrait');

        // return $pdf->stream();
        return $pdf->download('slip_temuduga_stm.pdf');
    }
}
