// Carrusel de capturas de una card de proyecto. La pista usa scroll-snap (se desliza con el dedo);
// las flechas y los puntos solo la desplazan y marcan en qué captura va.
export function iniciarCarruselTarjeta(carrusel) {
    const pista = carrusel.querySelector('[data-carrusel-pista]');
    const puntos = [...carrusel.querySelectorAll('[data-carrusel-punto]')];
    const total = pista.children.length;
    const suave = () => (window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth');

    const actual = () => Math.round(pista.scrollLeft / pista.clientWidth);

    const irA = (indice) => {
        const destino = (indice + total) % total;
        pista.scrollTo({ left: destino * pista.clientWidth, behavior: suave() });
    };

    const marcar = () => {
        const indice = actual();
        puntos.forEach((punto, i) => {
            if (i === indice) punto.setAttribute('aria-current', 'true');
            else punto.removeAttribute('aria-current');
        });
    };

    let pendiente = false;
    pista.addEventListener('scroll', () => {
        if (pendiente) return;
        pendiente = true;
        requestAnimationFrame(() => {
            pendiente = false;
            marcar();
        });
    }, { passive: true });

    carrusel.querySelector('[data-carrusel-anterior]').addEventListener('click', () => irA(actual() - 1));
    carrusel.querySelector('[data-carrusel-siguiente]').addEventListener('click', () => irA(actual() + 1));
    puntos.forEach((punto) => punto.addEventListener('click', () => irA(Number(punto.dataset.carruselPunto))));
    pista.addEventListener('keydown', (evento) => {
        if (evento.key === 'ArrowLeft') { evento.preventDefault(); irA(actual() - 1); }
        if (evento.key === 'ArrowRight') { evento.preventDefault(); irA(actual() + 1); }
    });
}
