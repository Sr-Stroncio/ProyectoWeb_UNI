<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$id = $_POST['id'] !== '' ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo']);
$asig_codigo = $_POST['asig'];

$id_profesor = (int)$_SESSION['usuario_id'];

if ($titulo === '') exit;

// se busca el id de la asignatura por el codigo
if ($asig_codigo === 'prog') {
    $busqueda = '%Programación%';
} elseif ($asig_codigo === 'bd') {
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
    // se renombra el examen
    $stmt = mysqli_prepare($conexion, "UPDATE Examen SET Titulo = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "si", $titulo, $id);
    mysqli_stmt_execute($stmt);
} else {
    // se crea un nuevo examen
    $stmt = mysqli_prepare($conexion, "INSERT INTO Examen (ID_asignatura, ID_profesor, Titulo, Fecha_examen) VALUES (?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "iis", $id_asignatura, $id_profesor, $titulo);
    mysqli_stmt_execute($stmt);
    echo mysqli_insert_id($conexion);
}
