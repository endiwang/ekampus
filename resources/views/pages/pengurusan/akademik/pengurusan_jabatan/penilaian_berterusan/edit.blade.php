@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" width="100%">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>Item</th> 
                                        <th>Komponen Pemarkahan</th>
                                        <th>Markah</th>                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $item->item ?? null }} ({{ $item->peratus_markah ?? null }}%)
                                        </td>
                                        <td> 
                                            @forelse ($item->components as $component)
                                            @php 
                                                $mark = \App\Models\PenilaianBerterusanMark::select('peratus_markah')->where('student_id', $id)->where('subjek_id', $subjek_id)
                                                ->where('penilaian_berterusan_component_id', $component->id)->first();
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td>{{ $component->name ?? null }} ({{ $component->peratus_markah ?? null }})%</td>
                                                <td >
                                                    <input type="number" class="form form-control" name="marks[{{$component->id}}]" value="{{ $mark->peratus_markah ?? null }}">
                                                </td>
                                            </tr>
                                            @empty
                                                N/A 
                                            @endforelse 
                                        </tr>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <input type="hidden" name="subjek_id" value="{{ $subjek_id }}">
                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                            <input type="hidden" name="pelajar_id" value="{{ $id}}">
                            
                            
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.show', $subjek_id) }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection
