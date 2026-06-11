<?php

session_start();

require_once __DIR__ . "/rutas.php";

unset($_SESSION['empresa_usuario']);
unset($_SESSION['empresa_rol']);
unset($_SESSION['empresa_nombre']);

header('Location: ' . $base_url . 'index.php');
exit;