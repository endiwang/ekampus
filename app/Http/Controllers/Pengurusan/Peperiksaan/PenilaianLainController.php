<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PermohonanSijilTahfiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianLainController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.penilaian_lain.';

    protected $baseRoute = 'pengurusan.peperiksaan.penilaian_lain.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {
        $title = 'Peperiksaan/Penilaian Lain';
        $breadcrumbs = [
            'Peperiksaan' => false,
            'Peperiksaan/Penilaian Lain' => false,
        ];

        if (request()->ajax()) {
            $data = PermohonanSijilTahfiz::with('markahPermohonan')->where('status_tawaran', 1);
            if ($request->has('nama') && $request->nama != null) {
                $data->where('name', 'LIKE', '%'.$request->nama.'%');
            }
            if ($request->has('no_ic') && $request->no_ic != null) {
                $data->where('ic_no', 'LIKE', '%'.$request->no_ic.'%');
            }

            return DataTables::of($data)
                ->addColumn('nama_pemohon', function ($data) {
                    return $data->name;
                })
                ->addColumn('no_ic', function ($data) {
                    return $data->ic_no;
                })
                ->addColumn('jenis_peperiksaan', function ($data) {
                    return 'Sijil Tahfiz Malaysia';
                })
                ->addColumn('markah_akhir', function ($data) {
                    return $data->markahPermohonan->total_mark ?? '0.00';
                })
                ->addColumn('action', function ($data) {
                    $btn = '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Ditemuduga</span>';
                    if (! $data->status_hadir_peperiksaan) {
                        if (! empty($data->markahPermohonan) && $data->markahPermohonan->status_hadir_ujian_shafawi) {
                            $btn = ' <a href="javascript:void(0)" class="btn btn-icon-primary btn-text-primary btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i>Temuduga Syafawi</a>';
                        } else {
                            $btn = ' <a href="'.route('pengurusan.peperiksaan.penilaian_lain.temuduga_syafawi', $data->id).'" class="btn btn-icon-primary btn-text-primary btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i>Temuduga Syafawi</a>';
                        }

                        if (! empty($data->markahPermohonan) && $data->markahPermohonan->status_hadir_ujian_tahriri) {
                            $btn .= ' <a href="javascript:void(0)" class="btn btn-icon-primary btn-text-primary btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i>Tahriri & Pengetahuan islam</a>';
                        } else {
                            $btn .= ' <a href="'.route('pengurusan.peperiksaan.penilaian_lain.temuduga_tahriri', $data->id).'" class="btn btn-icon-primary btn-text-primary btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i>Tahriri & Pengetahuan islam</a>';
                        }
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    // $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'nama_pemohon', 'name' => 'name', 'title' => 'Nama Pemohon', 'orderable' => false],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No Kad Pengenalan', 'orderable' => false],
                ['data' => 'jenis_peperiksaan', 'name' => 'jenis_peperiksaan', 'title' => 'Jenis Peperiksaan', 'orderable' => false],
                ['data' => 'markah_akhir', 'name' => 'markah_akhir', 'title' => 'Markah Akhir', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

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
        if ($request->syafawi) {
            $validated = $request->validate([
                'al_quran_syafawi' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:100',
            ], [
                'al_quran_syafawi.required' => 'Ruangan ini perlu diisi.',
                'al_quran_syafawi.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
                'al_quran_syafawi.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
                'al_quran_syafawi.max' => 'Markah tidak boleh lebih dari 100%.',
            ]);
        } else {
            $validated = $request->validate([
                'al_quran_tahriri' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:100',
                'tajwid' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:20',
                'fiqh_ibadah' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:40',
                'akidah' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:40',
            ], [
                'al_quran_tahriri.required' => 'Ruangan ini perlu diisi.',
                'tajwid.required' => 'Ruangan ini perlu diisi.',
                'fiqh_ibadah.required' => 'Ruangan ini perlu diisi.',
                'akidah.required' => 'Ruangan ini perlu diisi.',
                'al_quran_tahriri.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
                'tajwid.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
                'fiqh_ibadah.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
                'akidah.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
                'al_quran_tahriri.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
                'tajwid.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
                'fiqh_ibadah.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
                'akidah.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
                'al_quran_tahriri.max' => 'Markah tidak boleh lebih dari 100%.',
                'tajwid.max' => 'Markah tidak boleh lebih dari 20%.',
                'fiqh_ibadah.max' => 'Markah tidak boleh lebih dari 20%.',
                'akidah.max' => 'Markah tidak boleh lebih dari 40%.',
            ]);
        }

        if ($request->has('al_quran_syafawi')) {
            $request['status_hadir_ujian_shafawi'] = 1;
        }

        if ($request->has('al_quran_tahriri')) {
            $request['status_hadir_ujian_tahriri'] = 1;
        }

        if ($request->has('tajwid') || $request->has('fiqh_ibadah') || $request->has('akidah')) {
            $request['status_hadir_ujian_pengetahuan_islam'] = 1;
        }

        $request['permohonan_id'] = $id;

        DB::beginTransaction();

        try {
            //check if permohonan already evaluate
            $pemarkahan = PemarkahanCalonSijilTahfiz::where('permohonan_id', $id)->first();
            if (empty($pemarkahan)) {
                PemarkahanCalonSijilTahfiz::create($request->except('_method', '_token'));
            } else {
                if ($request->has('syafawi')) {
                    $pemarkahan->update($request->except('_method', '_token', 'al_quran_tahriri', 'tajwid', 'fiqh_ibadah', 'akidah'));
                } else {
                    $pemarkahan->update($request->except('_method', '_token', 'al_quran_syafawi'));
                }

            }

            $final_markah = PemarkahanCalonSijilTahfiz::where('permohonan_id', $id)
                ->where('status_hadir_ujian_shafawi', 1)
                ->where('status_hadir_ujian_tahriri', 1)
                ->where('status_hadir_ujian_pengetahuan_islam', 1)
                ->first();

            if (! empty($final_markah)) {
                $pengetahuan_islam_mark = 0;
                if ($final_markah->tajwid) {
                    $pengetahuan_islam_mark += $final_markah->tajwid;
                }

                if ($final_markah->fiqh_ibadah) {
                    $pengetahuan_islam_mark += $final_markah->fiqh_ibadah;
                }

                if ($final_markah->akidah) {
                    $pengetahuan_islam_mark += $final_markah->akidah;
                }

                $total_examiner_mark = $final_markah->al_quran_syafawi + $final_markah->al_quran_tahriri + $pengetahuan_islam_mark;
                $total_mark = ($total_examiner_mark * 100) / 300;
                $final['total_mark'] = floor($total_mark * 100) / 100;

                $final['status_kelulusan'] = 0;
                if ($final_markah->al_quran_syafawi <= 54 || $final_markah->al_quran_tahriri <= 54 || $pengetahuan_islam_mark <= 39) {
                    $final['keputusan_peperiksaan'] = 'Rasib';
                } else {
                    if ($total_mark >= 90) {
                        $final['keputusan_peperiksaan'] = 'Mumtaz';
                        $final['status_kelulusan'] = 1;
                    } elseif ($total_mark >= 80 && $total_mark <= 89) {
                        $final['keputusan_peperiksaan'] = 'Jayyid Jiddan';
                        $final['status_kelulusan'] = 1;
                    } elseif ($total_mark >= 70 && $total_mark <= 79) {
                        $final['keputusan_peperiksaan'] = 'Jayyid';
                        $final['status_kelulusan'] = 1;
                    } elseif ($total_mark >= 55 && $total_mark <= 69) {
                        $final['keputusan_peperiksaan'] = 'Maqbul';
                        $final['status_kelulusan'] = 1;
                    } else {
                        $final['keputusan_peperiksaan'] = 'Rasib';
                    }
                }

                $final_markah->update($final);
                PermohonanSijilTahfiz::where('id', $id)->update(['status_hadir_peperiksaan' => 1]);
            }

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();

            return redirect()->route($this->baseRoute.'index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
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

    public function temuduga_syafawi($id)
    {
        $title = 'Pemarkahan Al-Quran Syafawi';
        $breadcrumbs = [
            'Peperiksaan' => false,
            'Penilaian Lain' => route($this->baseRoute.'index'),
            'Borang Pemarkahan Sijil Tahfiz' => false,
        ];

        $permohonan = PermohonanSijilTahfiz::find($id);
        $pemohon = $permohonan->pemohon;

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'permohonan' => $permohonan,
            'pemohon' => $pemohon,
            'id' => $id,
            'syafawi' => 1,
        ];

        return view($this->baseView.'show', $data);
    }

    public function tahriri_pengetahuan_islam($id)
    {
        $title = 'Pemarkahan Al-Quran Tahriri & Pengetahuan Islam';
        $breadcrumbs = [
            'Peperiksaan' => false,
            'Penilaian Lain' => route($this->baseRoute.'index'),
            'Borang Pemarkahan Sijil Tahfiz' => false,
        ];

        $permohonan = PermohonanSijilTahfiz::find($id);
        $pemohon = $permohonan->pemohon;

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'permohonan' => $permohonan,
            'pemohon' => $pemohon,
            'id' => $id,
            'syafawi' => 0,
        ];

        return view($this->baseView.'show', $data);
    }
}
