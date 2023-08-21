<table class="table table-bordered table-condensed table-striped">
    <tr>
        <td style="width:15% !important;">@lang('No. Permohonan')</td>
        <td>
            {{ $kaunseling->no_permohonan }}
        </td>
    </tr>
    <tr>
        <td style="width:15% !important;">@lang('Tarikh Permohonan')</td>
        <td>
            {{ $kaunseling->tarikh_permohonan->format('d/m/Y') }}
        </td>
    </tr>
    <tr>
        <td style="width:15% !important;">@lang('Status Permohonan')</td>
        <td>
            {{ $kaunseling->status_label }}
        </td>
    </tr>
</table>
