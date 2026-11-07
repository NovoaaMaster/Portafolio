@php
    $enlaces = [
        'lo-que-hago' => 'Lo que hago',
        'proyectos' => 'Proyectos',
        'stack' => 'Stack',
        'sobre-mi' => 'Sobre mí',
        'contacto' => 'Contacto',
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-linea bg-carbon/90 backdrop-blur">
    <nav class="relative mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Principal">
        <a href="#portada" class="font-semibold">{{ $perfil['nombre_corto'] }}</a>

        <button
            type="button"
            class="-mr-2 rounded-lg p-2 text-white md:hidden"
            aria-expanded="false"
            aria-controls="menu-principal"
            data-menu-boton
        >
            <span class="sr-only">Abrir menú</span>
            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>

        <div
            id="menu-principal"
            class="absolute inset-x-0 top-16 hidden border-b border-linea bg-carbon md:static md:block md:border-0 md:bg-transparent"
        >
            <ul class="flex flex-col px-4 py-3 sm:px-6 md:flex-row md:gap-8 md:p-0">
                @foreach ($enlaces as $ancla => $texto)
                    <li>
                        <a href="#{{ $ancla }}" class="block py-3 text-sm font-medium text-tenue transition-colors hover:text-white md:py-0">{{ $texto }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
