<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function comprobarUsuario($rol_permitido) {

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /pages/log-in-producto.php');
        exit;
    }

    if ($_SESSION['usuario_rol'] !== $rol_permitido) {
        header('Location: /pages/log-in-producto.php');
        exit;
    }
}

?>