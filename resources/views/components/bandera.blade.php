@props(['pais'])

@php
    // Banderas en SVG: Windows no dibuja los emojis de bandera.
    $banderas = [
        'pe' => ['nombre' => 'Perú', 'svg' => '<rect width="18" height="12" fill="#fff"/><rect width="6" height="12" fill="#d91023"/><rect x="12" width="6" height="12" fill="#d91023"/>'],
    ];
@endphp

@isset($banderas[$pais])
    <svg {{ $attributes->class('inline-block h-3 w-[1.125rem] shrink-0 rounded-[2px]') }} viewBox="0 0 18 12" role="img" aria-label="Bandera de {{ $banderas[$pais]['nombre'] }}">
        <title>Bandera de {{ $banderas[$pais]['nombre'] }}</title>
        {!! $banderas[$pais]['svg'] !!}
    </svg>
@endisset
