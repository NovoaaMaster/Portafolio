<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortafolioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function proyecto(string $titulo, array $extra = []): array
    {
        return [
            'titulo' => $titulo,
            'resumen' => "Resumen de {$titulo}",
            'tecnologias' => ['Laravel'],
            ...$extra,
        ];
    }

    /** Devuelve el HTML que hay entre dos anclas de sección. */
    private function seccion(string $html, string $desde, string $hasta): string
    {
        $inicio = strpos($html, "id=\"{$desde}\"");
        $fin = strpos($html, "id=\"{$hasta}\"");

        return substr($html, $inicio, $fin - $inicio);
    }

    private function seccionProyectos(): string
    {
        return $this->seccion($this->get('/')->assertOk()->getContent(), 'proyectos', 'stack');
    }

    public function test_muestra_las_secciones_en_orden(): void
    {
        $html = $this->get('/')
            ->assertOk()
            ->assertSeeInOrder([
                'id="portada"',
                'id="lo-que-hago"',
                'id="proyectos"',
                'id="stack"',
                'id="sobre-mi"',
                'id="contacto"',
            ], false)
            ->getContent();

        $this->assertStringNotContainsString('id="proyecto-destacado"', $html);
    }

    public function test_la_portada_tiene_escena_3d_y_ticket_de_respaldo(): void
    {
        $portada = $this->seccion($this->get('/')->getContent(), 'portada', 'lo-que-hago');

        $this->assertStringContainsString('data-three="ticket"', $portada);
        $this->assertStringContainsString('class="ticket-2d', $portada);
        $this->assertStringContainsString('Tu negocio en orden', $portada);
    }

    public function test_cada_proyecto_de_la_configuracion_es_una_card_en_orden(): void
    {
        config(['proyectos' => [
            $this->proyecto('Sistema Alfa'),
            $this->proyecto('Sistema Beta'),
            $this->proyecto('Sistema Gamma'),
        ]]);

        $html = $this->seccionProyectos();

        $this->assertSame(3, substr_count($html, 'data-tarjeta-proyecto'));
        $this->assertMatchesRegularExpression('/Sistema Alfa.*Sistema Beta.*Sistema Gamma/s', $html);
        $this->assertStringContainsString('Resumen de Sistema Beta', $html);
    }

    public function test_card_con_varias_capturas_tiene_carrusel_con_puntos(): void
    {
        config(['proyectos' => [
            $this->proyecto('Sistema Alfa', ['capturas' => [
                ['imagen' => 'img/uno.webp', 'alt' => 'Uno'],
                ['imagen' => 'img/dos.webp', 'alt' => 'Dos'],
            ]]),
        ]]);

        $html = $this->seccionProyectos();

        $this->assertStringContainsString(asset('img/uno.webp'), $html);
        $this->assertStringContainsString(asset('img/dos.webp'), $html);
        $this->assertSame(2, substr_count($html, 'data-carrusel-punto'));
    }

    public function test_card_con_una_sola_captura_no_muestra_controles(): void
    {
        config(['proyectos' => [
            $this->proyecto('Sistema Alfa', ['capturas' => [['imagen' => 'img/uno.webp', 'alt' => 'Uno']]]),
        ]]);

        $html = $this->seccionProyectos();

        $this->assertStringContainsString(asset('img/uno.webp'), $html);
        $this->assertStringNotContainsString('data-carrusel-punto', $html);
        $this->assertStringNotContainsString('data-carrusel-siguiente', $html);
    }

    public function test_card_muestra_fecha_bandera_y_enlace_al_proyecto(): void
    {
        config(['proyectos' => [
            $this->proyecto('Sistema Alfa', [
                'fecha' => 'Oct. 2026',
                'pais' => 'pe',
                'enlace' => 'https://www.ejemplo.com',
            ]),
        ]]);

        $html = $this->seccionProyectos();

        $this->assertStringContainsString('Oct. 2026', $html);
        $this->assertStringContainsString('Bandera de Perú', $html);
        $this->assertStringContainsString('href="https://www.ejemplo.com"', $html);
        $this->assertStringContainsString('Ver proyecto', $html);
        $this->assertStringNotContainsString('Enlace pendiente', $html);
    }

    public function test_card_sin_enlace_avisa_que_esta_pendiente(): void
    {
        config(['proyectos' => [$this->proyecto('Sistema Alfa')]]);

        $this->assertStringContainsString('Enlace pendiente', $this->seccionProyectos());
    }

    public function test_card_sin_enlace_puede_mostrar_su_propia_nota(): void
    {
        config(['proyectos' => [$this->proyecto('Sistema Alfa', ['nota_enlace' => 'Demo en local'])]]);

        $html = $this->seccionProyectos();

        $this->assertStringContainsString('Demo en local', $html);
        $this->assertStringNotContainsString('Enlace pendiente', $html);
    }

    public function test_sin_proyectos_la_pagina_sigue_funcionando(): void
    {
        config(['proyectos' => []]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Pronto agregaré nuevos proyectos.');
    }

    public function test_contacto_tiene_botones_de_whatsapp_y_correo(): void
    {
        config(['portafolio.contacto' => [
            'correo' => 'carlos@ejemplo.com',
            'whatsapp' => '51900000000',
            'linkedin' => null,
            'github' => null,
        ]]);

        $contacto = $this->seccion($this->get('/')->getContent(), 'contacto', 'pie');

        $this->assertStringContainsString('href="https://wa.me/51900000000?text=', $contacto);
        $this->assertStringContainsString('Escríbeme por WhatsApp', $contacto);
        $this->assertStringContainsString('href="mailto:carlos@ejemplo.com"', $contacto);
        $this->assertStringContainsString('Envíame un correo', $contacto);
    }

    public function test_contacto_solo_muestra_los_canales_configurados(): void
    {
        config(['portafolio.contacto' => [
            'correo' => 'carlos@ejemplo.com',
            'whatsapp' => null,
            'linkedin' => 'https://www.linkedin.com/in/ejemplo',
            'github' => null,
        ]]);

        $contacto = $this->seccion($this->get('/')->getContent(), 'contacto', 'pie');

        $this->assertStringContainsString('mailto:carlos@ejemplo.com', $contacto);
        $this->assertStringContainsString('https://www.linkedin.com/in/ejemplo', $contacto);
        $this->assertStringNotContainsString('wa.me', $contacto);
        $this->assertStringNotContainsString('github.com', $contacto);
    }
}
