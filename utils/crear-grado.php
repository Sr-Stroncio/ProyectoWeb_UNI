<?php
session_start();
require_once '../database/conexion.php';
require_once '../utils/rutas.php';
include '../utils/check-usuario.php';
comprobarUsuario('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=grados');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');

if ($nombre == '') {
    $_SESSION['error'] = 'El nombre del grado es obligatorio.';
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=grados');
    exit;
}

$stmt = $conexion->prepare("INSERT INTO Grado (Nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->close();

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=grados');
exit;
