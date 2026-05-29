<?php
session_start();
require_once '../database/conexion.php';
include '../utils/check-usuario.php';
comprobarUsuario('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /pages/dashboard-admin.php?seccion=alumnos');
    exit;
}

$id_alumno = intval($_POST['id_alumno'] ?? 0);
$asignaturas = $_POST['asignaturas'] ?? [];

if ($id_alumno <= 0) {
    header('Location: /pages/dashboard-admin.php?seccion=alumnos');
    exit;
}

// borra todas las asignaturas actuales
$stmt = $conexion->prepare("DELETE FROM Alumno_Asignatura WHERE ID_alumno = ?");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$stmt->close();

// inserta las nuevas
foreach ($asignaturas as $id_asig) {
    $id_asig = intval($id_asig);
    if ($id_asig <= 0) continue;
    $stmt = $conexion->prepare("INSERT IGNORE INTO Alumno_Asignatura (ID_alumno, ID_asignatura) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_alumno, $id_asig);
    $stmt->execute();
    $stmt->close();
}

header('Location: /pages/dashboard-admin.php?seccion=alumnos&id=' . $id_alumno);
exit;
