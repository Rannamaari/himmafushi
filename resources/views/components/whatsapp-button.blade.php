@props(['url', 'label' => 'WhatsApp'])
@if($url)<a class="button button-whatsapp" href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>@endif
