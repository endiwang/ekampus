@php
    if(!isset($status)) {
        $status = false;
    }
    if(!isset($yesLabel)) {
        $yesLabel = 'Ya';
    }

    if(!isset($noLabel)) {
        $noLabel = 'Tidak';
    }

    if(!isset($yesClass)) {
        $yesClass = 'text-bg-success text-white';
    }

    if(!isset($noClass)) {
        $noClass = 'text-bg-danger text-white';
    }

    $label = $status ? $yesLabel : $noLabel;
    $class = $status ? $yesClass : $noClass;
@endphp
<span class="badge {{ $class }}">{{ $label }}</span>
