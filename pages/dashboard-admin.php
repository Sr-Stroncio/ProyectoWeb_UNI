<?php
session_start();

require_once '../database/conexion.php';
require_once '../utils/rutas.php';

include '../utils/check-usuario.php';
comprobarUsuario('admin');

$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : null;
$id_grado = isset($_GET['id']) ? intval($_GET['id']) : null;
$id_alumno = isset($_GET['id']) ? intval($_GET['id']) : null;
$id_profesor = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($seccion == 'grados') {
    $tituloPagina = 'Grados';
} elseif ($seccion == 'alumnos') {
    $tituloPagina = 'Alumnos';
} elseif ($seccion == 'profesores') {
    $tituloPagina = 'Profesores';
} else {
    $tituloPagina = 'Dashboard';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, ini  tial-scale=1.0">
    <base href="<?= $base_url ?>">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/profesor-header.css">
    <link rel="stylesheet" href="css/dashboard-admin.css">
    <link rel="stylesheet" href="css/beta.css">
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

            <?php elseif ($seccion == 'profesores' && $id_profesor === null): ?>
                <?php include '../components/admin/lista-profesores.php'; ?>

            <?php elseif ($seccion == 'profesores' && $id_profesor !== null): ?>
                <?php include '../components/admin/detalle-profesor.php'; ?>

            <?php elseif ($seccion == 'anuncios'): ?>
                <?php include '../components/beta.php'; ?>

            <?php endif; ?>

        </main>

    </section>

    <script src="js/dashboard-admin.js"></script>
    <script src="js/header-profesor.js"></script>
</body>

</html>