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

$nombre   = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email    = trim($_POST['email'] ?? '');
$dni      = trim($_POST['dni'] ?? '');
$id_grado = intval($_POST['id_grado'] ?? 0);

if ($nombre == '' || $email == '') {
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos');
    exit;
}

// la contraseña la escribe el admin en el formulario, si la deja vacia se pone la de defecto
$password = trim($_POST['password'] ?? '');
if ($password == '') {
    $password = 'alumno123';
}

$stmt = $conexion->prepare("INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password) VALUES ('alumno', ?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $email, $password);
$stmt->execute();
$id_usuario = $conexion->insert_id;
$stmt->close();

// si no vino dni ponemos uno temporal
if ($dni == '') {
    $dni = 'DNI' . str_pad($id_usuario, 7, '0', STR_PAD_LEFT);
}

$stmt = $conexion->prepare("INSERT INTO Alumno (ID_user, DNI) VALUES (?, ?)");
$stmt->bind_param("is", $id_usuario, $dni);
$stmt->execute();
$stmt->close();

// matricula en asignaturas del grado si se eligió uno
if ($id_grado > 0) {
    $res = $conexion->query("
        SELECT asig.ID FROM Asignatura asig
        JOIN Curso c ON c.ID = asig.ID_curso
        WHERE c.ID_grado = $id_grado
    ");
    while ($asig = $res->fetch_assoc()) {
        $stmt = $conexion->prepare("INSERT IGNORE INTO Alumno_Asignatura (ID_alumno, ID_asignatura) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_usuario, $asig['ID']);
        $stmt->execute();
        $stmt->close();
    }
    // si venimos desde detalle-grado, volvemos ahí
    header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=grados&id=' . $id_grado);
    exit;
}

header('Location: ' . $base_url . 'pages/dashboard-admin.php?seccion=alumnos');
exit;
