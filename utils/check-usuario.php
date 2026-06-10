<?php

session_start();


function comprobarUsuario($rol_permitido)
{

    if (!isset($_SESSION['usuario_id'])) {

        header('Location: ' . $base_url . 'pages/log-in-producto.php');
        exit;
    }

    if ($_SESSION['usuario_rol'] !== $rol_permitido) {

        header('Location: ' . $base_url . 'pages/log-in-producto.php');
        exit;
    }
}
