<?php

/*
|--------------------------------------------------------------------------
| Datos personales del portafolio
|--------------------------------------------------------------------------
|
| Los canales de contacto en null no se muestran en la página.
|
*/

return [

    'nombre' => 'Carlos José Novoa Reyes',

    'nombre_corto' => 'Carlos Novoa',

    'rol' => 'Ingeniero de Sistemas y desarrollador full stack Laravel',

    // Ruta dentro de public/, por ejemplo 'img/carlos.webp'.
    'foto' => null,

    'contacto' => [
        'correo' => 'carlosjnovoar@gmail.com',
        // Número con código de país, solo dígitos (51 = Perú).
        'whatsapp' => '51910318185',
        'linkedin' => null,
        'github' => null,
    ],

    'stack' => [
        'Backend' => ['PHP', 'Laravel', 'APIs REST'],
        'Frontend' => ['Blade', 'JavaScript', 'Tailwind CSS', 'Vite'],
        'Bases de datos' => ['MySQL', 'SQLite'],
        'Herramientas' => ['Git', 'Composer', 'XAMPP'],
    ],

];
