<html>
    <head>
        @if(!empty($is_download))
        <link href="{{ public_path('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        @else
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        @endif

        <style>
            .A4 {
                background: white;
                width: 21cm;
                height: auto;
                display: block;
                margin: 25px auto;
                /*padding: 10px 25px;
                margin-bottom: 0.5cm;*/
                box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
                /*overflow-y: scroll;*/
                box-sizing: border-box;
                font-size: small;
            }
            @media print
            {
                @page {
                    size: A4; /* DIN A4 standard, Europe */
                    margin:0;
                }
                .A4 {
                    margin: 0;
                    box-shadow: 0 0 0 0;
                }
            }
        </style>
    </head>
    <body>
        <!-- <div style="position:fixed; right: 10px; top: 10px;" class="noprint"><button class="btn m-t-xs m-b-xs btn-default btn-icon" id="printpagebutton" type="button" onclick="printpage()"/><i class="fas fa-print text-dark"></i></button></div> -->
        <div class="A4">
            <div class="card">
                <div class="card-body mx-4">
                    <div class="container">
                        @if(!empty($is_download))
                            <img alt="Logo" src="{{ public_path('assets/media/logos/logo-dq.png') }}"class="app-sidebar-logo-default" />
                        @else 
                            <img alt="Logo" src="{{ asset('assets/media/logos/logo-dq.png') }}"class="app-sidebar-logo-default" />
                        @endif
                        <p class="my-5 mr-5" style="font-size: 30px;">{{ $bil->doc_no }}</p>
                        <div class="row">
                            <ul class="list-unstyled">
                            <li class="text-black">{{ $bil->pelajar_nama }}</li>
                            <li class="text-black mt-1">{{ date('F d Y', strtotime($bil->created_at)) }}</li>
                            </ul>
                            <hr>
                            <div class="col-xl-12">
                                <span>{{ $bil->description }}</span>
                                <span class="float-end">{{ 'RM' . number_format($bil->amaun, 2) }}</span>
                            </div>
                            <hr>
                        </div>
                        <div class="row text-black">

                            <div class="col-xl-12">
                                <p class="float-end fw-bold">Total: {{ 'RM' . number_format($bil->amaun, 2) }}</p>
                            </div>
                            <br>
                            <hr style="border: 2px solid black;">
                        </div>
                        <div class="text-center" style="margin-top: 90px;">
                            <!-- <a><u class="text-info">View in browser</u></a> -->
                            <p>Darul Quran JAKIM.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function printpage() {
                window.print();
            }
        </script>
    </body>
</html>