@php
    $servicios = [
        [
            'titulo' => 'Sistemas de gestión comercial',
            'texto' => 'Ventas, compras, inventario, clientes y proveedores en un solo sistema, hecho a la medida de cómo opera tu negocio.',
            'icono' => '<path d="M4 9.5V19a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9.5" /><path d="M3 5h18l-1.5 4.5H4.5z" /><path d="M10 20v-5h4v5" />',
        ],
        [
            'titulo' => 'Facturación y reportes',
            'texto' => 'Comprobantes, cierres de caja y reportes que muestran cómo va el negocio sin armar hojas de cálculo a mano.',
            'icono' => '<path d="M6 3h9l3 3v15H6z" /><path d="M9 10h6M9 14h6M9 18h3" />',
        ],
        [
            'titulo' => 'Paneles administrativos',
            'texto' => 'Usuarios, roles y permisos para que cada persona vea y haga solo lo que le corresponde dentro del sistema.',
            'icono' => '<rect x="4" y="4" width="7" height="7" rx="1" /><rect x="13" y="4" width="7" height="7" rx="1" /><rect x="4" y="13" width="7" height="7" rx="1" /><rect x="13" y="13" width="7" height="7" rx="1" />',
        ],
        [
            'titulo' => 'Integraciones y mantenimiento',
            'texto' => 'Conecto tu sistema con otros servicios mediante APIs y mantengo o modernizo aplicaciones Laravel existentes.',
            'icono' => '<circle cx="6" cy="12" r="3" /><circle cx="18" cy="12" r="3" /><path d="M9 12h6" />',
        ],
    ];
@endphp

<section id="lo-que-hago" class="scroll-mt-16 border-t border-linea">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
        <x-titulo-seccion
            titulo="Lo que hago"
            bajada="Desarrollo aplicaciones web completas con Laravel, desde la base de datos hasta la pantalla que usa tu equipo todos los días."
        />

        <ul class="mt-14 grid gap-x-12 gap-y-10 md:grid-cols-2">
            @foreach ($servicios as $servicio)
                <li class="border-t border-linea pt-6" data-aparecer style="--retraso: {{ $loop->index * 90 }}ms">
                    <svg class="size-7 text-acento" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        {!! $servicio['icono'] !!}
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold">{{ $servicio['titulo'] }}</h3>
                    <p class="mt-2 text-base/relaxed text-tenue">{{ $servicio['texto'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
