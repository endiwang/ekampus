@php
    $label = $status ? $yesLabel : $noLabel;
    $class = $status ? $yesClass : $noClass;
@endphp
<span class="badge {{ $class }}">{{ $label }}</span>
