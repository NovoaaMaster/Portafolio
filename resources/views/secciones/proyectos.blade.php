<section id="proyectos" class="scroll-mt-16 border-t border-linea">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
        <x-titulo-seccion titulo="Proyectos" bajada="Una selección de trabajos recientes" centrado />

        @if ($proyectos->isEmpty())
            <p class="mt-10 text-center text-tenue" data-aparecer>Pronto agregaré nuevos proyectos.</p>
        @else
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($proyectos as $proyecto)
                    <x-tarjeta-proyecto :proyecto="$proyecto" data-aparecer style="--retraso: {{ ($loop->index % 3) * 90 }}ms" />
                @endforeach
            </div>
        @endif
    </div>
</section>
