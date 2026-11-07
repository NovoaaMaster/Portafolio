<?php

/*
|--------------------------------------------------------------------------
| Proyectos del portafolio
|--------------------------------------------------------------------------
|
| Cada bloque es una card de la sección "Proyectos", en este mismo orden.
| Para agregar un proyecto, copia un bloque y edítalo; las vistas no se tocan.
|
| titulo       (obligatorio) Nombre del proyecto.
| resumen      (obligatorio) Una o dos frases: qué problema de negocio resuelve.
| tecnologias  Lista de tecnologías usadas.
| capturas     Lista de ['imagen' => ruta dentro de public/, 'alt' => descripción].
|              Con dos o más, la card muestra un carrusel.
| fecha        Texto corto para la esquina de la captura, por ejemplo 'Oct. 2026'.
| pais         Código del país para la bandera junto al título: 'pe'.
| enlace       URL de "Ver proyecto". En null, la card muestra nota_enlace.
| nota_enlace  Texto cuando no hay enlace, por ejemplo 'Demo en local'. Por defecto: "Enlace pendiente".
|
*/

return [

    [
        'titulo' => 'PCLAP SUPPORT',
        'resumen' => 'Sistema y catálogo web de mi tienda de hardware. La web no muestra el stock real: pone un tope al carrito y los pedidos grandes terminan hablando conmigo por WhatsApp.',
        'tecnologias' => ['Laravel 12', 'PHP 8.2', 'MySQL', 'jQuery', 'Bootstrap'],
        'fecha' => 'Oct. 2026',
        'pais' => 'pe',
        'enlace' => 'https://www.pclap-support.com',
        'capturas' => [
            ['imagen' => 'img/proyectos/pclap/catalogo.webp', 'alt' => 'Catálogo web con productos en oferta'],
            ['imagen' => 'img/proyectos/pclap/producto.webp', 'alt' => 'Detalle de un producto en el catálogo'],
            ['imagen' => 'img/proyectos/pclap/buscar.webp', 'alt' => 'Búsqueda del catálogo con el estado de stock de cada producto'],
            ['imagen' => 'img/proyectos/pclap/panel.webp', 'alt' => 'Panel con ventas del día, pedidos web y compras en camino'],
            ['imagen' => 'img/proyectos/pclap/punto-de-venta.webp', 'alt' => 'Punto de venta con un producto escaneado por número de serie'],
            ['imagen' => 'img/proyectos/pclap/notas-de-venta.webp', 'alt' => 'Nota de venta pendiente: pendiente, pagado o devuelto'],
            ['imagen' => 'img/proyectos/pclap/inventario-series.webp', 'alt' => 'Números de serie de un producto agrupados por proveedor'],
            ['imagen' => 'img/proyectos/pclap/inventario.webp', 'alt' => 'Inventario con el stock real de cada producto'],
            ['imagen' => 'img/proyectos/pclap/compras.webp', 'alt' => 'Compras a proveedores con su estado'],
            ['imagen' => 'img/proyectos/pclap/compra-nueva.webp', 'alt' => 'Formulario para registrar una compra nueva'],
        ],
    ],

    [
        'titulo' => 'PCLAP Finanzas',
        'resumen' => 'Convierte las ventas de PCLAP en boletas, facturas y notas de crédito electrónicas, las envía a SUNAT (entorno de pruebas) y guarda el PDF con QR, el XML y la constancia. Lee PCLAP sin poder modificarlo.',
        'tecnologias' => ['Laravel 12', 'PHP 8.2', 'MySQL', 'Greenter', 'SUNAT UBL 2.1'],
        'fecha' => 'May. 2026',
        'pais' => 'pe',
        'enlace' => null,
        'nota_enlace' => 'Demo en local',
        'capturas' => [
            ['imagen' => 'img/proyectos/finanzas/comprobantes.webp', 'alt' => 'Comprobantes electrónicos aceptados por SUNAT, con su PDF, XML y CDR'],
            ['imagen' => 'img/proyectos/finanzas/vista-previa.webp', 'alt' => 'Vista previa de la boleta antes de enviarla a SUNAT'],
            ['imagen' => 'img/proyectos/finanzas/boleta-pdf.webp', 'alt' => 'Boleta electrónica en PDF con código QR y monto en letras'],
            ['imagen' => 'img/proyectos/finanzas/ventas-por-facturar.webp', 'alt' => 'Ventas de PCLAP que todavía no tienen comprobante electrónico'],
            ['imagen' => 'img/proyectos/finanzas/nota-de-credito.webp', 'alt' => 'Nota de crédito que anula una boleta'],
            ['imagen' => 'img/proyectos/finanzas/panel.webp', 'alt' => 'Panel con ventas por facturar y últimos comprobantes'],
            ['imagen' => 'img/proyectos/finanzas/configuracion.webp', 'alt' => 'Datos del emisor, series y conexión de solo lectura con PCLAP'],
        ],
    ],

    [
        'titulo' => 'PCLAP CRM',
        'resumen' => 'Reúne a los clientes de la tienda y de la web (leídos de PCLAP) y a los prospectos nuevos, con tareas de seguimiento y un embudo de ventas que se ordena arrastrando tarjetas. Las cotizaciones de PCLAP entran solas al embudo.',
        'tecnologias' => ['Laravel 12', 'PHP 8.2', 'MySQL', 'jQuery', 'SortableJS'],
        'fecha' => 'Ene. 2026',
        'pais' => 'pe',
        'enlace' => null,
        'nota_enlace' => 'Demo en local',
        'capturas' => [
            ['imagen' => 'img/proyectos/crm/embudo.webp', 'alt' => 'Embudo de ventas con tarjetas que se arrastran entre etapas'],
            ['imagen' => 'img/proyectos/crm/panel.webp', 'alt' => 'Panel con tareas vencidas, clientes y valor del embudo'],
            ['imagen' => 'img/proyectos/crm/clientes.webp', 'alt' => 'Clientes de PCLAP y prospectos del CRM, con filtros por segmento'],
            ['imagen' => 'img/proyectos/crm/ficha-cliente.webp', 'alt' => 'Ficha de un cliente con su actividad, notas, tareas y oportunidades'],
            ['imagen' => 'img/proyectos/crm/tareas.webp', 'alt' => 'Tareas de seguimiento: vencidas, para hoy y próximas'],
        ],
    ],

];
