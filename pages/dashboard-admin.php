<?php
session_start();

require_once '../utils/db.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: /pages/log-in-producto.php');
    exit;
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    if ($_SESSION['rol'] == 'profesor') {
        header('Location: /pages/dashboard-profesor.php');
        exit;
    }
    if ($_SESSION['rol'] == 'alumno') {
        header('Location: /pages/dashboard-alumno.php');
        exit;
    }
    header('Location: /pages/log-in-producto.php');
    exit;
}



$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : null;
$id_grado = isset($_GET['id']) ? intval($_GET['id']) : null;
$id_alumno = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($seccion == 'grados') {
    $tituloPagina = 'Grados';
} elseif ($seccion == 'alumnos') {
    $tituloPagina = 'Alumnos';
} else {
    $tituloPagina = 'Dashboard';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/header-profesor.css">
    <link rel="stylesheet" href="css/dashboard-admin.css">
    <title>Dashboard administrador</title>
</head>
<body>

<?php include '../components/admin/header-admin.php'; ?>

<section class="section-principal">

    <?php include '../components/admin/sidebar-admin.php'; ?>

    <main>

        <?php if ($seccion === null): ?>
            <?php include '../components/admin/vista-general.php'; ?>
            <?php include '../components/admin/gestion.php'; ?>

        <?php elseif ($seccion == 'grados' && $id_grado === null): ?>
            <?php include '../components/admin/lista-grados.php'; ?>

        <?php elseif ($seccion == 'grados' && $id_grado !== null): ?>
            <?php include '../components/admin/detalle-grado.php'; ?>

        <?php elseif ($seccion == 'alumnos' && $id_alumno === null): ?>
            <?php include '../components/admin/lista-alumnos.php'; ?>

        <?php elseif ($seccion == 'alumnos' && $id_alumno !== null): ?>
            <?php include '../components/admin/detalle-alumno.php'; ?>

        <?php endif; ?>

    </main>

</section>

<script src="js/dashboard-admin.js"></script>
<script src="js/header-profesor.js"></script>
</body>
</html>
