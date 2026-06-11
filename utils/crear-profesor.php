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

$nombre   = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email    = trim($_POST['email'] ?? '');
$dni      = trim($_POST['dni'] ?? '');
$id_grado = intval($_POST['id_grado'] ?? 0);

if ($nombre == '' || $email == '') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=profesores');
    exit;
}

// la contraseña la escribe el admin en el formulario, si la deja vacia se pone la de defecto
$password = trim($_POST['password'] ?? '');
if ($password == '') {
    $password = 'profesor123';
}

$stmt = $conexion->prepare("INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password) VALUES ('profesor', ?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $email, $password);
$stmt->execute();
$id_usuario = $conexion->insert_id;
$stmt->close();

if ($dni == '') {
    $dni = 'DNI' . str_pad($id_usuario, 7, '0', STR_PAD_LEFT);
}

$stmt = $conexion->prepare("INSERT INTO Profesor (ID_user, DNI) VALUES (?, ?)");
$stmt->bind_param("is", $id_usuario, $dni);
$stmt->execute();
$stmt->close();

// si venimos desde detalle-grado, volvemos ahí
if ($id_grado > 0) {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=grados&id=' . $id_grado);
    exit;
}

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=profesores');
exit;
