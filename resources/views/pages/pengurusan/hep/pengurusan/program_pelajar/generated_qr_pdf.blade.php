<html lang="en">
    <head>
        <title>QR Code Kehadiran Pelajar | Program : {{ $program->nama_program ?? '' }}</title>
    </head>
    <body>
        <div class="row white-box">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <h3 class="text-weight-bold" style="font-family: Arial, Helvetica, sans-serif; text-transform: uppercase; font-size:30px;" >QR Code Kehadiran Pelajar</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center; margin-top:100px; margin-bottom:100px;">
                        <img src="data:image/png;base64, {{ base64_encode(QrCode::size(400)->generate( $route )) }} ">
                        {{-- use when redirect has been confirmed --}}
                        {{-- <img src="data:image/png;base64, {{ base64_encode(QrCode::size(500)->generate( URL::to($data->merchant_id ))) }} "> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <h3 class="text-weight-bold" style="font-family: Arial, Helvetica, sans-serif; text-transform: uppercase; font-size:30px;" >Program : {{ $program->nama_program ?? '' }}</h3>
                        <h3 class="text-weight-bold" style="font-family: Arial, Helvetica, sans-serif; text-transform: uppercase; font-size:30px;" >Sesi : #{{ $sesi ?? '' }}</h3>
                        <br>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">Generated At : {{ $generated_at ??  null }}</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
