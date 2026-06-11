<?php

$id_alumno = intval($_SESSION['usuario_id']);
$id_tarea = intval($_GET['id']);
$id_asignatura = intval($_GET['asignatura']);

$volver = $_GET['volver'] ?? 'tareas';

if ($volver === 'calificaciones') {
    $url_volver = "pages/dashboard-alumno.php?seccion=calificaciones";
    $texto_volver = "← Volver a calificaciones";
} else {
    $url_volver = "pages/dashboard-alumno.php?seccion=tareas&id=" . $id_asignatura;
    $texto_volver = "← Volver a tareas";
}

/* 
    Consultamos el detalle de la tarea.
    Comprobamos que la tarea pertenece a una asignatura del alumno.
*/

$sql_detalle_tarea = "SELECT 
                            Tarea.ID,
                            Tarea.Titulo,
                            Tarea.Descripcion,
                            Tarea.Archivo_URL,
                            Tarea.Fecha_creacion,
                            Tarea.Fecha_limite,
                            Asignatura.ID AS ID_asignatura,
                            Asignatura.Nombre AS Nombre_asignatura,
                            Usuario.Nombre AS Nombre_profesor,
                            Usuario.Apellido AS Apellido_profesor,
                            Entrega_Tarea.Archivo_URL AS Archivo_entrega,
                            Entrega_Tarea.Fecha_entrega,
                            Entrega_Tarea.Nota,
                            Entrega_Tarea.Comentario_profesor
                        FROM Tarea
                        INNER JOIN Asignatura
                            ON Tarea.ID_asignatura = Asignatura.ID
                        INNER JOIN Profesor
                            ON Tarea.ID_profesor = Profesor.ID_user
                        INNER JOIN Usuario
                            ON Profesor.ID_user = Usuario.ID
                        INNER JOIN Alumno_Asignatura
                            ON Tarea.ID_asignatura = Alumno_Asignatura.ID_asignatura
                        LEFT JOIN Entrega_Tarea
                            ON Tarea.ID = Entrega_Tarea.ID_tarea
                            AND Entrega_Tarea.ID_alumno = $id_alumno
                        WHERE 
                            Tarea.ID = $id_tarea
                            AND Tarea.ID_asignatura = $id_asignatura
                            AND Alumno_Asignatura.ID_alumno = $id_alumno
                        LIMIT 1";

$resultado_detalle_tarea = mysqli_query($conexion, $sql_detalle_tarea);

if (!$resultado_detalle_tarea) {
    die("Error al consultar detalle de la tarea: " . mysqli_error($conexion));
}

$tarea = mysqli_fetch_assoc($resultado_detalle_tarea);

?>

<section class="main-contenido pagina-detalle">

    <div class="detalle-volver">
        <a href="<?= $url_volver ?>"><?= $texto_volver ?></a>
    </div>

    <?php if ($tarea): ?>

        <article class="detalle-card">

            <div class="detalle-header">

                <div>
                    <h2 class="detalle-titulo">
                        <?= htmlspecialchars($tarea['Titulo']) ?>
                    </h2>

                    <div class="detalle-subtitulo">

                        <span>
                            <?= htmlspecialchars($tarea['Nombre_asignatura']) ?>
                        </span>

                        <span>·</span>

                        <span>
                            Publicada:
                            <?= date("d/m/Y H:i", strtotime($tarea['Fecha_creacion'])) ?>
                        </span>

                    </div>
                </div>

                <span class="detalle-etiqueta">
                    Tarea
                </span>

            </div>

            <div class="detalle-meta">
                <p>
                    Profesor:
                    <?= htmlspecialchars($tarea['Nombre_profesor'] . ' ' . $tarea['Apellido_profesor']) ?>
                </p>
            </div>

            <div class="detalle-contenido">

                <div class="detalle-info-bloque">
                    <h3>Información de la tarea</h3>

                    <p>
                        <strong>Asignatura:</strong>
                        <?= htmlspecialchars($tarea['Nombre_asignatura']) ?>
                    </p>

                    <p>
                        <strong>Fecha de publicación:</strong>
                        <?= date("d/m/Y H:i", strtotime($tarea['Fecha_creacion'])) ?>
                    </p>

                    <p>
                        <strong>Fecha límite:</strong>
                        <?php if (!empty($tarea['Fecha_limite'])): ?>
                            <?= date("d/m/Y H:i", strtotime($tarea['Fecha_limite'])) ?>
                        <?php else: ?>
                            Sin fecha límite
                        <?php endif; ?>
                    </p>

                    <p>
                        <strong>Estado:</strong>

                        <?php if ($tarea['Fecha_entrega'] !== null): ?>

                            <?php if ($tarea['Nota'] !== null): ?>
                                <span class="estado-entregada">
                                    Nota: <?= number_format($tarea['Nota'], 2) ?>
                                </span>
                            <?php else: ?>
                                <span class="estado-entregada">
                                    Entregada - Sin nota
                                </span>
                            <?php endif; ?>

                        <?php else: ?>

                            <span class="estado-pendiente">
                                Pendiente
                            </span>

                        <?php endif; ?>
                    </p>
                </div>

                <div class="detalle-info-bloque">
                    <h3>Descripción</h3>

                    <p>
                        <?= nl2br(htmlspecialchars($tarea['Descripcion'])) ?>
                    </p>
                </div>

                <?php if (!empty($tarea['Archivo_URL'])): ?>

                    <div class="detalle-info-bloque">
                        <h3>Archivo de la tarea</h3>

                        <p>
                            <a href="<?= htmlspecialchars($tarea['Archivo_URL']) ?>" target="_blank">
                                Ver archivo adjunto
                            </a>
                        </p>
                    </div>

                <?php endif; ?>

                <?php if ($tarea['Fecha_entrega'] !== null): ?>

                    <div class="detalle-info-bloque">
                        <h3>Tu entrega</h3>

                        <p>
                            <strong>Fecha de entrega:</strong>
                            <?= date("d/m/Y H:i", strtotime($tarea['Fecha_entrega'])) ?>
                        </p>

                        <p>
                            <strong>Nota:</strong>
                            <?php if ($tarea['Nota'] !== null): ?>
                                <?= number_format($tarea['Nota'], 2) ?>
                            <?php else: ?>
                                Sin nota
                            <?php endif; ?>
                        </p>

                        <?php if (!empty($tarea['Comentario_profesor'])): ?>
                            <p>
                                <strong>Comentario del profesor:</strong>
                                <?= nl2br(htmlspecialchars($tarea['Comentario_profesor'])) ?>
                            </p>
                        <?php endif; ?>

                    </div>

                <?php endif; ?>

            </div>

        </article>

    <?php else: ?>

        <div class="detalle-vacio">
            <h3>Tarea no encontrada</h3>
            <p>Esta tarea no existe o no tienes permiso para verla.</p>
        </div>

    <?php endif; ?>

</section>