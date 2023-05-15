<div class="row white-box">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12" style="text-align: center; margin-top:280px; margin-bottom:100px;">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::size(400)->generate( $route )) }} ">
                {{-- use when redirect has been confirmed --}}
                {{-- <img src="data:image/png;base64, {{ base64_encode(QrCode::size(500)->generate( URL::to($data->merchant_id ))) }} "> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="text-align: center;">
                <h3 class="text-weight-bold" style="font-family: Arial, Helvetica, sans-serif; text-transform: uppercase; font-size:30px;" >Subjek : {{ $subjek->nama ?? '' }}</h3>
                <br>
                <p style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">Generated At : {{ $generated_at ??  null }}</p>
            </div>
        </div>
    </div>
</div>