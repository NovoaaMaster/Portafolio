@php
    // Contenido del ticket: lo usan el ticket 2D y el 3D (que lo dibuja en un canvas).
    $datosTicket = [
        'nombre' => $perfil['nombre_corto'],
        'subtitulo' => 'Sistemas de gestión comercial',
        'numero' => 'Ticket N.º 0001',
        'lineas' => ['Punto de venta', 'Control de inventario', 'Facturación', 'Reportes de ventas', 'Clientes y proveedores'],
        'total' => ['Total', 'Tu negocio en orden'],
        'gracias' => '¡Gracias por tu visita!',
    ];
@endphp

<section id="portada" class="scroll-mt-16">
    <div class="mx-auto grid max-w-6xl items-center gap-14 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
        <div>
            <h1 class="text-4xl/tight font-semibold sm:text-5xl/tight lg:text-6xl/[1.1]">{{ $perfil['nombre'] }}</h1>
            <p class="mt-5 text-lg font-medium sm:text-xl">{{ $perfil['rol'] }}</p>
            <p class="mt-6 max-w-xl text-base/relaxed text-tenue sm:text-lg/relaxed">
                Construyo sistemas de gestión comercial a la medida: ventas, inventario, facturación y reportes
                en una sola aplicación web, para que tu negocio trabaje con datos claros y menos tareas manuales.
            </p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a href="#proyectos" class="boton boton-primario">Ver proyectos</a>
                <a href="#contacto" class="boton boton-secundario">Escríbeme</a>
            </div>
        </div>

        {{-- Ticket de venta: resume lo que construyo con el objeto más reconocible de un sistema comercial.
             En equipos capaces se muestra en 3D (impresora térmica); si no, queda este ticket 2D. --}}
        <figure class="mx-auto w-full max-w-sm lg:max-w-md" aria-label="Ticket con los módulos que desarrollo">
            <div
                data-three="ticket"
                data-ticket='@json($datosTicket)'
                class="escena-ticket"
                aria-hidden="true"
            ></div>

            <div class="ticket-2d mx-auto max-w-[19rem]">
                <div class="ticket-ranura" aria-hidden="true"></div>
                <div class="ticket">
                    <div class="ticket-papel px-6 pt-7 pb-10 text-carbon">
                        <div class="text-center">
                            <p class="text-lg font-semibold">{{ $datosTicket['nombre'] }}</p>
                            <p class="text-sm text-neutral-600">{{ $datosTicket['subtitulo'] }}</p>
                            <p class="mt-3 text-xs text-neutral-600 tabular-nums">{{ $datosTicket['numero'] }} <br> <time data-fecha-hoy>{{ now()->format('d/m/Y') }}</time></p>
                        </div>

                        <ul class="mt-5 space-y-2.5 border-y border-dashed border-neutral-400 py-5 text-sm">
                            @foreach ($datosTicket['lineas'] as $linea)
                                <li class="ticket-linea flex items-center justify-between gap-4" style="--i: {{ $loop->index }}">
                                    <span>{{ $linea }}</span>
                                    <svg class="size-4 shrink-0 text-acento" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 8.5l3 3 7-7" />
                                    </svg>
                                </li>
                            @endforeach
                        </ul>

                        <p class="ticket-linea mt-4 flex items-baseline justify-between gap-4 font-semibold" style="--i: {{ count($datosTicket['lineas']) }}">
                            <span>{{ $datosTicket['total'][0] }}</span>
                            <span class="text-right">{{ $datosTicket['total'][1] }}</span>
                        </p>

                        <p class="mt-6 text-center text-sm text-neutral-600">{{ $datosTicket['gracias'] }}</p>
                        <div class="ticket-codigo mx-auto mt-3 h-10 w-44" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </figure>
    </div>
</section>
