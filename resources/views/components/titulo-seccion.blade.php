@props(['titulo', 'bajada' => null, 'centrado' => false])

<div {{ $attributes->class(['max-w-2xl', 'mx-auto text-center' => $centrado]) }} data-aparecer>
    <h2 class="text-3xl/tight font-semibold sm:text-4xl/tight">{{ $titulo }}</h2>
    @if ($bajada)
        <p class="mt-4 text-base/relaxed text-tenue sm:text-lg/relaxed">{{ $bajada }}</p>
    @endif
</div>
