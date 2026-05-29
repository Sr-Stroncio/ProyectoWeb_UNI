<?php

include '../utils/check-usuario.php';
comprobarUsuario('alumno');

require_once __DIR__ . "/../database/conexion.php";

$id_alumno = $_SESSION['usuario_id'];

$seccion = $_GET['seccion'] ?? 'inicio';
$id_asignatura = $_GET['id'] ?? null;
$vista = $_GET['vista'] ?? null;

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
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard-alumno.css">
    <link rel="stylesheet" href="css/inicio-alumno.css">
    <link rel="stylesheet" href="css/calificaciones-alumno.css">
    <link rel="stylesheet" href="css/alumno-anuncios.css">
    <link rel="stylesheet" href="css/alumno-tareas.css">
    <link rel="stylesheet" href="css/beta.css">
    <title>Dashboard alumno</title>
</head>

<body>

    <?php include '../components/dashboard-alumno/header-alumno.php'; ?>

    <section class="section-principal">

        <?php include '../components/dashboard-alumno/aside-alumno.php'; ?>

        <main>
            <?php

            if ($seccion === 'inicio') {
                include '../components/dashboard-alumno/Inicio-alumno.php';
            } elseif ($seccion === 'calificaciones') {
                include '../components/dashboard-alumno/calificaciones-alumno.php';
            } elseif ($seccion === 'anuncios') {
                include '../components/dashboard-alumno/anuncios-alumno.php';
            } elseif ($seccion === 'calendario') {
                include '../components/dashboard-profesor/calendario.php';
            } elseif ($seccion === 'recursos') {
                include '../components/dashboard-alumno/tareas-alumno.php';
            } elseif ($seccion === 'examenes') {
                include '../components/dashboard-alumno/tareas-alumno.php';
            } elseif ($seccion === 'tareas') {
                include '../components/dashboard-alumno/tareas-alumno.php';
            } elseif ($seccion === 'beta') {
                include '../components/beta.php';
            } else {
                include '../components/dashboard-alumno/Inicio-alumno.php';
            }

            ?>
        </main>

    </section>

    <script src="js/header-profesor.js"></script>
</body>

</html>