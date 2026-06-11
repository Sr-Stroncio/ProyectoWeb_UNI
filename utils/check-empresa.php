<?php

// Si no hay empresa iniciada, vuelve al login de empresa
if (!isset($_SESSION['empresa_usuario'])) {
    header('Location: ' . $base_url . 'pages/log-in-app.php');
    exit;
}
?>
