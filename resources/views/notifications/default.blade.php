<x-mail::message>
@lang('Hi')!<br>

{{ $message }}

@if(isset($url) && !empty($url) )
<x-mail::button :url="$url">
{{ (isset($url_text) && !empty($url_text)) ? $url_text : __('Klik Di Sini') }}
</x-mail::button>
@emdif

@lang('Terima Kasih'),<br>
{{ config('app.name') }}
</x-mail::message>
