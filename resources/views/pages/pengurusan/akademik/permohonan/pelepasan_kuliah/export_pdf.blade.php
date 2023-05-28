<style>
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    body {
        padding: 20px;
    }

    .text-bold {
        font-weight: bold;
    }

    .salutation {
        margin-top: 25px
    }

    .motto {
        margin-top: 10px;
    }

    .end {
        margin-top: 15px;
    }

    .signature {
        font-style: italic;
    }

    .copy {
        margin-top:25px;
        font-size: 11px;
    }
</style>

<html>
    <body>
    <table width="100%" class="mb-2">
        <tbody>
            <tr class="text-bold">
                <td align="center">
                    <img src="{{ asset('assets/media/logos/crestmalaysia.gif') }}">
                </td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
            <tr>
                <td width="70%" class="text-bold">
                    <p>
                        MEMO <br/>
                        BAHAGIAN AKADEMIK <br/>
                        DARUL QURAN <br/>
                        JABATAN KEMAJUAN ISLAM MALAYSIA
                    </p>
                </td>
                <td width="30%">
                    <p style="margin-top: 45px;">
                        "KERJA KUAT KERJA PINTAR"
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <hr/>
    <table width="100%" class="text-bold">
        <tbody>
            <tr>
                <td width="10%"></td>
                <td width="25%">Kepada</td>
                <td width="2%">:</td>
                <td width="55%">
                    {{ $datas['data']->pelajar->nama }} <br/>
                    {{ $datas['data']->pelajar->semester->nama ?? null }} <br/>
                    {{ $datas['data']->pelajar->kursus->nama ?? null}}
                </td>
                <td width="8%"></td>
            </tr>
            <tr>
                <td></td>
                <td>Daripada</td>
                <td>:</td>
                <td>Unit Akademik</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Rujukan Kami</td>
                <td>:</td>
                <td>JAKIM/(9.00)5:0028,Jld 28 ( )</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Tarikh</td>
                <td>:</td>
                <td>{{ $datas['date'] ?? null }}</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Perkara</td>
                <td>:</td>
                <td>MAKLUMBALAS PELEPASAN TIDAK MENGHADIRI KELAS / KULIAH</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <hr/>
    <table class="mb-5">
        <tbody>
            <tr>
                <td>{!! $datas['data']->komen ?? null !!}</td>
            </tr>
        </tbody>
    </table>
    <table class="salutation">
        <tbody>
            <tr>
                <td>Sekian</td>
            </tr>
        </tbody>
    </table>
    <table class="motto">
        <tbody>
            <tr>
                <td class="text-bold">"KERJA KUAT KERJA PINTAR"</td>
            </tr>
        </tbody>
    </table>
    <table class="end">
        <tbody>
            <tr>
                <td>
                    Saya yang menurut perintah, <br/>
                    <span class="signature"> {{ $datas['data']->tandatangan_oleh ?? null}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="copy">
        <tbody>
            <tr>
                <td>s.k.</td>
            </tr>
            <tr>
                <td>{{ $datas['data']->salinan_kepada ?? null}}</td>
            </tr>
        </tbody>
    </table>
    </body>
</html>