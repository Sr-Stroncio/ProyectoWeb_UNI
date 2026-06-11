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

$id_alumno = intval($_POST['id_alumno'] ?? 0);

if ($id_alumno <= 0) {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos');
    exit;
}

// borra el usuario (cascade elimina la fila de Alumno)
$stmt = $conexion->prepare("DELETE FROM Usuario WHERE ID = ? AND Rol = 'alumno'");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$stmt->close();

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos');
exit;
