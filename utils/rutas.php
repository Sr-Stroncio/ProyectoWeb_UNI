<?php

// archivo para que las rutas le funcionen a Dani y al mismo tiempo que funcionen en el servidor
// (el comentario va dentro de php porque si no se imprime antes de los header y rompe las redirecciones)

$ruta_script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);

$pos_src = strpos($ruta_script, '/src/');

if ($pos_src !== false) {
    $base_url = substr($ruta_script, 0, $pos_src + 5);
} else {
    $base_url = '/';
}
