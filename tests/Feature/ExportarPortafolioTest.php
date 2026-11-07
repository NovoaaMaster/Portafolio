<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ExportarPortafolioTest extends TestCase
{
    private const DESTINO = 'storage/framework/testing/exportacion';

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        File::deleteDirectory(base_path(self::DESTINO));
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(base_path(self::DESTINO));

        parent::tearDown();
    }

    private function exportar(): \Illuminate\Testing\PendingCommand
    {
        return $this->artisan('portafolio:exportar', ['--destino' => self::DESTINO]);
    }

    private function exportado(string $archivo): string
    {
        return base_path(self::DESTINO.'/'.$archivo);
    }

    public function test_exporta_la_pagina_con_rutas_desde_la_raiz(): void
    {
        config(['proyectos' => [[
            'titulo' => 'Sistema Alfa',
            'resumen' => 'Resumen de Sistema Alfa',
            'capturas' => [['imagen' => 'img/uno.webp', 'alt' => 'Uno']],
        ]]]);

        $this->exportar()->assertSuccessful();

        $html = File::get($this->exportado('index.html'));
        $this->assertStringContainsString('id="proyectos"', $html);
        $this->assertStringContainsString('Sistema Alfa', $html);
        $this->assertStringContainsString('src="/img/uno.webp"', $html);
        $this->assertStringNotContainsString('http://localhost', $html);
        $this->assertStringNotContainsString('exportacion.local', $html);
    }

    public function test_copia_los_archivos_publicos_menos_los_de_php(): void
    {
        $this->exportar()->assertSuccessful();

        $this->assertFileExists($this->exportado('favicon.svg'));
        $this->assertDirectoryExists($this->exportado('img'));
        $this->assertFileDoesNotExist($this->exportado('index.php'));
        $this->assertFileDoesNotExist($this->exportado('.htaccess'));
    }

    public function test_puede_volver_a_exportar_sobre_su_propia_carpeta(): void
    {
        $this->exportar()->assertSuccessful();

        $this->exportar()->assertSuccessful();
    }

    public function test_no_borra_una_carpeta_que_no_creo_la_exportacion(): void
    {
        File::ensureDirectoryExists(base_path(self::DESTINO));
        File::put($this->exportado('importante.txt'), 'no me borres');

        $this->exportar()->assertFailed();

        $this->assertFileExists($this->exportado('importante.txt'));
    }

    public function test_no_exporta_mientras_npm_run_dev_esta_activo(): void
    {
        $hot = public_path('hot');
        $creado = ! File::exists($hot);
        if ($creado) {
            File::put($hot, 'http://127.0.0.1:5173');
        }

        try {
            $this->exportar()->assertFailed();
            $this->assertFileDoesNotExist($this->exportado('index.html'));
        } finally {
            if ($creado) {
                File::delete($hot);
            }
        }
    }
}
