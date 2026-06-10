<?php
session_start();
require_once '../database/conexion.php';
require_once '../utils/rutas.php';
include '../utils/check-usuario.php';
comprobarUsuario('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos');
    exit;
}

$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($id <= 0 || $nombre == '' || $email == '') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos&id=' . $id);
    exit;
}

$stmt = $conexion->prepare("UPDATE Usuario SET Nombre = ?, Apellido = ?, Email = ? WHERE ID = ?");
$stmt->bind_param("sssi", $nombre, $apellido, $email, $id);
$stmt->execute();
$stmt->close();

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos&id=' . $id);
exit;
