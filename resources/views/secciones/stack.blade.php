<section id="stack" class="scroll-mt-16 border-t border-linea">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
        <x-titulo-seccion titulo="Stack" bajada="Las herramientas con las que construyo y mantengo cada sistema." />

        <div class="mt-14 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($perfil['stack'] as $grupo => $tecnologias)
                <div class="border-t border-linea pt-6" data-aparecer style="--retraso: {{ $loop->index * 90 }}ms">
                    <h3 class="font-semibold">{{ $grupo }}</h3>
                    <ul class="mt-4 space-y-2 text-tenue">
                        @foreach ($tecnologias as $tecnologia)
                            <li>{{ $tecnologia }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
