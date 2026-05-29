<?php

// consulta para los anuncios

$id_alumno = intval($_SESSION['usuario_id']);

$sql_anuncios = "SELECT 
                    Anuncio.ID,
                    Anuncio.Titulo,
                    Anuncio.Contenido,
                    Anuncio.Fecha_publicacion,
                    Anuncio.Tipo,
                    Asignatura.Nombre AS Nombre_asignatura
                FROM Anuncio
                LEFT JOIN Asignatura
                    ON Anuncio.ID_asignatura = Asignatura.ID
                WHERE 
                    Anuncio.Tipo = 'global'
                    OR (
                        Anuncio.Tipo = 'asignatura'
                        AND Anuncio.ID_asignatura IN (
                            SELECT ID_asignatura
                            FROM Alumno_Asignatura
                            WHERE ID_alumno = $id_alumno
                        )
                    )
                ORDER BY Anuncio.Fecha_publicacion DESC
                LIMIT 3";

$resultado_anuncios = mysqli_query($conexion, $sql_anuncios);

if (!$resultado_anuncios) {
    die("Error al consultar anuncios: " . mysqli_error($conexion));
}

// CONSULTA: tareas pendientes de entregar

$sql_tareas_pendientes = "SELECT COUNT(*) AS total_pendientes
                            FROM Tarea
                            INNER JOIN Alumno_Asignatura
                            ON Tarea.ID_asignatura = Alumno_Asignatura.ID_asignatura
                            WHERE Alumno_Asignatura.ID_alumno = $id_alumno
                            AND NOT EXISTS (
                                SELECT 1
                                FROM Entrega_Tarea
                                WHERE Entrega_Tarea.ID_tarea = Tarea.ID
                                AND Entrega_Tarea.ID_alumno = $id_alumno
                            ) 
                            AND Tarea.Fecha_limite >= NOW()";

$resultado_tareas_pendientes = mysqli_query($conexion, $sql_tareas_pendientes);

if (!$resultado_tareas_pendientes) {
    die("Error al consultar tareas pendientes: " . mysqli_error($conexion));
}

$fila_tareas = mysqli_fetch_assoc($resultado_tareas_pendientes);
$total_tareas_pendientes = $fila_tareas['total_pendientes'];


// CONSULTA: promedio de exámenes del usuario (alumno)

$sql_promedio_examenes = "SELECT AVG(Nota_Examen.Nota) AS promedio_examenes
                            FROM Nota_Examen
                            WHERE Nota_Examen.ID_alumno = $id_alumno
                            AND Nota_Examen.Nota IS NOT NULL";

$resultado_promedio_examenes = mysqli_query($conexion, $sql_promedio_examenes);

if (!$resultado_promedio_examenes) {
    die("Error al consultar promedio de exámenes: " . mysqli_error($conexion));
}

$fila_promedio = mysqli_fetch_assoc($resultado_promedio_examenes);
$promedio_examenes = $fila_promedio['promedio_examenes'];

?>

<!-- 



Comienzo del HTML del inicio del dashboard 



-->

<section class="main-contenido">

    <div class="bloque">
        <div class="bloque-cabecera">
            <h3>Últimos anuncios</h3>
        </div>

        <div class="contenedor-anuncios">

            <?php if (mysqli_num_rows($resultado_anuncios) > 0): ?>

                <?php while ($anuncio = mysqli_fetch_assoc($resultado_anuncios)): ?>
                    <a href="/pages/dashboard-alumno.php?seccion=beta">
                        <article class="anuncio-card">

                            <div class="anuncio-info">

                                <div class="anuncio-top">

                                    <?php if ($anuncio['Tipo'] === 'global'): ?>
                                        <span class="anuncio-asig anuncio-global">General</span>
                                    <?php else: ?>
                                        <span class="anuncio-asig">
                                            <?= htmlspecialchars($anuncio['Nombre_asignatura']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="anuncio-tiempo">
                                        <?= date("d/m/Y H:i", strtotime($anuncio['Fecha_publicacion'])) ?>
                                    </span>

                                </div>

                                <h4 class="anuncio-titulo">
                                    <?= htmlspecialchars($anuncio['Titulo']) ?>
                                </h4>

                            </div>

                            <div class="anuncio-contenido">
                                <p class="anuncio-desc">
                                    <?= nl2br(htmlspecialchars($anuncio['Contenido'])) ?>
                                </p>
                            </div>

                        </article>
                    </a>
                <?php endwhile; ?>

            <?php else: ?>

                <div class="anuncio-vacio">
                    <p>No hay anuncios disponibles por ahora.</p>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <div class="bloque-cabecera">
        <h3>Informacion general</h3>
    </div>

    <div class="resumen-inicio">

        <div class="resumen-card">
            <div class="resumen-info">
                <p class="resumen-label">Tareas por entregar</p>
                <h3 class="resumen-titulo">Tareas activas</h3>
            </div>

            <p class="resumen-numero rojo">
                <?= $total_tareas_pendientes ?>
            </p>
        </div>

        <div class="resumen-card">
            <div class="resumen-info">
                <p class="resumen-label">Exámenes revisados</p>
                <h3 class="resumen-titulo">Promedio general</h3>
            </div>

            <p class="resumen-numero">
                <?php if ($promedio_examenes === null): ?>
                    -
                <?php else: ?>
                    <?= number_format($promedio_examenes, 2) ?>
                <?php endif; ?>
            </p>
        </div>

    </div>
</section>