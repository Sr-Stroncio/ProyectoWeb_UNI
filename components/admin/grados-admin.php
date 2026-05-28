<?php
session_start();

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

require_once '../utils/db.php';

$tituloPagina = 'Grados';

$id_grado = isset($_GET['id']) ? intval($_GET['id']) : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/header-profesor.css">
    <link rel="stylesheet" href="css/grados-admin.css">
    <title>Grados – Administrador</title>
</head>
<body>

<?php include '../components/admin/header-admin.php'; ?>

<section class="section-principal">

    <?php include '../components/admin/sidebar-admin.php'; ?>

    <main>
        <?php if ($id_grado === null): ?>
            <?php include '../components/admin/lista-grados.php'; ?>
        <?php else: ?>
            <?php include '../components/admin/detalle-grado.php'; ?>
        <?php endif; ?>
    </main>

</section>

<script src="js/grados-admin.js"></script>
<script src="js/header-profesor.js"></script>
</body>
</html>
