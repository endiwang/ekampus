<?php

namespace App\Http\Controllers\Pengurusan\Pentadbiran;

use App\Http\Controllers\Controller;
use App\Models\Kualiti\JaminanKualiti;
use App\Models\Pentadbiran\Fasiliti;
use App\Models\Pentadbiran\PermohonanFasiliti;
use App\Models\Pentadbiran\PermohonanKenderaan;
use App\Models\Pentadbiran\PermohonanKuarters;
use App\Models\Pentadbiran\PermohonanPelekatKenderaan;
use App\Models\Pentadbiran\PermohonanPenginapan;
use App\Models\Pentadbiran\PermohonanPeralatan;
use App\Models\Pentadbiran\RunningNo;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PentadbiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fasilitiIndex(Builder $builder)
    {
        $title = 'Fasiliti';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Fasiliti' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Fasiliti',
                'route' => route('pengurusan.pentadbiran.fasiliti.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            // $data = JaminanKualiti::query();
            $data = Fasiliti::get();

            return DataTables::of($data)
                ->addColumn('jenis', function ($data) {
                    if ($data->jenis == 1) {
                        return 'Fasiliti';
                    } else {
                        return 'Peralatan';
                    }
                })
            // ->addColumn('tarikh', function($data) {
            //     return date('d-m-Y',$data->tarikh);
            // })
                ->addColumn('action', function ($data) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2">View</a>';
                    // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                    // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';

                    $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/edit/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Pinda</a>';

                    return $btn;
                })
                ->addIndexColumn()
            // ->order(function ($data) {
            //     $data->orderBy('created_at');
            // })
                ->rawColumns(['tarikh', 'jenis', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->parameters([
                // 'language' => '{ "lengthMenu": "Show _MENU_", }',
                // 'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'kuantiti', 'name' => 'kuantiti', 'title' => 'Kuantiti', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'pengguna', 'name' => 'pengguna', 'title' => 'Pengguna', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh', 'name' => 'Tarikh', 'title' => 'Tarikh', 'orderable' => false],
                ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.fasiliti.list', compact('dataTable', 'buttons'));

    }

    public function fasilitiCreate()
    {
        $title = 'Fasiliti';
        $action = route('pengurusan.pentadbiran.fasiliti.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Tambah Fasiliti' => false,
        ];
        $page_title = 'Fasiliti';
        // $jenisDoc = [
        //     1 => 'Dokumen Baru',
        //     2 => 'Dokumen Tambahan',
        //     3 => 'Dokumen Ganti (Versi Baru)',
        //     4 => 'Dokumen Hapus (delete)'
        // ];
        $status = [
            1 => 'Digunakan',
            2 => 'Tidak Digunakan',
        ];
        $jenis = [
            1 => 'Fasiliti',
            2 => 'Peralatan',
        ];

        $model = new Fasiliti();

        return view('pages.pengurusan.pentadbiran.fasiliti.add_new', compact(['status', 'page_title', 'breadcrumbs', 'title', 'model', 'action', 'jenis']));
    }

    public function fasilitiStore(Request $request)
    {

        // dd($request);
        $validation = $request->validate([
            'kategori' => 'required',
            'pengguna' => 'required',

        ], [
            'kategori.required' => 'Sila masukkan maklumat kategori',
            'pengguna.required' => 'Sila masukkan maklumat pengguna ',
        ]);

        $user = auth()->user();

        try {

            Fasiliti::create([
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'kuantiti' => $request->kuantiti,
                'status_penggunaan' => $request->status_penggunaan,
                'pengguna' => $request->pengguna,
                'tarikh' => $request->tarikh,
                'masa' => $request->masa,
                'status' => 1,
            ]);

            Alert::toast('Maklumat fasiliti/peralatan berjaya ditambah!', 'success');

            return redirect::to('/pengurusan/pentadbiran/fasiliti/index');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function fasilitiEdit(Request $request)
    {
        $title = 'Fasiliti';
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kemaskini Fasiliti' => false,
        ];
        $page_title = 'Kemaskini Fasiliti';

        $status = [
            1 => 'Digunakan',
            2 => 'Tidak Digunakan',
        ];
        $jenis = [
            1 => 'Fasiliti',
            2 => 'Peralatan',
        ];

        $model = Fasiliti::find($request->id);

        return view('pages.pengurusan.pentadbiran.fasiliti.add_new', compact(['status', 'page_title', 'breadcrumbs', 'title', 'model', 'action', 'jenis']));
    }

    public function fasilitiUpdate(Request $request)
    {
        $validation = $request->validate([
            'kategori' => 'required',
            'pengguna' => 'required',

        ], [
            'kategori.required' => 'Sila masukkan maklumat kategori',
            'pengguna.required' => 'Sila masukkan maklumat pengguna ',
        ]);

        $user = auth()->user();

        $model = Fasiliti::find($request->id);

        try {

            $model = $model->update([
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'kuantiti' => $request->kuantiti,
                'status_penggunaan' => $request->status_penggunaan,
                'pengguna' => $request->pengguna,
                'tarikh' => $request->tarikh,
                'masa' => $request->masa,
            ]);

            Alert::toast('Maklumat fasiliti/peralatan berjaya dikemaskini!', 'success');

            return redirect::to('/pengurusan/pentadbiran/fasiliti/index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    // Permohonan Fasiliti oleh pelajar dan kakitangan

    public function permohonanFasilitiIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();
        // $roles = Role::all()->pluck('name');

        // dd($user->is_student);

        $title = 'Permohonan Fasiliti';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Permohonan Fasiliti' => false,
        ];

        $buttons = [
            [
                'title' => 'Mohon Fasiliti',
                'route' => route('pengurusan.pentadbiran.fasiliti.permohonan.tambah'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {

            if ($user->is_student == 1) {
                $data = PermohonanFasiliti::where('user_id', $user->id)->with('fasiliti')->get();
            } elseif ($user->is_staff == 1) {
                $data = PermohonanFasiliti::with('fasiliti')->get();
            } else {
                $data = PermohonanFasiliti::with('fasiliti')->get();
            }

            return DataTables::of($data)
                ->addColumn('fasiliti_id', function ($data) {
                    if ($data->fasiliti->jenis == 1) {
                        return 'Fasiliti';
                    } else {
                        return 'Peralatan';
                    }
                })
                ->addColumn('status_permohonan', function ($data) {
                    if ($data->status_permohonan == 1) {
                        return 'Baru Diterima';
                    } elseif ($data->status_permohonan == 2) {
                        return 'Proses';
                    } elseif ($data->status_permohonan == 3) {
                        return 'Lulus';
                    } elseif ($data->status_permohonan == 4) {
                        return 'Tolak';
                    } else {
                        return 'Tiada Status';
                    }

                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->is_student == 1) {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    } elseif (Auth::user()->is_staff == 1) {
                        if ($data->status_permohonan != 3) {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                        } else {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        }

                    } else {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['fasiliti_id', 'action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_penggunaan', 'name' => 'tarikh_penggunaan', 'title' => 'Tarikh Penggunaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'fasiliti_id', 'name' => 'fasiliti_id', 'title' => 'Fasiliti', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jumlah_peserta', 'name' => 'jumlah_peserta', 'title' => 'Jumlah Peserta', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status_permohonan', 'name' => 'status_permohonan', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.fasiliti.list', compact('dataTable', 'buttons'));

    }

    public function permohonanFasilitiTambah(Request $request)
    {
        $title = 'Permohonan Fasiliti';
        $action = route('pengurusan.pentadbiran.fasiliti.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Fasiliti' => false,
        ];
        $page_title = 'Permohonan Fasiliti';
        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada',
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa',
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->whereNot('id', [4, 6])->pluck('kategori', 'id');
        $selFasilitiAll = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->pluck('kategori', 'id');
        $selPeralatan = Fasiliti::where('jenis', 2)->where('status_penggunaan', 2)->pluck('kategori', 'id');
        $model = new PermohonanFasiliti();
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.add_new', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'jenisMakan', 'status',
            'selFasilitiPelajar', 'selFasilitiAll',
            'selPeralatan', 'model', 'user',
            'peserta'
        ));
    }

    public function permohonanFasilitiStore(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        try {

            if (! empty($request->file)) {

                $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/fasiliti/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path.''.$file_name;

                $original_filename = $request->file->getClientOriginalName();
            } else {
                $original_filename = null;
                $file = null;
            }

            $runningno = $this->runningMan('fasiliti');
            $appno = 'FASILITI'.str_pad($runningno, 4, '0', STR_PAD_LEFT).date('Y');

            $insert = PermohonanFasiliti::create([
                'no_permohonan' => $appno,
                'user_id' => $user->id,
                'document_name' => $original_filename,
                'upload_document' => $file,
                'fasiliti_id' => $request->kategori,
                'tarikh_penggunaan' => $request->tarikh,
                'makan_minum' => data_get($request, 'makan_minum'),
                'peserta' => $request->peserta,
                'jumlah_peserta' => $request->jumlah_peserta,
                'catatan_tambahan' => $request->catatan_tambahan,
                'status_permohonan' => 1, // baru terima
            ]);

            foreach ($request->peralatan as $alat) {
                PermohonanPeralatan::create([
                    'permohonan_fasiliti_id' => $insert->id,
                    'peralatan_id' => $alat,
                    'status' => 1,

                ]);
            }

            Alert::toast('Maklumat permohonan fasiliti berjaya dihantar!', 'success');

            return redirect()->route('pengurusan.pentadbiran.fasiliti.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    // function running man
    /**
     * undocumented function
     *
     * @return void
     *
     * @author
     **/
    public function runningMan($code)
    {

        $lowercode = strtolower($code);
        $data = RunningNo::find(1);

        $no = $data->$lowercode;

        $dateup = $data->updated_at;

        $now = date('Y');
        $y_db = date('Y', strtotime($dateup));

        if (($no < 999) and ($now == $y_db)) {
            $run_no = $no + 1;

        } else {
            $run_no = 1;
        }

        $data->$code = $run_no;
        $data->save();

        while (strlen($run_no) <= 3) {
            $run_no = '0'.$run_no;
        }

        return $run_no;

    } //

    public function permohonanFasilitiShow(Request $request)
    {
        $title = 'Fasiliti';
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kelulusan PermohonanFasiliti' => false,
        ];
        $page_title = 'Kelulusan Permohonan Fasiliti';

        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada',
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa',
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->whereNot('id', [4, 6])->pluck('kategori', 'id');
        $selFasilitiAll = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->pluck('kategori', 'id');
        $selPeralatan = Fasiliti::where('jenis', 2)->where('status_penggunaan', 2)->pluck('kategori', 'id');
        $model = PermohonanFasiliti::with('fasiliti', 'peralatan.fasiliti', 'user.pelajar', 'user.staff', 'approvedby')->find($request->id);
        // dump($model);
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.action', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'jenisMakan', 'status',
            'selFasilitiPelajar', 'selFasilitiAll',
            'selPeralatan', 'model', 'user',
            'peserta'
        ));

    }

    public function permohonanFasilitiUpdate(Request $request)
    {
        // dd($request);

        $user = auth()->user();

        $model = PermohonanFasiliti::find($request->id);

        try {

            $model = $model->update([
                'status_permohonan' => $request->status,
                'approved_by' => $user->id,
                'approved_date' => date('Y-m-d H:s:i'),
            ]);

            if ($request->status == 3) {
                Alert::toast('Permohonan fasiliti diluluskan!', 'success');
            } elseif ($request->status == 4) {
                Alert::toast('Permohonan fasiliti ditolak!', 'success');
            } else {
                Alert::toast('Permohonan fasiliti dikemaskini!', 'success');
            }

            return redirect()->route('pengurusan.pentadbiran.fasiliti.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function permohonanFasilitiShowOnly(Request $request)
    {
        $title = 'Fasiliti';
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kelulusan PermohonanFasiliti' => false,
        ];
        $page_title = 'Kelulusan Permohonan Fasiliti';

        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada',
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa',
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->whereNot('id', [4, 6])->pluck('kategori', 'id');
        $selFasilitiAll = Fasiliti::where('jenis', 1)->where('status_penggunaan', '2')->pluck('kategori', 'id');
        $selPeralatan = Fasiliti::where('jenis', 2)->where('status_penggunaan', 2)->pluck('kategori', 'id');
        $model = PermohonanFasiliti::with('fasiliti', 'peralatan.fasiliti', 'user.pelajar', 'user.staff', 'approvedby')->find($request->id);
        // dump($model);
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.show', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'jenisMakan', 'status',
            'selFasilitiPelajar', 'selFasilitiAll',
            'selPeralatan', 'model', 'user',
            'peserta'
        ));

    }

    public function permohonanPenginapanIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();

        $title = 'Permohonan Penginapan';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Permohonan Penginapan' => false,
        ];

        $buttons = [
            [
                'title' => 'Mohon Penginapan',
                'route' => route('pengurusan.pentadbiran.penginapan.permohonan.tambah'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {

            if ($user->is_staff == 1) {
                $data = PermohonanPenginapan::with('approvedby')->get();
            } else {
                $data = PermohonanPenginapan::with('approvedby')->where('user_id', $user->id)->get();
            }

            return DataTables::of($data)
                ->addColumn('bilik', function ($data) {
                    if ($data->bilik == 1) {
                        return 'Bilik Rehat 1';
                    } elseif ($data->bilik == 2) {
                        return 'Bilik Rehat 2';
                    } elseif ($data->bilik == 3) {
                        return 'Ruang Tamu 1';
                    } elseif ($data->bilik == 4) {
                        return 'Ruang Tamu 2';
                    } else {
                        return 'Ruang Tamu 3';
                    }

                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Baru Diterima';
                    } elseif ($data->status == 2) {
                        return 'Proses';
                    } elseif ($data->status == 3) {
                        return 'Lulus';
                    } elseif ($data->status == 4) {
                        return 'Tolak';
                    } else {
                        return 'Tiada Status';
                    }

                })
                ->addColumn('tarikh', function ($data) {
                    return date('d-m-Y', $data->tarikh);

                })
                ->addColumn('tarikh_keluar', function ($data) {
                    return date('d-m-Y', $data->tarikh);

                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->is_student == 1) {
                        // $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        $btn = '';
                    } elseif (Auth::user()->is_staff == 1) {

                        if ($data->status != 3) {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                        } else {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        }

                    } else {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['bilik', 'tarikh', 'tarikh_keluar', 'action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Menginap', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable' => false, 'class' => 'text-bold'],
                // ['data' => 'jumlah_peserta', 'name' => 'jumlah_peserta', 'title' => 'Jumlah Peserta', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.list', compact('dataTable', 'buttons'));
    }

    public function permohonanPenginapanTambah(Request $request)
    {
        $title = 'Permohonan Penginapan';
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Penginapan' => false,
        ];
        $page_title = 'Permohonan Penginapan';

        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3',
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = new PermohonanPenginapan();
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.add_new', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectbilik', 'status',
            'model', 'user',

        ));
    }

    public function permohonanPenginapanStore(Request $request)
    {
        // dd($request);

        $user = auth()->user();

        try {

            $startDate = Carbon::createFromFormat('Y-m-d', $request->tarikh);
            $endDate = Carbon::createFromFormat('Y-m-d', $request->tarikh_keluar);

            $interval = $startDate->diff($endDate);
            $days = $interval->days + 1;

            $runningno = $this->runningMan('penginapan');
            $appno = 'PENGINAPAN'.str_pad($runningno, 4, '0', STR_PAD_LEFT).date('Y');

            $insert = PermohonanPenginapan::create([
                'no_permohonan' => $appno,
                'user_id' => $user->id,
                'bilik' => $request->bilik,
                'tarikh_masuk' => $request->tarikh,
                'tempoh_hari' => $days,
                'tarikh_keluar' => data_get($request, 'tarikh_keluar'),
                'tujuan' => $request->tujuan,
                'status' => 1, // baru terima
            ]);

            Alert::toast('Maklumat permohonan penginapan berjaya dihantar!', 'success');

            return redirect()->route('pengurusan.pentadbiran.penginapan.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function permohonanPenginapanShow(Request $request)
    {
        $title = 'Permohonan Penginapan';
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Penginapan' => false,
        ];
        $page_title = 'Permohonan Penginapan';

        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3',
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = PermohonanPenginapan::find($request->id);
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.action', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectbilik', 'status',
            'model', 'user',

        ));
    }

    public function permohonanPenginapanUpdate(Request $request)
    {
        $user = auth()->user();

        try {
            $model = PermohonanPenginapan::find($request->id);

            $model = $model->update([

                'approved_by' => $user->id,
                // 'approved_date'             => date('Y-m-d H:s:i'),
                'status' => $request->status,
            ]);

            if ($request->status == 3) {
                Alert::toast('Permohonan fasiliti diluluskan!', 'success');
            } elseif ($request->status == 4) {
                Alert::toast('Permohonan fasiliti ditolak!', 'success');
            } else {
                Alert::toast('Permohonan fasiliti dikemaskini!', 'success');
            }

            return redirect()->route('pengurusan.pentadbiran.penginapan.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function permohonanPenginapanShowOnly(Request $request)
    {
        $title = 'Permohonan Penginapan';
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Penginapan' => false,
        ];
        $page_title = 'Permohonan Penginapan';

        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3',
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = PermohonanPenginapan::with('user.staff', 'approvedby')->find($request->id);
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.show', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectbilik', 'status',
            'model', 'user',

        ));
    }

    public function permohonanKenderaanIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();

        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();
        // dump($staff);

        $page_title = 'Senarai Menggunakan Kenderaan';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Permohonan Menggunakan Kenderaan' => false,
        ];

        $buttons = [
            [
                'title' => 'Mohon Kenderaan',
                'route' => route('pengurusan.pentadbiran.kenderaan.permohonan.tambah'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {

            if (data_get($kakitangan, 'staff.jabatan.id') == 14) { //unit pentadbiraan
                $data = PermohonanKenderaan::with('approvedby', 'user')->get();
            } else {
                $data = PermohonanKenderaan::with('approvedby', 'user')->where('user_id', $user->id)->get();
            }
            // dd($data);

            return DataTables::of($data)
                ->addColumn('jenis_kenderaan', function ($data) {
                    if ($data->jenis_kenderaan == 1) {
                        return 'Bas';
                    } elseif ($data->jenis_kenderaan == 2) {
                        return 'Van';
                    } elseif ($data->jenis_kenderaan == 3) {
                        return 'Serena';
                    } elseif ($data->jenis_kenderaan == 4) {
                        return 'Persona';
                    } elseif ($data->jenis_kenderaan == 5) {
                        return 'Persona-Premium';
                    } elseif ($data->jenis_kenderaan == 6) {
                        return 'Pajero';
                    } else {
                        return 'tiada kenderaan';
                    }

                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Baru Diterima';
                    } elseif ($data->status == 2) {
                        return 'Proses';
                    } elseif ($data->status == 3) {
                        return 'Lulus';
                    } elseif ($data->status == 4) {
                        return 'Tolak';
                    } else {
                        return 'Tiada Status';
                    }

                })
            // ->addColumn('tarikh_penggunaan', function($data) {
            //     return date('d-m-Y',$data->tarikh_penggunaan);

            // })
            // ->addColumn('masa', function($data) {
            //     return date('H:s:i',$data->masa);

            // })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->is_student == 1) {
                        // $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    } elseif (Auth::user()->is_staff == 1) {

                        if ($data->status != 3) {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/kenderaan/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                        } else {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/kenderaan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        }

                    } else {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/kenderaan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['jenis_kenderaan', 'tarikh_penggunaan', 'masa', 'action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                // ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_penggunaan', 'name' => 'tarikh_penggunaan', 'title' => 'Tarikh Penggunaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bil_penumpang', 'name' => 'bil_penumpang', 'title' => 'Bilangan Penumpang', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jenis_kenderaan', 'name' => 'jenis_kenderaan', 'title' => 'Jenis Kenderaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tempat', 'name' => 'tempat', 'title' => 'Tempat', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.permohonan.kenderaan.list', compact('dataTable', 'buttons', 'page_title', 'breadcrumbs'));
    }

    public function permohonanKenderaanTambah(Request $request)
    {
        $title = 'Permohonan Menggunakan Kenderaan';
        $action = route('pengurusan.pentadbiran.kenderaan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Menggunakan Kenderaan' => false,
        ];
        $page_title = 'Permohonan Menggunakan Kenderaan';

        $selectkenderaan = [
            1 => 'Bas',
            2 => 'Van',
            3 => 'Serena',
            4 => 'Persona',
            5 => 'Persona-Premium',
            6 => 'Pajero',
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = new PermohonanKenderaan();
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.kenderaan.add_new', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user',

        ));
    }

    public function permohonanKenderaanStore(Request $request)
    {
        // dd($request);

        $user = auth()->user();

        try {

            // $startDate = Carbon::createFromFormat('Y-m-d', $request->tarikh);
            // $endDate = Carbon::createFromFormat('Y-m-d', $request->tarikh_keluar);

            // $interval = $startDate->diff($endDate);
            // $days = $interval->days + 1;

            $runningno = $this->runningMan('kenderaan');
            $appno = 'KENDERAAN'.str_pad($runningno, 4, '0', STR_PAD_LEFT).date('Y');

            $insert = PermohonanKenderaan::create([
                'no_permohonan' => $appno,
                'user_id' => $user->id,
                'jenis_kenderaan' => $request->jenis_kenderaan,
                'tarikh_penggunaan' => $request->tarikh_penggunaan,
                'masa' => $request->masa,
                'tempat' => $request->tempat,
                'bil_penumpang' => $request->bil_penumpang,
                'tujuan' => $request->tujuan,
                'status' => 1, // baru terima
            ]);

            Alert::toast('Maklumat permohonan menggunakan kenderaan berjaya dihantar!', 'success');

            return redirect()->route('pengurusan.pentadbiran.kenderaan.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function permohonanKenderaanEdit(Request $request)
    {
        $title = 'Kelulusan Permohonan Menggunakan Kenderaan';
        $action = route('pengurusan.pentadbiran.kenderaan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kelulusan Permohonan Menggunakan Kenderaan' => false,
        ];
        $page_title = 'Kelulusan Permohonan Menggunakan Kenderaan';

        $selectkenderaan = [
            1 => 'Bas',
            2 => 'Van',
            3 => 'Serena',
            4 => 'Persona',
            5 => 'Persona-Premium',
            6 => 'Pajero',
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = PermohonanKenderaan::with('approvedby', 'user.staff')->find($request->id);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.kenderaan.action', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user', 'kakitangan'

        ));
    }

    public function permohonanKenderaanUpdate(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        try {

            $model = PermohonanKenderaan::find($request->id);

            $model = $model->update([

                'approved_by' => $user->id,
                'tarikh_approved' => date('Y-m-d'),
                'status' => $request->status, // baru terima
            ]);

            Alert::toast('Maklumat permohonan menggunakan kenderaan berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.pentadbiran.kenderaan.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function permohonanKenderaanShowonly(Request $request)
    {
        $title = ' Permohonan Menggunakan Kenderaan';
        $action = route('pengurusan.pentadbiran.kenderaan.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            ' Permohonan Menggunakan Kenderaan' => false,
        ];
        $page_title = ' Permohonan Menggunakan Kenderaan';

        $selectkenderaan = [
            1 => 'Bas',
            2 => 'Van',
            3 => 'Serena',
            4 => 'Persona',
            5 => 'Persona-Premium',
            6 => 'Pajero',
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = PermohonanKenderaan::with('approvedby', 'user.staff')->find($request->id);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.kenderaan.show', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user', 'kakitangan'

        ));
    }

    // permohonan pelekat kenderaan
    public function pelekatIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();

        $kakitangan = User::with('staff.jabatan', 'vendor')->where('id', $user->id)->first();
        // dump($staff);

        $page_title = 'Senarai Pelekat Kenderaan';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Pelekat Kenderaan' => false,
        ];

        $buttons = [
            [
                'title' => 'Mohon Pelekat',
                'route' => route('pengurusan.pentadbiran.pelekat.permohonan.tambah'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {

            if (data_get($kakitangan, 'staff.jabatan.id') == 14) { //unit pentadbiraan
                $data = PermohonanPelekatKenderaan::with('approvedby', 'user')->get();
            } else {
                $data = PermohonanPelekatKenderaan::with('approvedby', 'user')->where('user_id', $user->id)->get();
            }
            // dd($data);

            return DataTables::of($data)
                ->addColumn('jenis_kenderaan', function ($data) {
                    if ($data->jenis_kenderaan == 1) {
                        return 'Motokar';
                    } elseif ($data->jenis_kenderaan == 2) {
                        return 'Motorsikal';
                    } else {
                        return 'tiada jenis kenderaan';
                    }

                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Baru Diterima';
                    } elseif ($data->status == 2) {
                        return 'Proses';
                    } elseif ($data->status == 3) {
                        return 'Lulus';
                    } elseif ($data->status == 4) {
                        return 'Tolak';
                    } else {
                        return 'Tiada Status';
                    }

                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->is_student == 1) {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/pelekat/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    } elseif (Auth::user()->is_staff == 1) {

                        if ($data->status != 3) {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/pelekat/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                        } else {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/pelekat/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        }

                    } else {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/pelekat/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['jenis_kenderaan', 'action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                // ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'jenis_kenderaan', 'name' => 'jenis_kenderaan', 'title' => 'Jenis Kenderaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jenama', 'name' => 'jenama', 'title' => 'Jenama', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'no_plate', 'name' => 'no_plate', 'title' => 'No Kenderaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_tamat_cukai', 'name' => 'tarikh_tamat_cukai', 'title' => 'Tarikh Tamat Cukai', 'orderable' => false, 'class' => 'text-bold'],
                // ['data' => 'tempat', 'name' => 'tempat', 'title' => 'Tempat', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.permohonan.pelekat.list', compact('dataTable', 'buttons', 'page_title', 'breadcrumbs'));
    }

    public function pelekatTambah(Request $request)
    {
        $title = 'Permohonan Pelekat Kenderaan';
        $action = route('pengurusan.pentadbiran.pelekat.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Pelekat Kenderaan' => false,
        ];
        $page_title = 'Permohonan Pelekat Kenderaan';

        $selectkenderaan = [
            1 => 'Motorkar',
            2 => 'Motorsikal',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = new PermohonanPelekatKenderaan();
        $user = Auth::user();

        return view('pages.pengurusan.pentadbiran.permohonan.pelekat.add_new', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user',

        ));
    }

    public function pelekatStore(Request $request)
    {
        // dump($request);
        // dd($request->salinan_geran);
        $user = auth()->user();
        $typeuser = User::with('staff.jabatan', 'vendor')->find($user->id);

        if ($user->is_student) {
            $jenis_pemohon = 1; //pelajar
        } elseif ($user->is_staff) {
            $jenis_pemohon = 2; // staff
        } else {
            $jenis_pemohon = 3; // vendor
        }

        $motorkar = 0;
        $motorsikal = 0;
        $checkPelekat = PermohonanPelekatKenderaan::where('user_id', $user->id)->where('status', 3)->get();

        foreach ($checkPelekat as $chek) {
            if ($chek->jenis_kenderaan == 1) { //motorkar
                $motorkar = $motorkar + 1;
            } elseif ($chek->jenis_kenderaan == 2) { //motorsikal
                $motorsikal = $motorsikal + 1;
            } else {

            }
        }

        if ($jenis_pemohon == 1) { //pelajar
            if (($motorkar + $motorsikal) >= 1) {
                $flag = 0;
            } else {
                $flag = 1;
            }
        } elseif ($jenis_pemohon == 2) {//staff
            if (($motorkar >= 2) && ($motorsikal >= 1)) {
                $flag = 0;
            } else {
                $flag = 1;
            }
        } else {
            if (($motorkar + $motorsikal) >= 1) {
                $flag = 0;
            } else {
                $flag = 1;
            }
        }

        // dump($motorkar);
        // dd($flag);

        if ($flag == 1) {

            $validation = $request->validate([
                'jenis_kenderaan' => 'required',
                'jenama' => 'required',
                'no_plate' => 'required',
                'tarikh_tamat_cukai' => 'required',
                'tarikh_tamat_lesen' => 'required',

            ], [
                'jenis_kenderaan.required' => 'Sila masukkan jenis kenderaan',
                'jenama.required' => 'Sila masukkan jenama kenderaan',
                'no_plate.required' => 'Sila masukkan no kenderaan/plate',
                'tarikh_tamat_cukai.required' => 'Sila masukkan tarikh tamat cukai',
                'tarikh_tamat_lesen.required' => 'Sila masukkan tarikh tamat lesen',
            ]);

            try {

                $runningno = $this->runningMan('pelekat');
                $appno = 'PELEKAT'.str_pad($runningno, 4, '0', STR_PAD_LEFT).date('Y');

                if (! empty($request->file)) {
                    // unlink(storage_path($rule->uploaded_document));
                    $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
                    $file_path = 'uploads/permohonan/pelekat/';
                    $file = $request->file('file');
                    $file->move($file_path, $file_name);
                    $file = $file_path.''.$file_name;

                    $original_filename = $request->file->getClientOriginalName();
                } else {
                    $original_filename = '';
                    $file = '';
                }

                if (! empty($request->salinan_geran)) {
                    // unlink(storage_path($rule->uploaded_document));
                    $file_name_geran = uniqid().'.'.$request->salinan_geran->getClientOriginalExtension();
                    $file_path_geran = 'uploads/permohonan/pelekat/';
                    $file_geran = $request->file('salinan_geran');
                    $file_geran->move($file_path_geran, $file_name_geran);
                    $file_geran = $file_path_geran.''.$file_name_geran;

                    $original_filename_geran = $request->salinan_geran->getClientOriginalName();
                } else {
                    $original_filename_geran = '';
                    $file_geran = '';
                }

                if (! empty($request->salinan_surat_kuasa)) {
                    // unlink(storage_path($rule->uploaded_document));
                    $file_name_surat_kuasa = uniqid().'.'.$request->salinan_surat_kuasa->getClientOriginalExtension();
                    $file_path_surat_kuasa = 'uploads/permohonan/pelekat/';
                    $file_surat_kuasa = $request->file('salinan_surat_kuasa');
                    $file_surat_kuasa->move($file_path_surat_kuasa, $file_name_surat_kuasa);
                    $file_surat_kuasa = $file_path_surat_kuasa.''.$file_name_surat_kuasa;

                    $original_filename_surat_kuasa = $request->salinan_surat_kuasa->getClientOriginalName();
                } else {
                    $original_filename_surat_kuasa = '';
                    $file_surat_kuasa = '';
                }

                if (! empty($request->salinan_lesen)) {
                    // unlink(storage_path($rule->uploaded_document));
                    $file_name_salinan_lesen = uniqid().'.'.$request->salinan_lesen->getClientOriginalExtension();
                    $file_path_salinan_lesen = 'uploads/permohonan/pelekat/';
                    $file_salinan_lesen = $request->file('salinan_lesen');
                    $file_salinan_lesen->move($file_path_salinan_lesen, $file_name_salinan_lesen);
                    $file_salinan_lesen = $file_path_salinan_lesen.''.$file_name_salinan_lesen;

                    $original_filename_salinan_lesen = $request->salinan_lesen->getClientOriginalName();
                } else {
                    $original_filename_salinan_lesen = '';
                    $file_salinan_lesen = '';
                }

                $insert = PermohonanPelekatKenderaan::create([
                    'no_permohonan' => $appno,
                    'user_id' => $user->id,
                    'jenis_pemohon' => $jenis_pemohon,
                    'jenis_kenderaan' => $request->jenis_kenderaan,
                    'jenama' => $request->jenama,
                    'document_name' => $original_filename,
                    'upload_document' => $file,
                    'document_name_geran' => $original_filename_geran,
                    'upload_document_geran' => $file_geran,
                    'document_name_surat_kuasa' => $original_filename_surat_kuasa,
                    'upload_document_surat_kuasa' => $file_surat_kuasa,
                    'document_name_lesen' => $original_filename_salinan_lesen,
                    'upload_document_lesen' => $file_salinan_lesen,
                    'no_plate' => $request->no_plate,
                    'tarikh_tamat_cukai' => $request->tarikh_tamat_cukai,
                    'tarikh_tamat_lesen' => $request->tarikh_tamat_lesen,
                    'status' => 1, // baru terima
                ]);

                Alert::toast('Maklumat permohonan pelekat kenderaan berjaya dihantar!', 'success');

                return redirect()->route('pengurusan.pentadbiran.pelekat.permohonan.index');

            } catch (Exception $e) {
                report($e);

                Alert::toast('Uh oh! Something went Wrong', 'error');

                return redirect()->back();
            }

        } else {
            Alert::toast('Anda sudah melebih kouta untuk pelekat kenderaan! Pelajar = 1, Staf = 2 Motokar,1 Motorsikal, Vendor = 1', 'error');

            return redirect()->route('pengurusan.pentadbiran.pelekat.permohonan.index');
        }

    }

    public function pelekatEdit(Request $request)
    {
        $title = 'Kelulusan Permohonan Pelekat Kenderaan';
        $action = route('pengurusan.pentadbiran.pelekat.permohonan.update');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kelulusan Permohonan Pelekat Kenderaan' => false,
        ];
        $page_title = 'Kelulusan Permohonan Pelekat Kenderaan';

        $selectkenderaan = [
            1 => 'Motokar',
            2 => 'Motorsikal',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        $model = PermohonanPelekatKenderaan::with('approvedby', 'user.staff.jabatan', 'user.vendor')->find($request->id);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.pelekat.action', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user', 'kakitangan'

        ));
    }

    public function pelekatUpdate(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        try {

            $model = PermohonanPelekatKenderaan::find($request->id);

            $model = $model->update([

                'approved_by' => $user->id,
                'tarikh_approved' => date('Y-m-d'),
                'status' => $request->status, // baru terima
            ]);

            Alert::toast('Maklumat permohonan pelekat kenderaan berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.pentadbiran.pelekat.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function pelekatShowOnly(Request $request)
    {
        $title = 'Kelulusan Permohonan Pelekat Kenderaan';
        $action = route('pengurusan.pentadbiran.pelekat.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Kelulusan Permohonan Pelekat Kenderaan' => false,
        ];
        $page_title = 'Kelulusan Permohonan Pelekat Kenderaan';

        $selectkenderaan = [
            1 => 'Motokar',
            2 => 'Motorsikal',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $jenispemohon = [
            1 => 'Pelajar',
            2 => 'Kakitangan',
            3 => 'Vendor',
        ];

        $model = PermohonanPelekatKenderaan::with('approvedby.staff', 'user.staff.jabatan', 'user.vendor')->find($request->id);
        // dd($model);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.pelekat.show', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'selectkenderaan', 'status',
            'model', 'user', 'kakitangan', 'jenispemohon'

        ));
    }

    // Permohonan Kuarters
    public function kuartersIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();

        $kakitangan = User::with('staff.jabatan', 'vendor')->where('id', $user->id)->first();
        // dump($staff);

        $page_title = 'Senarai Permohonan Kuarters';
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Senarai Permohonan Kuarters' => false,
        ];

        $buttons = [
            [
                'title' => 'Mohon Kuarters',
                'route' => route('pengurusan.pentadbiran.kuarters.permohonan.tambah'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {

            if (data_get($kakitangan, 'staff.jabatan.id') == 14) { //unit pentadbiraan
                $data = PermohonanKuarters::with('approvedby', 'user')->get();
            } else {
                $data = PermohonanKuarters::with('approvedby', 'user')->where('user_id', $user->id)->get();
            }
            // dd($data);

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Baru Diterima';
                    } elseif ($data->status == 2) {
                        return 'Proses';
                    } elseif ($data->status == 3) {
                        return 'Lulus';
                    } elseif ($data->status == 4) {
                        return 'Tolak';
                    } else {
                        return 'Tiada Status';
                    }

                })
                ->addColumn('action', function ($data) use ($kakitangan) {
                    if (Auth::user()->is_student == 1) {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/kuarters/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    } elseif (Auth::user()->is_staff == 1) {

                        if ((data_get($kakitangan, 'staff.jabatan.id') == 14) && ($data->status != 3)) {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/kuarters/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                        } else {
                            $btn = '<a href="'.url('/pengurusan/pentadbiran/kuarters/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                        }

                    } else {
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/kuarters/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'no_pengenalan', 'name' => 'no_pengenalan', 'title' => 'No Pengenalan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jawatan_gred', 'name' => 'jawatan_gred', 'title' => 'Jawatan Gred', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbiran.permohonan.kuarters.list', compact('dataTable', 'buttons', 'page_title', 'breadcrumbs'));
    }

    public function kuartersTambah(Request $request)
    {
        $title = 'Permohonan Kuarters';
        $action = route('pengurusan.pentadbiran.kuarters.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Kuarters' => false,
        ];
        $page_title = 'Permohonan Kuarters';

        $statuskahwin = [
            1 => 'Bujang',
            2 => 'Berkahwin',
            3 => 'Janda',
            4 => 'Duda',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $warganegara = [
            1 => 'Malaysia',
            2 => 'Bukan Warganegara',
        ];

        $carabelirumah = [
            1 => 'Tunai',
            2 => 'Pinjaman Kerajaan',
            3 => 'Bank',
        ];

        $model = new PermohonanKuarters();
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.kuarters.add_new', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'statuskahwin', 'status',
            'model', 'user', 'warganegara', 'kakitangan', 'carabelirumah'

        ));
    }

    public function kuartersStore(Request $request)
    {
        // dd($request);
        // dd($request->salinan_geran);
        $user = auth()->user();
        $typeuser = User::with('staff.jabatan', 'vendor')->find($user->id);
        // dump($motorkar);
        // dd($flag);

        $validation = $request->validate([
            'nama' => 'required',
            'no_pengenalan' => 'required',
            'warganegara' => 'required',
            'status_perkahwinan' => 'required',
            'jawatan_gred' => 'required',
            'gaji_pokok' => 'required',
            'tarikh_khidmat_kerajaan' => 'required',
            'tarikh_khidmat_dq' => 'required',
            // 'alamat_sekarang'              => 'required',
            'alasan_mohon' => 'required',

        ], [
            'nama.required' => 'Sila masukkan nam',
            'no_pengenalan.required' => 'Sila masukkan No Pengenalan',
            'warganegara.required' => 'Sila masukkan warganegara',
            'status_perkahwinan.required' => 'Sila masukkan status perkahwinan',
            'jawatan_gred.required' => 'Sila masukkan jawatan /gred',
            'gaji_pokok.required' => 'Sila masukkan gaji pokok',
            'tarikh_khidmat_kerajaan.required' => 'Sila masukkan tarikh berkhidmat dengan kerajaan',
            'tarikh_khidmat_dq.required' => 'Sila masukkan tarikh berkhidmat dengan DQ',
            'alamat_sekarang.required' => 'Sila masukkan alamat sekarang',
            'alasan_mohon.required' => 'Sila masukkan alasan memohon',
        ]);

        try {

            $runningno = $this->runningMan('kuarters');
            $appno = 'KUARTERS'.str_pad($runningno, 4, '0', STR_PAD_LEFT).date('Y');

            $insert = PermohonanKuarters::create([
                'no_permohonan' => $appno,
                'user_id' => $user->id,
                'nama' => data_get($request, 'nama'),
                'no_pengenalan' => data_get($request, 'no_pengenalan'),
                'warganegara' => data_get($request, 'warganegara'),
                'status_perkahwinan' => data_get($request, 'status_perkahwinan'),
                'nama_pasangan' => data_get($request, 'nama_pasangan'),
                'bil_anak' => data_get($request, 'bil_anak'),
                'bil_oku' => data_get($request, 'bil_oku'),
                'jawatan_gred' => data_get($request, 'jawatan_gred'),
                'gaji_pokok' => data_get($request, 'gaji_pokok'),
                'tarikh_khidmat_kerajaan' => data_get($request, 'tarikh_khidmat_kerajaan'),
                'tarikh_khidmat_dq' => data_get($request, 'tarikh_khidmat_dq'),
                'alamat_sekarang' => data_get($request, 'alamat_sekarang'),
                'alamat_rumah' => data_get($request, 'alamat_rumah'),
                'cara_beli_rumah' => data_get($request, 'cara_beli_rumah'),
                'jarak_rumah_dq' => data_get($request, 'jarak_rumah_dq'),
                'loan_pasangan' => data_get($request, 'loan_pasangan'),
                'alamat_rumah2' => data_get($request, 'alamat_rumah2'),
                'alasan_mohon' => data_get($request, 'alasan_mohon'),
                'status' => 1, // baru terima
            ]);

            Alert::toast('Maklumat permohonan kuarters berjaya dihantar!', 'success');

            return redirect()->route('pengurusan.pentadbiran.kuarters.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function kuartersEdit(Request $request)
    {
        $title = 'Permohonan Kuarters';
        $action = route('pengurusan.pentadbiran.kuarters.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Kuarters' => false,
        ];
        $page_title = 'Permohonan Kuarters';

        $statuskahwin = [
            1 => 'Bujang',
            2 => 'Berkahwin',
            3 => 'Janda',
            4 => 'Duda',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $warganegara = [
            1 => 'Malaysia',
            2 => 'Bukan Warganegara',
        ];

        $carabelirumah = [
            1 => 'Tunai',
            2 => 'Pinjaman Kerajaan',
            3 => 'Bank',
        ];

        $model = PermohonanKuarters::with('approvedby', 'user')->find($request->id);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.kuarters.action', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'statuskahwin', 'status',
            'model', 'user', 'warganegara', 'kakitangan', 'carabelirumah'

        ));
    }

    public function kuartersUpdate(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        try {

            $model = PermohonanKuarters::find($request->id);

            $model = $model->update([

                'approved_by' => $user->id,
                'tarikh_approved' => date('Y-m-d'),
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat permohonan kuarters berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.pentadbiran.kuarters.permohonan.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }

    }

    public function kuartersShowOnly(Request $request)
    {
        $title = 'Permohonan Kuarters';
        $action = route('pengurusan.pentadbiran.kuarters.permohonan.store');
        $breadcrumbs = [
            'Pentadbiran' => false,
            'Permohonan Kuarters' => false,
        ];
        $page_title = 'Permohonan Kuarters';

        $statuskahwin = [
            1 => 'Bujang',
            2 => 'Berkahwin',
            3 => 'Janda',
            4 => 'Duda',

        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak',
        ];
        $warganegara = [
            1 => 'Malaysia',
            2 => 'Bukan Warganegara',
        ];

        $carabelirumah = [
            1 => 'Tunai',
            2 => 'Pinjaman Kerajaan',
            3 => 'Bank',
        ];

        $model = PermohonanKuarters::with('approvedby', 'user')->find($request->id);
        $user = Auth::user();
        $kakitangan = User::with('staff.jabatan')->where('id', $user->id)->first();

        return view('pages.pengurusan.pentadbiran.permohonan.kuarters.show', compact(
            'title', 'action', 'page_title',
            'breadcrumbs', 'statuskahwin', 'status',
            'model', 'user', 'warganegara', 'kakitangan', 'carabelirumah'

        ));
    }
}
