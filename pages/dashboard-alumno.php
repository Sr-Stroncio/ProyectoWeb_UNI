<?php

include __DIR__ . '/../utils/check-usuario.php';
comprobarUsuario('alumno');

require_once __DIR__ . "/../database/conexion.php";
require_once __DIR__ . "/../utils/rutas.php";

$id_alumno = $_SESSION['usuario_id'];

$seccion = $_GET['seccion'] ?? 'inicio';
$id_asignatura = $_GET['id'];
$vista = $_GET['vista'];

$sql_asignaturas = "SELECT 
                        Asignatura.ID,
                        Asignatura.Nombre
                    FROM Alumno_Asignatura
                    INNER JOIN Asignatura 
                        ON Alumno_Asignatura.ID_asignatura = Asignatura.ID
                    WHERE Alumno_Asignatura.ID_alumno = $id_alumno
                    ORDER BY Asignatura.Nombre";

$resultado_asignaturas = mysqli_query($conexion, $sql_asignaturas);

if (!$resultado_asignaturas) {
    die("Error al consultar asignaturas: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?= $base_url ?>">

    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard-alumno.css">
    <link rel="stylesheet" href="css/inicio-alumno.css">
    <link rel="stylesheet" href="css/calendario.css">
    <link rel="stylesheet" href="css/calificaciones-alumno.css">
    <link rel="stylesheet" href="css/alumno-anuncios.css">
    <link rel="stylesheet" href="css/alumno-tareas.css">
    <link rel="stylesheet" href="css/beta.css">
    <link rel="stylesheet" href="css/detalle.css">

    <title>Dashboard alumno</title>
</head>

<body>

    <?php include __DIR__ . '/../components/dashboard-alumno/header-alumno.php'; ?>

    <section class="section-principal">

        <?php include __DIR__ . '/../components/dashboard-alumno/aside-alumno.php'; ?>

        <main>
            <?php

            if ($seccion === 'inicio') {
                include __DIR__ . '/../components/dashboard-alumno/Inicio-alumno.php';
            } elseif ($seccion === 'calificaciones') {
                include __DIR__ . '/../components/dashboard-alumno/calificaciones-alumno.php';
            } elseif ($seccion === 'anuncios') {
                include __DIR__ . '/../components/dashboard-alumno/anuncios-alumno.php';
            } elseif ($seccion === 'detalle-anuncio') {
                include __DIR__ . '/../components/dashboard-alumno/detalle-anuncio.php';
            } elseif ($seccion === 'calendario') {
                include __DIR__ . '/../components/dashboard-profesor/calendario.php';
            } elseif ($seccion === 'recursos') {
                include __DIR__ . '/../components/dashboard-alumno/tareas-alumno.php';
            } elseif ($seccion === 'examenes') {
                include __DIR__ . '/../components/dashboard-alumno/examen-alumno.php';
            } elseif ($seccion === 'detalle-tarea') {
                include __DIR__ . '/../components/dashboard-alumno/detalle-tarea.php';
            } elseif ($seccion === 'detalle-examen') {
                include __DIR__ . '/../components/dashboard-alumno/detalle-examen.php';
            } elseif ($seccion === 'tareas') {
                include __DIR__ . '/../components/dashboard-alumno/tareas-alumno.php';
            } elseif ($seccion === 'beta') {
                include __DIR__ . '/../components/beta.php';
            } else {
                include __DIR__ . '/../components/dashboard-alumno/Inicio-alumno.php';
            }

            ?>
        </main>

    </section>

    <script src="js/header-profesor.js"></script>
</body>

</html>