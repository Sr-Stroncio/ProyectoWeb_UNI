<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$id = $_POST['id'] !== '' ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo']);
$desc = trim($_POST['desc']);
$asig_nombre = $_POST['asig'];
$tipo_form = $_POST['tipo'];

$id_autor = (int)$_SESSION['usuario_id'];

// se decide el tipo y la asignatura
if ($tipo_form === 'general') {
    $tipo = 'global';
    $id_asignatura = null;
} else {
    $tipo = 'asignatura';

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
}

if ($id > 0) {
    // se actualiza el anuncio existente
    $stmt = mysqli_prepare($conexion, "UPDATE Anuncio SET Titulo = ?, Contenido = ?, ID_asignatura = ?, Tipo = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "ssisi", $titulo, $desc, $id_asignatura, $tipo, $id);
    mysqli_stmt_execute($stmt);
} else {
    // se crea un nuevo anuncio
    $stmt = mysqli_prepare($conexion, "INSERT INTO Anuncio (ID_autor, ID_asignatura, Titulo, Contenido, Tipo) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisss", $id_autor, $id_asignatura, $titulo, $desc, $tipo);
    mysqli_stmt_execute($stmt);
    echo mysqli_insert_id($conexion);
}
