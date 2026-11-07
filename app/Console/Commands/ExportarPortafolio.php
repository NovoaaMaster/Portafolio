<?php

namespace App\Console\Commands;

use App\Http\Controllers\PortafolioController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

/** Exporta el portafolio como sitio fijo (index.html + archivos de public/) para hostings sin PHP, como Netlify. */
class ExportarPortafolio extends Command
{
    protected $signature = 'portafolio:exportar {--destino=dist : Carpeta de salida, relativa a la raíz del proyecto}';

    protected $description = 'Genera el portafolio como HTML fijo junto con los archivos de public/';

    /** Raíz temporal para asset(); al quitarla quedan rutas desde la raíz, como /img/foto.webp. */
    private const RAIZ = 'http://exportacion.local';

    /** Va al final del index.html: solo se vacía una carpeta que tenga esta marca. */
    private const MARCA = '<!-- Generado con php artisan portafolio:exportar -->';

    /** Archivos de public/ que solo sirven con PHP o con Vite en desarrollo. */
    private const EXCLUIDOS = ['index.php', '.htaccess', 'hot', 'storage'];

    public function handle(): int
    {
        $destino = base_path($this->option('destino'));

        if (File::exists(public_path('hot'))) {
            $this->error('npm run dev está activo. Detenlo y ejecuta npm run build antes de exportar.');

            return self::FAILURE;
        }

        if ($this->estaDentro($destino, public_path()) || ! $this->puedeVaciar($destino)) {
            $this->error("No exporto en {$destino}: tiene archivos que no vienen de una exportación.");

            return self::FAILURE;
        }

        URL::forceRootUrl(self::RAIZ);
        URL::forceScheme('http');
        $html = str_replace(self::RAIZ.'/', '/', app(PortafolioController::class)()->render());

        File::deleteDirectory($destino);
        File::copyDirectory(public_path(), $destino);
        foreach (self::EXCLUIDOS as $nombre) {
            File::isDirectory("{$destino}/{$nombre}")
                ? File::deleteDirectory("{$destino}/{$nombre}")
                : File::delete("{$destino}/{$nombre}");
        }
        File::put("{$destino}/index.html", $html.PHP_EOL.self::MARCA.PHP_EOL);

        $this->info("Portafolio exportado en {$destino}");

        return self::SUCCESS;
    }

    /** Vacía o no existe, o es una exportación anterior (su index.html tiene la marca). */
    private function puedeVaciar(string $carpeta): bool
    {
        if (! File::isDirectory($carpeta) || File::isEmptyDirectory($carpeta)) {
            return true;
        }

        $indice = "{$carpeta}/index.html";

        return File::isFile($indice) && str_contains(File::get($indice), self::MARCA);
    }

    private function estaDentro(string $ruta, string $carpeta): bool
    {
        $normalizar = fn (string $r) => rtrim(str_replace('\\', '/', $r), '/').'/';

        return str_starts_with($normalizar($ruta), $normalizar($carpeta));
    }
}
