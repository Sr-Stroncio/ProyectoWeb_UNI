<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

// se obtienen los datos del profesor de la sesion
$id_profesor = (int)$_SESSION['usuario_id'];
$nombre_profesor = $_SESSION['usuario_nombre_completo'];

$seccion = 'inicio';
$anuncios_js = [];
$tareas_js = [];
$calificaciones_js = [];
$examenes_js = [];
$recursos_js = [];

include '../components/dashboard-profesor/datos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard-profesor.css">
    <title>Dashboard — Profesor</title>
</head>
<body>

<?php include '../components/dashboard-profesor/header-profesor.php'; ?>

<section class="section-principal">

    <?php include '../components/dashboard-profesor/sidebar-profesor.php'; ?>

    <div id="sec-inicio" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/inicio.php'; ?>
    </div>

    <div id="sec-calificaciones" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/calificaciones.php'; ?>
    </div>

    <div id="sec-tareas" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/tareas.php'; ?>
    </div>

    <div id="sec-anuncios" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/anuncios.php'; ?>
    </div>

    <div id="sec-calendario" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/calendario.php'; ?>
    </div>

    <div id="sec-recursos" class="seccion-panel" style="display: none; flex: 1;">
        <?php include '../components/dashboard-profesor/recursos.php'; ?>
    </div>

</section>

<script>
    var anuncios = <?= json_encode($anuncios_js) ?>;
    var calificaciones = <?= json_encode($calificaciones_js) ?>;
    var examenes = <?= json_encode($examenes_js) ?>;
    var tareas = <?= json_encode($tareas_js) ?>;
    var recursos = <?= json_encode($recursos_js) ?>;
</script>

<script src="js/header-profesor.js"></script>
<script src="js/anuncios-profesor.js"></script>
<script src="js/tareas-profesor.js"></script>
<script src="js/calificaciones-profesor.js"></script>
<script src="js/recursos-profesor.js"></script>
<script src="js/router-profesor.js"></script>

</body>
</html>
