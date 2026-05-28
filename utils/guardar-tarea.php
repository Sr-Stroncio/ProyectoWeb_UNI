<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$id = $_POST['id'] !== '' ? (int)$_POST['id'] : 0;
$nombre = trim($_POST['nombre']);
$desc = trim($_POST['desc']);
$asig_nombre = $_POST['asig'];
$cierre = $_POST['cierre'];

$id_profesor = (int)$_SESSION['usuario_id'];

// se busca el id de la asignatura
if ($asig_nombre === 'Programación') {
    $busqueda = '%Programación%';
} elseif ($asig_nombre === 'BD') {
    $busqueda = '%Bases de Datos%';
} else {
    $busqueda = '%HCI%';
}

$stmt_as = mysqli_prepare($conexion, "SELECT ID FROM Asignatura WHERE Nombre LIKE ?");
mysqli_stmt_bind_param($stmt_as, "s", $busqueda);
mysqli_stmt_execute($stmt_as);
$row = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
$id_asignatura = $row ? (int)$row[0] : null;

// la fecha viene como YYYY-MM-DD, se le pone hora 23:59:59
$fecha_limite = $cierre . ' 23:59:59';

if ($id > 0) {
    // se actualiza la tarea existente
    $stmt = mysqli_prepare($conexion, "UPDATE Tarea SET Titulo = ?, Descripcion = ?, ID_asignatura = ?, Fecha_limite = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "ssisi", $nombre, $desc, $id_asignatura, $fecha_limite, $id);
    mysqli_stmt_execute($stmt);
} else {
    // se crea una nueva tarea
    $stmt = mysqli_prepare($conexion, "INSERT INTO Tarea (ID_asignatura, ID_profesor, Titulo, Descripcion, Fecha_limite) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisss", $id_asignatura, $id_profesor, $nombre, $desc, $fecha_limite);
    mysqli_stmt_execute($stmt);
    echo mysqli_insert_id($conexion);
}
