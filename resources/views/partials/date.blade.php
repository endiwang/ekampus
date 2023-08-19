@php
    if(!isset($format)) {
        $format = 'd/m/Y';
    }
@endphp

{{ \Carbon\Carbon::parse($date)->format($format) }}
