<?php

namespace App\Http\Controllers\Alumni\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPindahJamKredit;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanPindahJamKreditController extends Controller
{
    public function index(Builder $builder)
    {
        try {
            $title = 'Permohonan Permindahan Jam Kredit';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Permindahan Jam Kredit' => false,
            ];

            $buttons = [
                [
                    'title' => 'Permohonan Baru',
                    'route' => route('alumni.permohonan.pindah_jam_kredit.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PermohonanPindahJamKredit::where('user_id', auth()->user()->id);
                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge badge-primary">Dihantar</span>';

                            case 1:
                                return '<span class="badge badge-success">Selesai</span>';

                            case 2:
                                return '<span class="badge badge-danger">Ditolak</span>';
                        }
                    })
                    ->addColumn('created_at', function ($data) {
                        return date('d/m/Y', strtotime($data->created_at));
                    })
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama;
                    })
                    ->addColumn('sesi', function ($data) {
                        return !empty($data->sesi) ? $data->sesi->nama : '-';
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="' . route('alumni.permohonan.pindah_jam_kredit.show', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove(' . $data->id . ')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-' . $data->id . '" action="' . route('alumni.permohonan.pindah_jam_kredit.destroy', $data->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['sesi', 'kursus', 'created_at', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.alumni.permohonan.pindah_jam_kredit.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function create()
    {
        $title = 'Pindah Jam Kredit';
        $action = route('alumni.permohonan.pindah_jam_kredit.store');
        $page_title = 'Permohonan Pemindahan Jam Kredit';
        $breadcrumbs = [
            'Alumni' => false,
            'Permohonan' => false,
            'Pindah Jam Kredit' => route('alumni.permohonan.pindah_jam_kredit.index'),
            'Permohonan Pemindahan Jam Kredit' => false,
        ];
        // Get current user
        $user = auth()->user();

        // Get current user's pelajar
        $pelajars = $user->pelajar;

        // The [pelajar] is referring to the same person, but with different [kursus/syukbah/sesi] taken.
        // Extract the information into a array of sesis, syukbahs, and kursuses.
        $kursuses = [];
        $syukbahs = [];
        $sesis = [];

        // Loop through pelajar's kursuses and populate $kursuses, $syukbahs, and $sesis arrays
        foreach ($pelajars as $pelajar) {
            if ($pelajar->kursus) {
                $kursuses[] = $pelajar->kursus;
            }

            if ($pelajar->syukbah) {
                $syukbahs[] = $pelajar->syukbah;
            }

            if ($pelajar->sesi) {
                $sesis[] = $pelajar->sesi;
            }
        }

        return view('pages.alumni.permohonan.pindah_jam_kredit.create', compact('title', 'action', 'page_title', 'breadcrumbs', 'pelajar', 'kursuses', 'syukbahs', 'sesis'));
    }

    public function store(Request $request)
    {
        $permohonan = new PermohonanPindahJamKredit();
        $permohonan->user_id = auth()->user()->id;
        $permohonan->pelajar_id = $request->pelajar_id;
        $permohonan->kursus_id = $request->kursus_id;
        $permohonan->sesi_id = $request->sesi_id;
        $permohonan->syukbah_id = $request->syukbah_id;
        $permohonan->save();

        Alert::toast('Permohonan Pindah Jam Kredit Berjaya Dihantar', 'success');

        return redirect()->route('alumni.permohonan.pindah_jam_kredit.index');
    }

    public function show($id)
    {
        try {
            $title = 'Pindah Jam Kredit';
            $page_title = 'Permohonan Pemindahan Jam Kredit';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Pindah Jam Kredit' => route('alumni.permohonan.pindah_jam_kredit.index'),
                'Permohonan Pemindahan Jam Kredit' => false,
            ];
            $data = PermohonanPindahJamKredit::find($id);

            return view('pages.alumni.permohonan.pindah_jam_kredit.show', compact('title', 'breadcrumbs', 'page_title', 'data'));
        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $permohonan = PermohonanPindahJamKredit::find($id);
            $permohonan->delete();

            Alert::toast('Permohonan Pindah Jam Kredit Berjaya Dipadam', 'success');

            return redirect()->route('alumni.permohonan.pindah_jam_kredit.index');
        } catch (Exception $e) {
            report($e);

            Alert::toast('Maaf! Terdapat ralat berlaku', 'error');

            return redirect()->back();
        }
    }
}
