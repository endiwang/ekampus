
<table>
    <tr>
        <td><span class="badge badge-{{ data_get($jadualTugasan, 'is_subuh') ? 'success' : 'secondary' }} fs-base">Subuh</span></td>
        <td><span class="badge badge-{{ data_get($jadualTugasan, 'is_zohor') ? 'success' : 'secondary' }} fs-base">Zohor</span></td>
        <td><span class="badge badge-{{ data_get($jadualTugasan, 'is_asar') ? 'success' : 'secondary' }} fs-base">Asar</span></td>
        <td><span class="badge badge-{{ data_get($jadualTugasan, 'is_maghrib') ? 'success' : 'secondary' }} fs-base">Maghrib</span></td>
        <td><span class="badge badge-{{ data_get($jadualTugasan, 'is_isyak') ? 'success' : 'secondary' }} fs-base">Isyak</span></td>
    </tr>
</table>
