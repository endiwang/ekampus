<?php

namespace App\Http\Controllers\Pemohon\Sijil_Tahfiz;

use App\Http\Controllers\Controller;
use App\Mail\PermohonanBaruSijilTahfiz;
use App\Models\Negeri;
use App\Models\Pelajar;
use App\Models\Pemohon;
use App\Models\PermohonanSijilTahfiz;
use App\Models\PermohonanSijilTahfizFile;
use App\Models\PusatPeperiksaan;
use App\Models\PusatPeperiksaanNegeri;
use App\Models\Staff;
use App\Models\TemplateJemputanMajlisPensijilan;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use App\Models\Zon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class SemakanJemputanMajlisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $user = Auth::guard('pemohon')->user();
        $data = PermohonanSijilTahfiz::where('pemohon_id', $user->id)->where('status_janaan_jemputan', 1)->get();
        $template = TemplateJemputanMajlisPensijilan::where('status', 1)->pluck('majlis_id', 'id')->all();
        $nama_majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->pluck('nama', 'id')->all();
        $tarikh_majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->pluck('tarikh_majlis_mula', 'id')->all();
        
        if (request()->ajax()) {
            return DataTables::of($data)
            ->addColumn('nama_majlis', function($data) use ($template, $nama_majlis) {
                $majlis_id = @$template[@$data->template_jemputan_id];
                $nama= @$nama_majlis[@$majlis_id];
             
                return $nama;
            })
            ->addColumn('tarikh_majlis', function($data) use ($template, $tarikh_majlis) {
                $majlis_id = @$template[@$data->template_jemputan_id];
                $tarikh= Carbon::parse(@$tarikh_majlis[@$majlis_id])->format('d/m/Y');
             
                return $tarikh;
            })
            ->addColumn('status_kehadiran', function ($data) {
                switch ($data->status_kehadiran) {
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Hadir</span>';
                        break;
                    case 2:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Hadir</span>';
                        break;
                    default:
                        return '';
                }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pemohon.permohonan_sijil_tahfiz.semakan_jemputan_majlis.downloadPdf',$data->template_jemputan_id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Muat Turun"><i class="fa fa-download"></i></a> ';
                if(empty($data->status_kehadiran)){
                    $btn .= '<a class="btn btn-success btn-sm" data-bs-toggle="tooltip" onClick="checkKehadiran(1,'.$data->id.')" title="Lihat">Hadir</a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" onClick="checkKehadiran(2,'.$data->id.')" title="Lihat">TIdak Hadir</a>';
                }
                

                return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                // $data->orderBy('id', 'desc');
            })
            ->rawColumns(['nama_majlis','action','status_kehadiran'])
            ->toJson();
        }
        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'nama_majlis', 'name' => 'nama_majlis', 'title' => 'Majlis', 'orderable'=> false],
            ['data' => 'tarikh_majlis', 'name' => 'tarikh_majlis', 'title' => 'Tarikh', 'orderable'=> false],
            ['data' => 'status_kehadiran', 'name' => 'status_kehadiran', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
        ])
        ->minifiedAjax();

        return view('pages.pemohon.sijil_tahfiz.semak_jemputan.main', compact('html'));

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
        $status_kehadiran = $request->get('status_kehadiran');

        DB::beginTransaction();
        try {
            PermohonanSijilTahfiz::where('id', $id)->update(['status_kehadiran'=>$status_kehadiran]);
            Alert::toast('Kehadiran Telah Disahkan', 'success');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            Alert::toast('Kehadiran Tidak Dapat Disahkan', 'error');
        }

        return redirect()->route('pemohon.permohonan_sijil_tahfiz.semakan_jemputan_majlis.index');
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

    public function downloadPdf($template_id)
    {
        $template_jemputan  = TemplateJemputanMajlisPensijilan::find($template_id);
        $tetapan_majlis     = TetapanMajlisPenyerahanSijilTahfiz::find($template_jemputan->majlis_id);
        $pegawai            =  Staff::find($tetapan_majlis->staff_id);
        preg_match_all('/{([^}]*)}/', $template_jemputan->template, $matches);
       
        $message_body = '';
        $message_body .= $template_jemputan->template;
        
        foreach ($matches[0] as $pholder) {
            
            if ($pholder == '{NamaMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->nama, $message_body);
            }

            if ($pholder == '{LokasiMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->lokasi_majlis, $message_body);
            }

            if ($pholder == '{TarikhMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->tarikh_majlis_mula, $message_body);
            }

            if ($pholder == '{MasaMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->masa_majlis, $message_body);
            }

            if ($pholder == '{PegawaiUntukDihubungi}') {
                $message_body = str_replace($pholder, $pegawai->nama.'('.$pegawai->no_tel.')', $message_body);
            }
        }
       
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.majlis_pensijilan.jemputan_majlis_pensijilan.export_pdf', compact('message_body'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('JemputanMajlisPensijilan.pdf');
    }
}
