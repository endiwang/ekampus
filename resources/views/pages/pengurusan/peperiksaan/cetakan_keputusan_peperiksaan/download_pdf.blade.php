<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    .report {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .detail {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .detail tr th {
        border: 1px solid black;
        padding: 5px;
    }

    .detail tr td {
        border: 1px solid black;
        padding: 10px;
    }

    .table-detail {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    /* .report tr th {
        border: 1px solid black;
        padding: 5px;
    } */

    /* .report tr td {
        border: 1px solid black;
        padding: 10px;
    } */
</style>

<html>
    <div>
        @foreach ($data as $result)
            <table class="table table-bordered report" width="100%" style="margin-bottom: 15px;">
                <tr style="border: 1px solid black;">
                    <td width="55%">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%" valign="top">Nama<br /></td>
                                <td width="5%" valign="top">:<br /></td>
                                <td width="70%"><? //print ucwords(strtolower($rs->fields['p_nama']));?>
                                    {{ $result->pelajar->nama ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="45%" style="border-left: 1px solid black;">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">Kemasukan</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->pelajar->sesi->nama ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td width="50%">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">No. KP</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->pelajar->no_ic ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style="border-left: 1px solid black;">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">Sesi</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->sesi->nama ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td width="50%">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">Program</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->pelajar->kursus->nama ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style="border-left: 1px solid black;">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">Semester</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    Semester {{ $result->semester ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">No. Matrik</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->pelajar->no_matrik ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style="border-left: 1px solid black;">
                        <table width="100%" class="data">
                            <tr>
                                <td width="25%">Syukbah</td>
                                <td width="5%">:</td>
                                <td width="70%">
                                    {{ $result->pelajar->syukbah->nama ?? null }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-detail" width="100%" style="margin-bottom: 10px;">
                <thead>
                    <tr align="center">
                        <td width="4%" style="border-right:1px solid black;"><b>Bil</b></td>
                        <td width="14%" style="border-right:1px solid black;"><b>Kod</b></td>
                        <td width="37%" style="border-right:1px solid black;"><b>Kursus</b></td>
                        <td width="5%" style="border-right:1px solid black;"><b>Kredit</b></td>
                        <td width="5%" style="border-right:1px solid black;"><b>Mata</b></td>
                        <td width="5%" style="border-right:1px solid black;"><b>Gred</b></td>
                        <td width="5%" style="border-right:1px solid black;" colspan="2"><b>C</b></td>
                        <td width="25%" rowspan="9" style="font-size:11px;">
                            <b>PETUNJUK MATA</b><br />
                            (Al-Quran Syafawi/Tahriri)<br />
                            A = 4.0&nbsp;&nbsp;&nbsp;B+ = 3.5<br />
                            B = 3.0&nbsp;&nbsp;&nbsp;C+ = 2.5<br />
                            C = 2.0&nbsp;&nbsp;&nbsp;F&nbsp;&nbsp; = 0.0<br />
                            <hr />
                            <b>PETUNJUK MATA</b><br />
                            (Selain Al-Quran Syafawi/Tahriri)<br />
                            A = 4.0&nbsp;&nbsp;&nbsp;B+&nbsp; = 3.5<br />
                            B = 3.0&nbsp;&nbsp;&nbsp;C+&nbsp; = 2.5<br />
                            C = 2.0&nbsp;&nbsp;&nbsp;D+&nbsp; = 1.5<br />
                            D = 1.0&nbsp;&nbsp;&nbsp;F&nbsp;&nbsp;&nbsp; = 0.0<br />
                            <hr />
                            <b>NOTA CATATAN C</b><br />
                            <div align="left" style="font-size:11px">
                                <b>XM</b> : Dihalang kerana tidak cukup muqarrar hafazan<br />
                                <b>XK</b> : Dihalang kerana tidak cukup kehadiran<br />
                                <b>M</b>  : Memuaskan<br />
                                <b>TM</b> : Tidak memuaskan<br />
                                <b>TL</b> : Tidak lengkap<br />
                                <b>TD</b> : Tarik diri<br />
                                <b>TH</b> : Tidak hadir tanpa kebenaran<br />
                                <b>TK</b> : Tidak hadir dengan kebenaran atau sakit
                                <b>TP</b> : Tangguh Peperiksaan<br /> 
                            </div>
                        </td>
                    </tr>
                </thead>
                    @php $no = 1 @endphp
                    <tbody>
                        @forelse ($result->pelajarSemesterDetails as $detail)
                            <tr class="detail" align="center" style="border:1px solid black;border-collapse: collapse;">
                                <td style="border-right:1px solid black;">{{ $no++ }}</td>
                                <td style="border-right:1px solid black;">{{ $detail->subjek->kod_subjek ?? null }}</td>
                                <td style="border-right:1px solid black;">{{ $detail->subjek->nama ?? null }}</td>
                                <td style="border-right:1px solid black;">{{ $detail->subjek->kredit ?? null }}</td>
                                <td style="border-right:1px solid black;">{{ number_format($detail->pointer,2) ?? null }}</td>
                                <td style="border-right:1px solid black;">{{ $detail->gred ?? null }}</td>
                                <td ></td>
                                <td style="border-right:1px solid black;"></td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center;">Tiada Maklumat</td>
                        </tr>
                        @endforelse
                    </tbody>
            </table>
        </table>

        <table width="100%" border="1" cellpadding="0" cellspacing="0" class="data">
        	<tr width="100%">
                <td width="100%" colspan="2">
                    <tr width="100%">
                        <td width="40%" align="center">
                        	<img src="{{ asset('assets/media/logos/cop_peperiksaan.jpg') }}" width="110" height="110" border="0" />
                        </td>
                        <td width="60%">
                        	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px">
                            	<tr align="center" height="40px">
                                	<td width="36%">&nbsp;</td>
                                    <td width="22%">Jumlah Mata Kredit</td>
                                    <td width="22%">Jumlah Jam Kredit</td>
                                    <td width="20%">GPA<br />CGPA</td>
                                </tr>
                            	<tr align="center" height="25px">
                                	<td>Semester ini</td>
                                    <td>{{ $result->jumlah_markah ?? '-'}}</td>
                                    <td>{{ $result->jam_kredit_semester ?? '-'}}</td>
                                    <td>{{ $result->png ?? '-'}}</td>
                                </tr>
                                
                            	<tr align="center" height="25px">
                                	<td>Semua Semester</td>
                                    <td>{{ $result->jumlah_markah_keseluruhan?? '-'}}</td>
                                    <td>{{ $result->jam_kredit_keseluruhan ?? '-'}}</td>
                                    <td>{{ $result->pngk ?? '-'}}</td>
                                </tr>
                               
                            	<tr align="center" height="25px">
                                	<td>Keputusan</td>
                                    <td colspan="3"></td>
                                </tr>
                            </table>                        
                        </td>
                    </tr>
                </td>
            </tr>
        	<tr>
                <td width="100%" height="30" valign="middle" style="font-size:11px" colspan="2">&nbsp;&nbsp;
            	DIKELUARKAN PADA : {{ $date ?? null }}<br />
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: -10px; margin-bottom:10px;">
            <tr>
                <td width="100%" height="40" valign="bottom" style="font-size:11px">&nbsp;&nbsp;INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN.</td>
            </tr>
        </table>
        @endforeach

        
    </div>
</html>