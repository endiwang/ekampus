@extends('layouts.auth.main')
@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <style>body { background-image: url('https://selangor.travel/wp-content/uploads/2020/11/Darul_Quran_Tourism_Selangor_Lakeview.jpg'); } [data-theme="dark"] body { background-image: url('https://selangor.travel/wp-content/uploads/2020/11/Darul_Quran_Tourism_Selangor_Lakeview.jpg'); }</style>
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <div class="d-flex flex-center flex-lg-start flex-column">
                {{-- <a href="../../demo1/dist/index.html" class="mb-7">
                    <img alt="Logo" src="assets/media/logos/custom-3.svg" />
                </a> --}}
                <h2 class="text-white fw-normal m-0"></h2>
            </div>
        </div>
        <div class="d-flex flex-center w-lg-50 p-10">
            <div class="card rounded-3 w-md-550px">
                <div class="card-body p-10 p-lg-20">
                    <form class="form w-100" id="kt_sign_in_for" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">Log Masuk</h1>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Mykad/Pasport" name="username" autocomplete="off" class="form-control bg-transparent" />
                        </div>
                        <div class="fv-row mb-3">
                            <input type="password" placeholder="Katalaluan" name="password" autocomplete="off" class="form-control bg-transparent" />
                        </div>
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                            <a href="../../demo1/dist/authentication/layouts/creative/reset-password.html" class="link-primary">Lupa Katalauan ?</a>
                        </div>
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Log Masuk</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
