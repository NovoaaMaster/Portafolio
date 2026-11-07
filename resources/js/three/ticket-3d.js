import * as THREE from 'three';
import { RoundedBoxGeometry } from 'three/addons/geometries/RoundedBoxGeometry.js';

const AZUL = 0x3b82f6;
const ANCHO_PAPEL = 1.7;
const ANCHO_DISENO = 300; // el ticket se diseña en 300 px de ancho y se dibuja al doble

// Dibuja el ticket en un canvas. El borde superior va en zigzag, como papel cortado.
function dibujarTicket(canvas, datos) {
    const ctx = canvas.getContext('2d');
    const escala = canvas.width / ANCHO_DISENO;
    const alto = canvas.height / escala;
    const fuente = (peso, tamano) => `${peso} ${tamano}px Poppins, system-ui, sans-serif`;

    ctx.setTransform(escala, 0, 0, escala, 0, 0);
    ctx.clearRect(0, 0, ANCHO_DISENO, alto);

    const diente = 10;
    ctx.fillStyle = '#fafafa';
    ctx.beginPath();
    ctx.moveTo(0, diente);
    for (let x = 0; x < ANCHO_DISENO; x += diente * 2) {
        ctx.lineTo(x + diente, 0);
        ctx.lineTo(x + diente * 2, diente);
    }
    ctx.lineTo(ANCHO_DISENO, alto);
    ctx.lineTo(0, alto);
    ctx.closePath();
    ctx.fill();

    const centro = ANCHO_DISENO / 2;
    const texto = (contenido, x, y, { peso = 400, tamano = 13, color = '#1e1e1e', alinear = 'left' } = {}) => {
        ctx.font = fuente(peso, tamano);
        ctx.fillStyle = color;
        ctx.textAlign = alinear;
        ctx.fillText(contenido, x, y);
    };
    const lineaPunteada = (y) => {
        ctx.save();
        ctx.strokeStyle = '#a3a3a3';
        ctx.setLineDash([4, 3]);
        ctx.beginPath();
        ctx.moveTo(24, y);
        ctx.lineTo(ANCHO_DISENO - 24, y);
        ctx.stroke();
        ctx.restore();
    };

    const fecha = new Date().toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    texto(datos.nombre, centro, 58, { peso: 600, tamano: 20, alinear: 'center' });
    texto(datos.subtitulo, centro, 80, { tamano: 13, color: '#525252', alinear: 'center' });
    texto(datos.numero, centro, 110, { tamano: 11, color: '#525252', alinear: 'center' });
    texto(fecha, centro, 126, { tamano: 11, color: '#525252', alinear: 'center' });

    lineaPunteada(148);
    datos.lineas.forEach((linea, i) => {
        const y = 178 + i * 26;
        texto(linea, 28, y, { tamano: 13.5 });
        ctx.save();
        ctx.strokeStyle = '#3b82f6';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.beginPath();
        ctx.moveTo(258, y - 5);
        ctx.lineTo(262, y - 1);
        ctx.lineTo(271, y - 10);
        ctx.stroke();
        ctx.restore();
    });
    const finLineas = 178 + datos.lineas.length * 26 - 8;
    lineaPunteada(finLineas);

    texto(datos.total[0], 28, finLineas + 32, { peso: 600, tamano: 14 });
    texto(datos.total[1], ANCHO_DISENO - 28, finLineas + 32, { peso: 600, tamano: 14, alinear: 'right' });
    texto(datos.gracias, centro, finLineas + 76, { tamano: 12.5, color: '#525252', alinear: 'center' });

    // Código de barras decorativo
    const anchos = [2, 1, 1, 3, 1, 2, 2, 1, 3, 1, 1, 2, 1, 3, 2, 1];
    ctx.fillStyle = '#1e1e1e';
    for (let x = 62, i = 0; x < ANCHO_DISENO - 62; i++) {
        const ancho = anchos[i % anchos.length];
        if (i % 2 === 0) ctx.fillRect(x, finLineas + 90, ancho * 1.5, 38);
        x += ancho * 1.5 + 1.5;
    }
}

// Monta la impresora térmica con el ticket dentro de `container` y devuelve la función de limpieza.
// Reacciona al mouse (se inclina hacia el puntero) y al scroll (se inclina hacia atrás y sale más papel).
export function mount(container) {
    const datos = JSON.parse(container.dataset.ticket);
    const seccion = container.closest('section') ?? document.body;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    Object.assign(renderer.domElement.style, { display: 'block', width: '100%', height: '100%' });
    container.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(30, 1, 0.1, 50);
    camera.position.set(0, 1.5, 9.2);
    camera.lookAt(0, 0.6, 0);

    scene.add(new THREE.HemisphereLight(0xffffff, 0x202020, 1.4));
    const luzPrincipal = new THREE.DirectionalLight(0xffffff, 2.6);
    luzPrincipal.position.set(3, 5, 4);
    scene.add(luzPrincipal);
    // Contraluz azul: dibuja el contorno de la impresora y del papel con el color de acento.
    const contraluz = new THREE.DirectionalLight(AZUL, 6);
    contraluz.position.set(-3, 2.5, -4);
    scene.add(contraluz);

    const grupo = new THREE.Group();
    grupo.rotation.set(0.1, -1.1, 0); // arranca girada y se acomoda sola
    scene.add(grupo);

    // Impresora: la cara superior queda en y = 0 y la ranura está en z = 0.2.
    const cuerpo = new THREE.Mesh(
        new RoundedBoxGeometry(2.4, 1.1, 1.8, 6, 0.16),
        new THREE.MeshStandardMaterial({ color: 0x2a2a2a, roughness: 0.45, metalness: 0.15 }),
    );
    cuerpo.position.y = -0.55;
    grupo.add(cuerpo);

    const ranura = new THREE.Mesh(
        new THREE.BoxGeometry(1.9, 0.02, 0.12),
        new THREE.MeshStandardMaterial({ color: 0x0a0a0a, roughness: 0.9 }),
    );
    ranura.position.set(0, 0.005, 0.2);
    grupo.add(ranura);

    const cuchilla = new THREE.Mesh(
        new THREE.BoxGeometry(2.0, 0.04, 0.05),
        new THREE.MeshStandardMaterial({ color: 0x9a9a9a, roughness: 0.3, metalness: 0.85 }),
    );
    cuchilla.position.set(0, 0.02, 0.3);
    grupo.add(cuchilla);

    const materialLed = new THREE.MeshStandardMaterial({ color: AZUL, emissive: AZUL, emissiveIntensity: 1.5 });
    const led = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.045, 0.03, 20), materialLed);
    led.rotation.x = Math.PI / 2;
    led.position.set(0.85, -0.3, 0.905);
    grupo.add(led);

    const boton = new THREE.Mesh(
        new RoundedBoxGeometry(0.34, 0.14, 0.05, 3, 0.03),
        new THREE.MeshStandardMaterial({ color: 0x3a3a3a, roughness: 0.6 }),
    );
    boton.position.set(0.45, -0.3, 0.9);
    grupo.add(boton);

    // Sombra de contacto suave bajo la impresora (degradado, sin sombras en tiempo real).
    const lienzoSombra = document.createElement('canvas');
    lienzoSombra.width = lienzoSombra.height = 128;
    const ctxSombra = lienzoSombra.getContext('2d');
    const degradado = ctxSombra.createRadialGradient(64, 64, 0, 64, 64, 64);
    degradado.addColorStop(0, 'rgba(0,0,0,0.55)');
    degradado.addColorStop(1, 'rgba(0,0,0,0)');
    ctxSombra.fillStyle = degradado;
    ctxSombra.fillRect(0, 0, 128, 128);
    const sombra = new THREE.Mesh(
        new THREE.PlaneGeometry(4.2, 3.2),
        new THREE.MeshBasicMaterial({ map: new THREE.CanvasTexture(lienzoSombra), transparent: true, depthWrite: false }),
    );
    sombra.rotation.x = -Math.PI / 2;
    sombra.position.y = -1.11;
    grupo.add(sombra);

    // Papel: textura dibujada en canvas sobre un plano con muchas filas para poder curvarlo.
    const lienzo = document.createElement('canvas');
    lienzo.width = 600;
    lienzo.height = 1000;
    dibujarTicket(lienzo, datos);
    const textura = new THREE.CanvasTexture(lienzo);
    textura.colorSpace = THREE.SRGBColorSpace;
    textura.anisotropy = renderer.capabilities.getMaxAnisotropy();
    // Al cargar Poppins se vuelve a dibujar con la tipografía correcta.
    document.fonts?.ready.then(() => {
        dibujarTicket(lienzo, datos);
        textura.needsUpdate = true;
    });

    const largoPapel = ANCHO_PAPEL * (lienzo.height / lienzo.width);
    const geometriaPapel = new THREE.PlaneGeometry(ANCHO_PAPEL, largoPapel, 1, 48);
    geometriaPapel.translate(0, largoPapel / 2, 0);
    const posicionesBase = geometriaPapel.attributes.position.array.slice();

    const papel = new THREE.Group();
    papel.position.z = 0.2;
    papel.add(new THREE.Mesh(
        geometriaPapel,
        new THREE.MeshStandardMaterial({ map: textura, roughness: 0.85, alphaTest: 0.5 }),
    ));
    papel.add(new THREE.Mesh(
        geometriaPapel,
        new THREE.MeshStandardMaterial({ color: 0xececec, roughness: 0.9, side: THREE.BackSide, alphaMap: textura, alphaTest: 0.5 }),
    ));
    grupo.add(papel);

    // Coloca el papel según cuánto salió (avance, de 0 a 1) y lo curva hacia atrás.
    // Lo que queda bajo la ranura está dentro del cuerpo opaco, así que no se ve.
    const actualizarPapel = (avance, curva) => {
        const posiciones = geometriaPapel.attributes.position.array;
        const desplazamiento = avance * largoPapel - largoPapel;
        for (let i = 0; i < posiciones.length; i += 3) {
            const y = posicionesBase[i + 1] + desplazamiento;
            posiciones[i + 1] = y;
            posiciones[i + 2] = y > 0 ? -curva * y * y : 0;
        }
        geometriaPapel.attributes.position.needsUpdate = true;
        geometriaPapel.computeVertexNormals();
    };

    // Mouse: solo en equipos con puntero que puede "flotar" (no en pantallas táctiles).
    const puntero = { x: 0, y: 0 };
    const alMoverPuntero = (evento) => {
        puntero.x = (evento.clientX / window.innerWidth) * 2 - 1;
        puntero.y = (evento.clientY / window.innerHeight) * 2 - 1;
    };
    const conMouse = window.matchMedia('(hover: hover)').matches;
    if (conMouse) window.addEventListener('pointermove', alMoverPuntero, { passive: true });

    const resize = () => {
        const { clientWidth: width, clientHeight: height } = container;
        if (!width || !height) return;
        renderer.setSize(width, height, false);
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
    };
    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(container);
    resize();

    const timer = new THREE.Timer();
    timer.connect(document);
    let primerCuadro = true;

    const tick = (time) => {
        timer.update(time);
        const dt = Math.min(timer.getDelta(), 0.1);
        const t = timer.getElapsed();

        // Impresión: 80 % del ticket sale al cargar, a tirones como una impresora térmica.
        const progreso = THREE.MathUtils.clamp((t - 0.4) / 2.4, 0, 1);
        const escalon = Math.floor(progreso * 36) / 36;
        const impreso = 0.8 * THREE.MathUtils.lerp(escalon, progreso, 0.35);

        // Scroll: de 0 a 1 mientras la portada sale de la pantalla.
        const scroll = THREE.MathUtils.clamp(window.scrollY / seccion.offsetHeight, 0, 1);
        actualizarPapel(impreso + 0.2 * scroll * progreso, 0.05 + 0.08 * scroll);

        const suavizado = 1 - Math.exp(-dt * 4);
        grupo.rotation.y += (-0.45 + puntero.x * 0.35 - grupo.rotation.y) * suavizado;
        grupo.rotation.x += (0.1 + puntero.y * 0.12 + scroll * 0.45 - grupo.rotation.x) * suavizado;
        // Al inclinarse hacia atrás sube un poco, para que la base no se salga del canvas.
        grupo.position.y += (scroll * 0.35 - grupo.position.y) * suavizado;

        // El LED parpadea mientras imprime.
        materialLed.emissiveIntensity = progreso < 1 ? (Math.sin(t * 22) > 0 ? 3 : 0.5) : 1.5;

        renderer.render(scene, camera);
        if (primerCuadro) {
            primerCuadro = false;
            container.classList.add('lista');
        }
    };

    // Solo anima mientras la portada está en pantalla.
    const visibilityObserver = new IntersectionObserver(([entry]) => {
        renderer.setAnimationLoop(entry.isIntersecting ? tick : null);
    });
    visibilityObserver.observe(container);

    return () => {
        renderer.setAnimationLoop(null);
        visibilityObserver.disconnect();
        resizeObserver.disconnect();
        if (conMouse) window.removeEventListener('pointermove', alMoverPuntero);
        timer.dispose();
        scene.traverse((object) => {
            if (!object.isMesh) return;
            object.geometry.dispose();
            for (const material of [].concat(object.material)) {
                for (const value of Object.values(material)) {
                    if (value?.isTexture) value.dispose();
                }
                material.dispose();
            }
        });
        renderer.dispose();
        renderer.domElement.remove();
        container.classList.remove('lista');
    };
}
