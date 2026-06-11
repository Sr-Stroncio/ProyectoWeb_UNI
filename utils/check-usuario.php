<?php

session_start();

require_once __DIR__ . '/rutas.php';

function comprobarUsuario($rol_permitido)
{
    // la variable viene de rutas.php, hace falta global para verla dentro de la funcion
    global $base_url;

    if (!isset($_SESSION['usuario_id'])) {

        header('Location: ' . $base_url . 'pages/log-in-producto.php');
        exit;
    }

    if ($_SESSION['usuario_rol'] !== $rol_permitido) {

        header('Location: ' . $base_url . 'pages/log-in-producto.php');
        exit;
    }
}
