<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PermohonanSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PeperiksaanPemarkahanCalonSijilTahfizController extends Controller
{
    public function index(Builder $builder){
        $title = "Peperiksaan & Pemarkahan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Peperiksaan & Pemarkahan" =>  '#',
            "Calon Sijil Tahfiz" => '#',
        ];

        if (request()->ajax()) {
            $data = PermohonanSijilTahfiz::where('status_tawaran',1)->where('status_hadir_peperiksaan',0)->get();
            return DataTables::of($data)
            ->addColumn('nama_pemohon', function($data) {
                return $data->pelajar->nama;

            })
            ->addColumn('no_id', function($data) {
                return $data->pelajar->no_ic;

            })
            ->addColumn('action', function($data){
                $btn = '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Ditemuduga</span>';
                if(!$data->status_hadir_peperiksaan){
                    $btn =' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-success btn-sm" data-bs-toggle="tooltip" title="Kelayakan"><i class="fa fa-marker"></i></a>';
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

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'nama_pemohon', 'name' => 'name', 'title' => 'Nama Pemohon', 'orderable'=> false],
            ['data' => 'no_id', 'name' => 'no_id', 'title' => 'No Kad Pengenalan', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.peperiksaan_pemarkahan.calon_sijil_tahfiz.main', compact('title','breadcrumbs', 'html'));
    }

    public function edit($id){
        $title = "Borang Pemarkahan Sijil Tahfiz";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Peperiksaan & Pemarkahan" =>  '#',
            "Borang Pemarkahan Sijil Tahfiz" => '#',
        ];

        $permohonan = PermohonanSijilTahfiz::find($id);
        $pelajar = $permohonan->pelajar->first();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'permohonan' => $permohonan,
            'pelajar' => $pelajar,
            'id' => $id,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.peperiksaan_pemarkahan.calon_sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'al_quran_syafawi'  => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:100',
            'al_quran_tahriri' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:100',
            'tajwid' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:20',
            'fiqh_ibadah' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:40',
            'akidah' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|max:40',
        ],[
            'al_quran_syafawi.required' => 'Ruangan ini perlu diisi.',
            'al_quran_tahriri.required' => 'Ruangan ini perlu diisi.',
            'tajwid.required' => 'Ruangan ini perlu diisi.',
            'fiqh_ibadah.required' => 'Ruangan ini perlu diisi.',
            'akidah.required' => 'Ruangan ini perlu diisi.',
            'al_quran_syafawi.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
            'al_quran_tahriri.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
            'tajwid.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
            'fiqh_ibadah.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
            'akidah.regex' => 'Format markah yang diisi salah. Contoh format: 20 atau 20.30',
            'al_quran_syafawi.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
            'al_quran_tahriri.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
            'tajwid.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
            'fiqh_ibadah.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
            'akidah.numeric' => 'Ruangan ini perlu diisi dengan nombor.',
            'al_quran_syafawi.max' => 'Markah tidak boleh lebih dari 100%.',
            'al_quran_tahriri.max' => 'Markah tidak boleh lebih dari 100%.',
            'tajwid.max' => 'Markah tidak boleh lebih dari 20%.',
            'fiqh_ibadah.max' => 'Markah tidak boleh lebih dari 20%.',
            'akidah.max' => 'Markah tidak boleh lebih dari 40%.',
        ]);

        $pengetahuan_islam_mark = 0;
        if($request->has('tajwid')){
            $pengetahuan_islam_mark +=$request->tajwid;
        }

        if($request->has('fiqh_ibadah')){
            $pengetahuan_islam_mark +=$request->fiqh_ibadah;
        }

        if($request->has('akidah')){
            $pengetahuan_islam_mark +=$request->akidah;
        }

        $total_examiner_mark = $request->al_quran_syafawi+$request->al_quran_tahriri+$pengetahuan_islam_mark;
        $total_mark = ($total_examiner_mark*100)/300;
        $request['total_mark'] = floor($total_mark * 100) / 100;

        $request['status_kelulusan'] = 0;
        if ($request->al_quran_syafawi <=54) {
            $request['keputusan_peperiksaan'] = 'Rasib';
        }

        if($request->al_quran_tahriri <=54){
            $request['keputusan_peperiksaan'] = 'Rasib';
        }

        if($pengetahuan_islam_mark <=54){
            $request['keputusan_peperiksaan'] = 'Rasib';
        }

        if(!$request->has('keputusan_peperiksaan')){
            if($request['total_mark'] >=90){
                $request['keputusan_peperiksaan'] = 'Mumtaz';
                $request['status_kelulusan'] = 1;
            } elseif($request['total_mark'] >= 80 && $request['total_mark'] <= 89){
                $request['keputusan_peperiksaan'] = 'Jayyid Jiddan';
                $request['status_kelulusan'] = 1;
            } elseif($request['total_mark'] >= 70 && $request['total_mark'] <= 79){
                $request['keputusan_peperiksaan'] = 'Jayyid';
                $request['status_kelulusan'] = 1;
            } elseif($request['total_mark'] >= 55 && $request['total_mark'] <= 69){
                $request['keputusan_peperiksaan'] = 'Maqbul';
                $request['status_kelulusan'] = 1;
            } else {
                $request['keputusan_peperiksaan'] = 'Rasib';
            }
        }

        $request['examiner_id'] = Auth::id();
        $request['created_by'] = Auth::id();
        $request['permohonan_id'] = $id;

        DB::beginTransaction();

        try {
            PemarkahanCalonSijilTahfiz::create($request->except('_method', '_token'));
            
            PermohonanSijilTahfiz::where('id', $id)->update(['status_hadir_peperiksaan'=>1]);

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }
        
        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.index');
    }
}
