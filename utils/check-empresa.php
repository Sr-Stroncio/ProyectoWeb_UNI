<?php
session_start();

// Si no hay empresa iniciada, vuelve al login de empresa
if (!isset($_SESSION['empresa_usuario'])) {
    header('Location: /pages/log-in-app.php');
    exit;
}
?>
