<?php

namespace App\Http\Controllers\Pengurusan\HEP\Kaunseling;

use App\Http\Controllers\Controller;
use App\Models\Kaunseling;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KaunselingDatatableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $query = Kaunseling::query();

        $query
            ->when(
                auth()->user()->hasRole('pelajar'),
                fn ($query) => $query->where('user_id', auth()->user()->id)
            )->when(
                ! empty($request->keyword),
                fn ($query) => $query->search($request->keyword)
            )->when(
                ! empty($request->status),
                fn ($query) => $query->where('status', $request->status)
            );

        return DataTables::make($query)
            ->addIndexColumn()
            ->addColumn('tarikh_permohonan', function ($data) {
                return view('partials.date', ['date' => $data->tarikh_permohonan])->render();
            })
            ->addColumn('created_at', function ($data) {
                return view('partials.date', ['date' => $data->created_at, 'format' => 'Y-m-d H:i:s'])->render();
            })
            ->addColumn('status', function ($data) {
                return view('pages.pengurusan.hep.kaunseling.partials.datatable-status', compact('data'))->render();
            })
            ->addColumn('action', function ($data) {
                return view('pages.pengurusan.hep.kaunseling.partials.datatable-action', compact('data'))->render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
