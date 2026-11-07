<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortafolioController extends Controller
{
    public function __invoke(): View
    {
        return view('portafolio', [
            'perfil' => config('portafolio'),
            'proyectos' => collect(config('proyectos', [])),
        ]);
    }
}
