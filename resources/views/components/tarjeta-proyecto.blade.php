@props(['proyecto'])

@php
    $capturas = $proyecto['capturas'] ?? [];
    $varias = count($capturas) > 1;
@endphp

<article {{ $attributes->class('tarjeta-proyecto') }} data-tarjeta-proyecto>
    <div
        class="tarjeta-medios"
        @if ($varias) data-carrusel-tarjeta aria-roledescription="carrusel" aria-label="Capturas de {{ $proyecto['titulo'] }}" @endif
    >
        @if ($capturas)
            {{-- Carrusel con scroll-snap: se desliza con el dedo; flechas y puntos solo con JS. --}}
            <div class="tarjeta-pista" data-carrusel-pista @if ($varias) tabindex="0" @endif>
                @foreach ($capturas as $captura)
                    <img
                        src="{{ asset($captura['imagen']) }}"
                        alt="{{ $captura['alt'] }}"
                        width="1440"
                        height="900"
                        loading="lazy"
                        decoding="async"
                    >
                @endforeach
            </div>
        @else
            {{-- Sin capturas: cuadrícula tipo hoja de cálculo con el nombre del proyecto. --}}
            <div class="visual-vacio flex h-full items-center justify-center p-6" aria-hidden="true">
                <span class="max-w-[16ch] text-center text-base/snug font-semibold text-white/80">{{ $proyecto['titulo'] }}</span>
            </div>
        @endif

        @if (! empty($proyecto['fecha']))
            <span class="tarjeta-fecha">{{ $proyecto['fecha'] }}</span>
        @endif

        @if ($varias)
            <button type="button" class="tarjeta-flecha left-2" data-carrusel-anterior aria-label="Captura anterior">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7" /></svg>
            </button>
            <button type="button" class="tarjeta-flecha right-2" data-carrusel-siguiente aria-label="Captura siguiente">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7" /></svg>
            </button>
            <div class="tarjeta-puntos">
                @foreach ($capturas as $captura)
                    <button
                        type="button"
                        data-carrusel-punto="{{ $loop->index }}"
                        aria-label="Ver captura {{ $loop->iteration }} de {{ count($capturas) }}"
                        @if ($loop->first) aria-current="true" @endif
                    ></button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex grow flex-col p-6">
        <h3 class="flex items-center gap-2 text-lg/snug font-semibold">
            {{ $proyecto['titulo'] }}
            <x-bandera :pais="$proyecto['pais'] ?? null" />
        </h3>
        <p class="mt-3 font-mono text-[0.8125rem]/relaxed text-tenue">{{ $proyecto['resumen'] }}</p>

        @if (! empty($proyecto['tecnologias']))
            <ul class="mt-auto flex flex-wrap gap-2 pt-6" aria-label="Tecnologías">
                @foreach ($proyecto['tecnologias'] as $tecnologia)
                    <li class="tarjeta-etiqueta">{{ $tecnologia }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="border-t border-linea px-6 py-4 font-mono text-sm">
        @if (! empty($proyecto['enlace']))
            <a href="{{ $proyecto['enlace'] }}" target="_blank" rel="noopener" class="tarjeta-enlace">
                Ver proyecto <span aria-hidden="true">↗</span><span class="sr-only"> {{ $proyecto['titulo'] }} (se abre en otra pestaña)</span>
            </a>
        @else
            <span class="text-tenue">{{ $proyecto['nota_enlace'] ?? 'Enlace pendiente' }}</span>
        @endif
    </div>
</article>
