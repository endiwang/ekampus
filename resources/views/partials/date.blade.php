@php
    if(!isset($format)) {
        $format = 'd/m/Y';
    }

    if(! $date instanceof \Carbon\Carbon) {
        $date = \Carbon\Carbon::parse($date);
    }
@endphp

{{ $date->format($format) }}
