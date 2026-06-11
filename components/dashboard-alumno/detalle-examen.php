<?php

$id_alumno = intval($_SESSION['usuario_id']);
$id_examen = intval($_GET['id']);
$id_asignatura = intval($_GET['asignatura']);

/* 
    Comprobamos que el alumno tiene acceso a la asignatura
    y que el examen pertenece a esa asignatura.
*/

$sql_detalle_examen = "SELECT 
                            Examen.ID,
                            Examen.Titulo,
                            Examen.Fecha_examen,
                            Asignatura.ID AS ID_asignatura,
                            Asignatura.Nombre AS Nombre_asignatura,
                            Usuario.Nombre AS Nombre_profesor,
                            Usuario.Apellido AS Apellido_profesor,
                            Nota_Examen.Nota
                        FROM Examen
                        INNER JOIN Asignatura
                            ON Examen.ID_asignatura = Asignatura.ID
                        INNER JOIN Profesor
                            ON Examen.ID_profesor = Profesor.ID_user
                        INNER JOIN Usuario
                            ON Profesor.ID_user = Usuario.ID
                        INNER JOIN Alumno_Asignatura
                            ON Examen.ID_asignatura = Alumno_Asignatura.ID_asignatura
                        LEFT JOIN Nota_Examen
                            ON Examen.ID = Nota_Examen.ID_examen
                            AND Nota_Examen.ID_alumno = $id_alumno
                        WHERE 
                            Examen.ID = $id_examen
                            AND Examen.ID_asignatura = $id_asignatura
                            AND Alumno_Asignatura.ID_alumno = $id_alumno
                        LIMIT 1";

$resultado_detalle_examen = mysqli_query($conexion, $sql_detalle_examen);

if (!$resultado_detalle_examen) {
    die("Error al consultar detalle del examen: " . mysqli_error($conexion));
}

$examen = mysqli_fetch_assoc($resultado_detalle_examen);

$volver = $_GET['volver'] ?? 'examenes';

if ($volver === 'calificaciones') {
    $url_volver = "pages/dashboard-alumno.php?seccion=calificaciones";
    $texto_volver = "← Volver a calificaciones";
} else {
    $url_volver = "pages/dashboard-alumno.php?seccion=examenes&id=" . $id_asignatura;
    $texto_volver = "<- Volver a exámenes";
}

?>

<section class="main-contenido pagina-detalle">

    <div class="detalle-volver">
        <a href="<?= $url_volver ?>"><?= $texto_volver ?></a>
    </div>

    <?php if ($examen): ?>

        <article class="detalle-card">

            <div class="detalle-header">

                <div>
                    <h2 class="detalle-titulo">
                        <?= htmlspecialchars($examen['Titulo']) ?>
                    </h2>

                    <div class="detalle-subtitulo">

                        <?php if (!empty($examen['Fecha_examen'])): ?>
                            <span>
                                <?= date("d/m/Y H:i", strtotime($examen['Fecha_examen'])) ?>
                            </span>
                        <?php else: ?>
                            <span>Fecha pendiente</span>
                        <?php endif; ?>

                        <span>·</span>

                        <span>
                            <?= htmlspecialchars($examen['Nombre_asignatura']) ?>
                        </span>

                    </div>
                </div>

                <span class="detalle-etiqueta">
                    Examen
                </span>

            </div>

            <div class="detalle-meta">
                <p>
                    Profesor:
                    <?= htmlspecialchars($examen['Nombre_profesor'] . ' ' . $examen['Apellido_profesor']) ?>
                </p>
            </div>

            <div class="detalle-contenido">

                <div class="detalle-info-bloque">
                    <h3>Información del examen</h3>

                    <p>
                        <strong>Asignatura:</strong>
                        <?= htmlspecialchars($examen['Nombre_asignatura']) ?>
                    </p>

                    <p>
                        <strong>Fecha:</strong>
                        <?php if (!empty($examen['Fecha_examen'])): ?>
                            <?= date("d/m/Y H:i", strtotime($examen['Fecha_examen'])) ?>
                        <?php else: ?>
                            Fecha pendiente
                        <?php endif; ?>
                    </p>

                    <p>
                        <strong>Estado de la nota:</strong>

                        <?php if ($examen['Nota'] !== null): ?>
                            <span class="estado-entregada">
                                Nota: <?= number_format($examen['Nota'], 2) ?>
                            </span>
                        <?php else: ?>
                            <span class="estado-pendiente">
                                Sin nota
                            </span>
                        <?php endif; ?>
                    </p>
                </div>

            </div>

        </article>

    <?php else: ?>

        <div class="detalle-vacio">
            <h3>Examen no encontrado</h3>
            <p>Este examen no existe o no tienes permiso para verlo.</p>
        </div>

    <?php endif; ?>

</section>