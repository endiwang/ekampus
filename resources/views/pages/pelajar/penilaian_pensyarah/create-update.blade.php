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
                        <p class="text-center fw-bold"> 
                            BORANG PENILAIAN <br/>
                            PENGAJARAN DAN PEMBELAJARAN <br/>
                            DARUL QURAN <br/>
                            JABATAN KEMAJUAN ISLAM MALAYSIA
                        </p>
                        <hr>
                        <p>
                            Sebagai sebahagian proses mengesan kualiti pendidikan, Darul Quran ingin mendapatkan maklumbalas pelajar 
                            mengenai pensyarah yang terlibat dalam proses pengajaran dan pembelajaran. Anda diminta melengkapkan soal selidik ini. 
                            Sila jawab dengan jujur.
                        </p>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <p class="fw-bold">Jantina :</p>
                            </div>
                            <div class="col-md-3">
                                @if($student_detail->jantina == 'L')
                                    Lelaki
                                @else
                                    Perempuan
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="fw-bold">Semester :</p>
                            </div>
                            <div class="col-md-3">
                                {{ $student_detail->semester ?? null }}
                            </div>
                            <div class="col-md-3">
                                <p class="fw-bold">Kelas :</p>
                            </div>
                            <div class="col-md-3">
                               {{ $student_detail->kelas->nama ?? null }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="fw-bold">Kod Subjek :</p>
                            </div>
                            <div class="col-md-3">
                                {{ $subjek->kod_subjek ?? null }}
                            </div>
                            <div class="col-md-3">
                                <p class="fw-bold">Nama Subjek :</p>
                            </div>
                            <div class="col-md-3">
                               {{ $subjek->nama ?? null }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="fw-bold">Pensyarah :</p>
                            </div>
                            <div class="col-md-3">
                                {{ $subjek_detail->staff->nama ?? null }}
                            </div>
                            
                        </div>

                        <p>Bagi setiap kenyataan di bawah, sila tandakan jawapan anda mengikut skala berikut:</p>
                        <table class="table table-rounded table-striped border gs-0 gy-3 mb-5">
                            <!--begin::Table head-->
                            <tbody class="border">
                                <tr class="fw-bold border-bottom-0">
                                    @foreach ($ratings as $rating)
                                        <td width="15%" class="text-center p-5">
                                            <p class="mb-0"> 
                                                {{ $rating->description }} : {{ $rating->order }}
                                            </p>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0" width="100%">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                        <th class="p-0 pb-3 text-start" width="50%">KENYATAAN</th>
                                        <th class="p-0 pb-3 text-center" width="5%">SB</th>
                                        <th class="p-0 pb-3 text-center" width="5%">B</th>
                                        <th class="p-0 pb-3 text-center" width="5%">S</th>
                                        <th class="p-0 pb-3 text-center" width="5%">TM</th>
                                        <th class="p-0 pb-3 text-center" width="5%">STM</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach ($datas as $question)
                                        @if(array_key_exists($question->id, $answers))
                                            @php
                                                $value = $answers[$question->id];
                                            @endphp
                                        @endif
                                        <tr>
                                            <td >
                                                {!! $question->description !!}
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" name="rating[{{$question->id}}]" @if($value == '5') checked @endif value="5" />
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" name="rating[{{$question->id}}]" @if($value == '4') checked @endif value="4" />
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" name="rating[{{$question->id}}]" @if($value == '3') checked @endif value="3" />
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" name="rating[{{$question->id}}]" @if($value == '2') checked @endif value="2" />
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" name="rating[{{$question->id}}]" @if($value == '1') checked @endif value="1" />
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <!--end::Table body-->
                            </table>

                            <input type="hidden"name="subjek_id" value="{{ $subjek->id ?? null }}">
                            <input type="hidden"name="kelas_id" value="{{ $student_detail->kelas_id ?? null }}">
                            <input type="hidden"name="student_id" value="{{ $student_detail->user_id ?? null }}">

                            <hr>
                            <div class="row fv-row mb-2">
                                <div class="col-md-12">
                                    {{ Form::label('comment', 'Cadangan/Komen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-12">
                                    <div class="w-100">
                                        <textarea class="form-control" id="tinymce" name="comment">{{ $comment->comment ?? old('comment') }}</textarea>
                                    </div>
                                </div> 
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pelajar.penilaian_pensyarah.index') }}" class="btn btn-sm btn-light">Batal</a>
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

@push('scripts')
<script>
    tinymce.init({
        selector: 'textarea#tinymce',
        height: 300
    });

</script>

@endpush
