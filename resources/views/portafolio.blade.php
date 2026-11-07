<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#1E1E1E">

        <title>{{ $perfil['nombre'] }} | Desarrollador full stack Laravel</title>
        <meta name="description" content="{{ $perfil['rol'] }}. Construyo sistemas de gestión comercial a la medida: ventas, inventario, facturación y reportes.">
        <meta property="og:title" content="{{ $perfil['nombre'] }}">
        <meta property="og:description" content="{{ $perfil['rol'] }}, especializado en sistemas de gestión comercial.">
        <meta property="og:type" content="website">

        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|jetbrains-mono:400&display=swap" rel="stylesheet">

        {{-- Con JavaScript activo, los elementos con data-aparecer esperan a entrar en pantalla.
             "con-3d" se decide antes de pintar para no mostrar el ticket 2D y luego cambiarlo:
             solo equipos con WebGL2, sin ahorro de datos, sin "reducir movimiento" y que no sean de gama baja. --}}
        <script>
            (() => {
                const html = document.documentElement;
                html.classList.add('js');
                try {
                    const n = navigator;
                    const gamaBaja = (n.deviceMemory && n.deviceMemory < 4) || (n.hardwareConcurrency && n.hardwareConcurrency < 4) || n.connection?.saveData;
                    const reducido = matchMedia('(prefers-reduced-motion: reduce)').matches;
                    const gl = document.createElement('canvas').getContext('webgl2');
                    gl?.getExtension('WEBGL_lose_context')?.loseContext();
                    if (gl && !gamaBaja && !reducido) html.classList.add('con-3d');
                } catch (error) {}
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-carbon font-sans text-white antialiased">
        <a href="#portada" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-lg focus:bg-acento focus:px-4 focus:py-2 focus:text-carbon">
            Saltar al contenido
        </a>

        @include('secciones.encabezado')

        <main>
            @include('secciones.portada')
            @include('secciones.lo-que-hago')
            @include('secciones.proyectos')
            @include('secciones.stack')
            @include('secciones.sobre-mi')
            @include('secciones.contacto')
        </main>

        @include('secciones.pie')
    </body>
</html>
