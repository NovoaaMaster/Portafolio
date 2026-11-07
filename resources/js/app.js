import './bootstrap';
import { iniciarCarruselTarjeta } from './carrusel-tarjeta';

document.querySelectorAll('[data-carrusel-tarjeta]').forEach(iniciarCarruselTarjeta);

// La fecha del ticket usa el reloj del visitante; la del servidor (UTC) puede ir un día adelantada.
document.querySelectorAll('[data-fecha-hoy]').forEach((elemento) => {
    elemento.textContent = new Date().toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
});

// Ticket 3D de la portada: three.js se descarga solo si el equipo puede con él (ver <head>).
// Si algo falla al cargar o al crear la escena, se vuelve al ticket 2D.
const escenaTicket = document.querySelector('[data-three="ticket"]');

if (escenaTicket && document.documentElement.classList.contains('con-3d')) {
    import('./three/ticket-3d.js')
        .then(({ mount }) => mount(escenaTicket))
        .catch(() => document.documentElement.classList.remove('con-3d'));
}

// Aparición suave: cada elemento con data-aparecer se muestra la primera vez que entra en pantalla.
const elementosAparecer = document.querySelectorAll('[data-aparecer]');

if ('IntersectionObserver' in window) {
    const observador = new IntersectionObserver(
        (entradas) => {
            for (const entrada of entradas) {
                if (!entrada.isIntersecting) continue;
                entrada.target.classList.add('es-visible');
                observador.unobserve(entrada.target);
            }
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.1 },
    );

    elementosAparecer.forEach((elemento) => observador.observe(elemento));
} else {
    elementosAparecer.forEach((elemento) => elemento.classList.add('es-visible'));
}

// Menú del encabezado en pantallas pequeñas.
const botonMenu = document.querySelector('[data-menu-boton]');
const menu = document.getElementById('menu-principal');

if (botonMenu && menu) {
    const etiqueta = botonMenu.querySelector('.sr-only');

    const alternarMenu = (abrir) => {
        botonMenu.setAttribute('aria-expanded', String(abrir));
        etiqueta.textContent = abrir ? 'Cerrar menú' : 'Abrir menú';
        menu.classList.toggle('hidden', !abrir);
    };

    botonMenu.addEventListener('click', () => alternarMenu(botonMenu.getAttribute('aria-expanded') !== 'true'));
    menu.addEventListener('click', (evento) => {
        if (evento.target.closest('a')) alternarMenu(false);
    });
    document.addEventListener('keydown', (evento) => {
        if (evento.key === 'Escape' && botonMenu.getAttribute('aria-expanded') === 'true') {
            alternarMenu(false);
            botonMenu.focus();
        }
    });
}
