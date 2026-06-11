<?php
session_start();
require_once '../database/conexion.php';
require_once '../utils/rutas.php';
include '../utils/check-usuario.php';
comprobarUsuario('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=profesores');
    exit;
}

$id_profesor = intval($_POST['id_profesor'] ?? 0);
$asignaturas = $_POST['asignaturas'] ?? [];

if ($id_profesor <= 0) {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=profesores');
    exit;
}

$stmt = $conexion->prepare("DELETE FROM Profesor_Asignatura WHERE ID_profesor = ?");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$stmt->close();

foreach ($asignaturas as $id_asig) {
    $id_asig = intval($id_asig);
    if ($id_asig <= 0) continue;
    $stmt = $conexion->prepare("INSERT IGNORE INTO Profesor_Asignatura (ID_profesor, ID_asignatura) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_profesor, $id_asig);
    $stmt->execute();
    $stmt->close();
}

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=profesores&id=' . $id_profesor);
exit;
