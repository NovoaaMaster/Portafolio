@php
    $datos = [
        'Formación' => 'Ingeniería de Sistemas',
        'Especialidad' => 'Sistemas de gestión comercial',
        'Enfoque' => 'Full stack con Laravel',
    ];
@endphp

<section id="sobre-mi" class="scroll-mt-16 border-t border-linea">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-20 sm:px-6 sm:py-28 lg:grid-cols-[1fr_1.5fr] lg:px-8">
        <div data-aparecer>
            <h2 class="text-3xl/tight font-semibold sm:text-4xl/tight">Sobre mí</h2>
            @if (! empty($perfil['foto']))
                <img
                    src="{{ asset($perfil['foto']) }}"
                    alt="Foto de {{ $perfil['nombre'] }}"
                    loading="lazy"
                    class="mt-8 aspect-square w-48 rounded-2xl border border-linea object-cover sm:w-56"
                >
            @endif
        </div>

        <div data-aparecer style="--retraso: 120ms">
            <div class="max-w-[62ch] space-y-5 text-base/relaxed text-tenue sm:text-lg/relaxed">
                <p>
                    Soy Ingeniero de Sistemas y desarrollador full stack. Trabajo con Laravel de punta a punta:
                    diseño la base de datos, construyo la lógica del negocio y entrego interfaces que el equipo
                    puede usar sin un manual de por medio.
                </p>
                <p>
                    Me especializo en sistemas de gestión comercial porque ahí el software se nota: cada venta
                    registrada, cada producto con el stock correcto y cada reporte a tiempo es trabajo que alguien
                    deja de hacer a mano.
                </p>
            </div>

            <dl class="mt-10 grid gap-6 border-t border-linea pt-8 sm:grid-cols-3">
                @foreach ($datos as $termino => $valor)
                    <div>
                        <dt class="text-sm text-tenue">{{ $termino }}</dt>
                        <dd class="mt-1 font-medium">{{ $valor }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>
