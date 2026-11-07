@php
    $contacto = $perfil['contacto'];
    $mensajeWhatsapp = 'Hola Carlos, vi tu portafolio y quiero conversar sobre un proyecto.';
    $redes = array_filter([
        'LinkedIn' => $contacto['linkedin'],
        'GitHub' => $contacto['github'],
    ]);
@endphp

<section id="contacto" class="scroll-mt-16 border-t border-linea">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
        <x-titulo-seccion
            titulo="Contacto"
            bajada="Cuéntame qué necesita tu negocio y te respondo con una propuesta para tu sistema."
        />

        <div class="mt-10 flex flex-wrap gap-3" data-aparecer style="--retraso: 120ms">
            @if ($contacto['whatsapp'])
                <a
                    href="https://wa.me/{{ $contacto['whatsapp'] }}?text={{ rawurlencode($mensajeWhatsapp) }}"
                    target="_blank"
                    rel="noopener"
                    class="boton boton-primario gap-2"
                >
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 20l1.3-3.9A8 8 0 1 1 8 19l-4 1z" />
                    </svg>
                    Escríbeme por WhatsApp<span class="sr-only"> (se abre en otra pestaña)</span>
                </a>
            @endif

            @if ($contacto['correo'])
                <a href="mailto:{{ $contacto['correo'] }}" class="boton boton-secundario gap-2">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <path d="M3.5 6.5l8.5 6.5 8.5-6.5" />
                    </svg>
                    Envíame un correo
                </a>
            @endif
        </div>

        @if ($redes)
            <ul class="mt-6 flex flex-wrap gap-x-8 gap-y-3 text-sm font-semibold">
                @foreach ($redes as $nombre => $url)
                    <li>
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="enlace">
                            {{ $nombre }}<span class="sr-only"> (se abre en otra pestaña)</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
