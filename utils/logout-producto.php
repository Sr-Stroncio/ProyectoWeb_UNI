<?php

session_start();

require_once __DIR__ . "/rutas.php";

unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_email']);
unset($_SESSION['usuario_rol']);
unset($_SESSION['usuario_nombre']);
unset($_SESSION['usuario_nombre_completo']);

header('Location: ' . $base_url . 'pages/log-in-producto.php');
exit;