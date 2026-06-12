<?php

$id_alumno = intval($_SESSION['usuario_id']);
$id_asignatura = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* 
    Comprobamos que el alumno realmente pertenece a esa asignatura.
    Así evitamos que escriba otro id en la URL.
*/

$sql_comprobar_asignatura = "SELECT 
                                Asignatura.ID,
                                Asignatura.Nombre
                            FROM Alumno_Asignatura
                            INNER JOIN Asignatura
                                ON Alumno_Asignatura.ID_asignatura = Asignatura.ID
                            WHERE Alumno_Asignatura.ID_alumno = $id_alumno
                            AND Alumno_Asignatura.ID_asignatura = $id_asignatura";

$resultado_comprobar_asignatura = mysqli_query($conexion, $sql_comprobar_asignatura);

if (!$resultado_comprobar_asignatura) {
    die("Error al comprobar la asignatura: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado_comprobar_asignatura) === 0) {
    die("No tienes acceso a esta asignatura.");
}

$asignatura = mysqli_fetch_assoc($resultado_comprobar_asignatura);
$nombre_asignatura = $asignatura['Nombre'];


/* 
    Consulta de tareas.
    LEFT JOIN con Entrega_Tarea porque puede que el alumno todavía no haya entregado.
    Si entregó, mostramos la nota.
    Si no entregó, mostramos Pendiente.
*/

$sql_tareas = "SELECT 
                    Tarea.ID,
                    Tarea.Titulo,
                    Tarea.Descripcion,
                    Tarea.Archivo_URL,
                    Tarea.Fecha_creacion,
                    Tarea.Fecha_limite,
                    Entrega_Tarea.Nota,
                    Entrega_Tarea.Fecha_entrega
                FROM Tarea
                LEFT JOIN Entrega_Tarea
                    ON Tarea.ID = Entrega_Tarea.ID_tarea
                    AND Entrega_Tarea.ID_alumno = $id_alumno
                WHERE Tarea.ID_asignatura = $id_asignatura
                ORDER BY Tarea.Fecha_creacion DESC";

$resultado_tareas = mysqli_query($conexion, $sql_tareas);

if (!$resultado_tareas) {
    die("Error al consultar tareas: " . mysqli_error($conexion));
}

?>

<section class="main-contenido pagina-tareas">

    <div class="bloque">

        <div class="bloque-cabecera">
            <h3>Tareas - <?= htmlspecialchars($nombre_asignatura) ?></h3>
        </div>

        <div class="contenedor-anuncios">

            <?php if (mysqli_num_rows($resultado_tareas) > 0): ?>

                <?php while ($tarea = mysqli_fetch_assoc($resultado_tareas)): ?>

                    <a href="pages/dashboard-alumno.php?seccion=detalle-tarea&id=<?= $tarea['ID'] ?>&asignatura=<?= $id_asignatura ?>&volver=tareas">
                        <article class="anuncio-card tarea-card">

                            <div class="anuncio-info">

                                <div class="anuncio-top">

                                    <span class="anuncio-asig">
                                        <?= htmlspecialchars($nombre_asignatura) ?>
                                    </span>

                                    <span class="anuncio-tiempo">
                                        Publicada:
                                        <?= date("d/m/Y H:i", strtotime($tarea['Fecha_creacion'])) ?>
                                    </span>

                                    <?php if (!empty($tarea['Fecha_limite'])): ?>
                                        <span class="anuncio-tiempo">
                                            Límite:
                                            <?= date("d/m/Y H:i", strtotime($tarea['Fecha_limite'])) ?>
                                        </span>
                                    <?php endif; ?>

                                </div>

                                <h4 class="anuncio-titulo">
                                    <?= htmlspecialchars($tarea['Titulo']) ?>
                                </h4>

                            </div>

                            <div class="anuncio-contenido tarea-contenido">

                                <p class="anuncio-desc tarea-desc">
                                    <?= nl2br(htmlspecialchars($tarea['Descripcion'])) ?>
                                </p>

                                <div class="tarea-estado">

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

                                </div>

                            </div>

                        </article>
                    </a>
                <?php endwhile; ?>

            <?php else: ?>

                <div class="anuncio-vacio">
                    <p>No hay tareas disponibles para esta asignatura.</p>
                </div>

            <?php endif; ?>

        </div>

    </div>

</section>