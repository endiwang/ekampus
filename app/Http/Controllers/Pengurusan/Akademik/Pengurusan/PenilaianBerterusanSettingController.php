<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Http\Controllers\Controller;
use App\Models\PenilaianBerterusan;
use App\Models\PenilaianBerterusanComponent;
use App\Models\PenilaianBerterusanItem;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianBerterusanSettingController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Tetapan Penilaian Berterusan';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan' => false,
                'Tetapan Penilaian Berterusan' => false,
            ];

            if (request()->ajax()) {
                $data = Subjek::where('deleted_at', null);
                if ($request->has('nama_subjek') && $request->nama_subjek != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama_subjek.'%');
                }
                if ($request->has('kod_subjek') && $request->kod_subjek != null) {
                    $data->where('kod_subjek', 'LIKE', '%'.$request->kod_subjek.'%');
                }

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tambah Item Penilaian Berterusan">
                                <i class="fa fa-plus"></i>
                            </a>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable' => false],
                    ['data' => 'kredit', 'name' => 'kredit', 'title' => 'Kredit', 'orderable' => false],
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
        $validation = $request->validate([
            'markah_aktiviti' => 'required',
            'markah_peperiksaan' => 'required',
        ], [
            'markah_aktiviti.required' => 'Sila masukkan maklumat nama fail',
            'markah_peperiksaan.required' => 'Sila pilih jenis dokumen',
        ]);

        try {
            PenilaianBerterusan::updateOrCreate([
                'subjek_id' => $request->subjek_id,
            ], [
                'peratus_aktiviti' => $request->markah_aktiviti,
                'peratus_peperiksaan' => $request->markah_peperiksaan,
            ]);

            Alert::toast('Maklumat Tetapan Penilaian berjaya disimpan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // try {

        $title = 'Tetapan Penilaian';
        $action = route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.store');
        $page_title = 'Maklumat Tetapan Penilaian';
        $breadcrumbs = [
            'Akademik' => false,
            'Pengurusan' => false,
            'Tetapan Penilaian Berterusan' => route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.index'),
            'Maklumat Tetapan Penilaian' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Item Pemarkahan Aktiviti',
                'route' => route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.edit', $id),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        $subjek = Subjek::find($id);
        $model = PenilaianBerterusan::where('subjek_id', $id)->first();
        $items = PenilaianBerterusanItem::with('components')->where('subjek_id', $id)->get();

        return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'buttons', 'subjek', 'items'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $title = 'Tetapan Penilaian';
            $action = route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.store_item');
            $page_title = 'Maklumat Tetapan Penilaian';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan' => false,
                'Tetapan Penilaian Berterusan' => route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.index'),
                'Maklumat Tetapan Penilaian' => route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.show', $id),
                'Tambah Item Pemarkahan Aktiviti' => false,
            ];

            $subjek_id = $id;
            $penilaian_berterusan_id = PenilaianBerterusan::where('subjek_id', $id)->first();

            return view($this->baseView.'create_item', compact('title', 'breadcrumbs', 'page_title', 'action', 'penilaian_berterusan_id', 'subjek_id'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $component_exist = PenilaianBerterusanComponent::where('penilaian_berterusan_item_id', $id)->count();

            if ($component_exist != 0) {
                PenilaianBerterusanComponent::where('penilaian_berterusan_item_id', $id)->delete();
            }

            PenilaianBerterusanItem::with('components')->find($id)->delete();

            Alert::toast('Maklumat Berjaya dihapuskan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function storeItem(Request $request)
    {

        try {
            $item = new PenilaianBerterusanItem();
            $item->subjek_id = $request->subjek_id;
            $item->item = $request->nama_item;
            $item->peratus_markah = $request->peratus_item;
            $item->save();

            foreach ($request->data as $data) {
                if (! empty($data['name']) && ! empty($data['mark'])) {
                    $component = new PenilaianBerterusanComponent();
                    $component->subjek_id = $request->subjek_id;
                    $component->penilaian_berterusan_item_id = $item->id;
                    $component->name = $data['name'];
                    $component->peratus_markah = $data['mark'];
                    $component->save();
                }
            }

            Alert::toast('Maklumat Tetapan Penilaian berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.show', $request->subjek_id);

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
