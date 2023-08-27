@method('PUT')
@csrf
<table class="table table-bordered table-striped">
    <tr>
        <th style="width:20%">Nama Pelajar	</th>
        <th>&nbsp;:&nbsp;</th>
        <td>ZUNAIDDIN BIN IBRAHIM</td>
    </tr>
    <tr>
        <th style="width:20%">Nama Program</th>
        <th>&nbsp;:&nbsp;</th>
        <td>Lorem ipsum dolor sit amet.</td>
    </tr>
    <tr>
        <th style="width:20%">Maklumat Program</th>
        <th>&nbsp;:&nbsp;</th>
        <td>
            {!! nl2br('Ligula integer varius aut tincidunt nam pretium laboriosam nulla delectus, lobortis distinctio dapibus asperiores. Praesent consequuntur, quos tellus, porttitor, dolorem.

Delectus platea occaecat interdum dictum porttitor sociosqu placeat! Minima eaque irure urna eligendi! Ullamcorper proin delectus! Consequat malesuada lorem corporis.') !!}
        </td>
    </tr>    
    <tr>
        <th style="width:20%">Bajet Diperlukan</th>
        <th>&nbsp;:&nbsp;</th>
        <td>400</td>
    </tr>
    <tr>
        <th style="width:20%">Tarikh Permohonan</th>
        <th>&nbsp;:&nbsp;</th>
        <td>2023-08-25</td>
    </tr>
    <tr>
        <th style="width:20%">Kelulusan</th>
        <th>&nbsp;:&nbsp;</th>
        <td>
            
            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                <input class="form-check-input " type="checkbox" value="1" id="kt_flexSwitchCustomDefault_1_1"/>
                <label class="form-check-label" for="kt_flexSwitchCustomDefault_1_1">
                    Lulus
                </label>
            </div>

        </td>
    </tr>
</table>