<?php
session_start();
require_once '../database/conexion.php';
include '../utils/check-usuario.php';
comprobarUsuario('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /pages/dashboard-admin.php?seccion=profesores');
    exit;
}

$id_profesor = intval($_POST['id_profesor'] ?? 0);

if ($id_profesor <= 0) {
    header('Location: /pages/dashboard-admin.php?seccion=profesores');
    exit;
}

$stmt = $conexion->prepare("DELETE FROM Usuario WHERE ID = ? AND Rol = 'profesor'");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$stmt->close();

header('Location: /pages/dashboard-admin.php?seccion=profesores');
exit;
