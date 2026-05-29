<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$id = $_POST['id'] !== '' ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo']);
$desc = trim($_POST['desc']);
$asig_nombre = $_POST['asig'];
$url = trim($_POST['url']);
$estado = $_POST['estado'];

$id_profesor = (int)$_SESSION['usuario_id'];

// se valida el estado
if ($estado !== 'activo' && $estado !== 'inactivo') {
    $estado = 'activo';
}

// se busca el id de la asignatura por nombre
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

if ($id > 0) {
    // se actualiza el recurso existente
    $stmt = mysqli_prepare($conexion, "UPDATE Recurso SET Titulo = ?, Descripcion = ?, ID_asignatura = ?, Archivo_URL = ?, Estado = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "ssissi", $titulo, $desc, $id_asignatura, $url, $estado, $id);
    mysqli_stmt_execute($stmt);
} else {
    // se crea un nuevo recurso
    $stmt = mysqli_prepare($conexion, "INSERT INTO Recurso (ID_asignatura, ID_profesor, Titulo, Descripcion, Estado, Archivo_URL) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iissss", $id_asignatura, $id_profesor, $titulo, $desc, $estado, $url);
    mysqli_stmt_execute($stmt);
    echo mysqli_insert_id($conexion);
}
