<?php

$filtro = $_GET['filtro'] ?? 'recientes';

if ($filtro !== 'recientes' && $filtro !== 'materia') {
    $filtro = 'recientes';
}

$sql_calificaciones = "
    SELECT 
        'Tarea' AS Tipo,
        Tarea.ID AS ID_Actividad,
        Tarea.Titulo AS Titulo,
        Asignatura.Nombre AS Asignatura,
        Entrega_Tarea.Nota AS Nota,
        Entrega_Tarea.Comentario_profesor AS Comentario,
        Tarea.Fecha_creacion AS Fecha
    FROM Entrega_Tarea
    INNER JOIN Tarea 
        ON Entrega_Tarea.ID_tarea = Tarea.ID
    INNER JOIN Asignatura 
        ON Tarea.ID_asignatura = Asignatura.ID
    WHERE Entrega_Tarea.ID_alumno = $id_alumno
    AND Entrega_Tarea.Nota IS NOT NULL

    UNION ALL

    SELECT 
        'Examen' AS Tipo,
        Examen.ID AS ID_Actividad,
        Examen.Titulo AS Titulo,
        Asignatura.Nombre AS Asignatura,
        Nota_Examen.Nota AS Nota,
        NULL AS Comentario,
        Examen.Fecha_examen AS Fecha
    FROM Nota_Examen
    INNER JOIN Examen 
        ON Nota_Examen.ID_examen = Examen.ID
    INNER JOIN Asignatura 
        ON Examen.ID_asignatura = Asignatura.ID
    WHERE Nota_Examen.ID_alumno = $id_alumno
    AND Nota_Examen.Nota IS NOT NULL
";
if ($filtro === 'materia') {
    $sql_calificaciones .= " ORDER BY Asignatura ASC, Fecha DESC";
} else {
    $sql_calificaciones .= " ORDER BY Fecha DESC";
}

$resultado_calificaciones = mysqli_query($conexion, $sql_calificaciones);

if (!$resultado_calificaciones) {
    die("Error al consultar calificaciones: " . mysqli_error($conexion));
}

?>

<section class="calificaciones-alumno">

    <div class="cabecera-calificaciones">
        <div>
            <h1>Calificaciones</h1>
            <p>Consulta tus notas de tareas y exámenes.</p>
        </div>

        <div class="filtros-calificaciones">
            <a
                href="pages/dashboard-alumno.php?seccion=calificaciones&filtro=recientes"
                class="<?php echo $filtro === 'recientes' ? 'activo' : ''; ?>">
                Más recientes
            </a>

            <a
                href="pages/dashboard-alumno.php?seccion=calificaciones&filtro=materia"
                class="<?php echo $filtro === 'materia' ? 'activo' : ''; ?>">
                Por materia
            </a>
        </div>
    </div>

    <?php if (mysqli_num_rows($resultado_calificaciones) === 0) { ?>

        <div class="sin-calificaciones">
            <h3>No tienes calificaciones todavía</h3>
            <p>Cuando un profesor publique una nota, aparecerá aquí.</p>
        </div>

    <?php } else { ?>

        <?php
        $materia_actual = '';

        while ($calificacion = mysqli_fetch_assoc($resultado_calificaciones)) {

            if ($filtro === 'materia' && $materia_actual !== $calificacion['Asignatura']) {
                $materia_actual = $calificacion['Asignatura'];
        ?>

                <h2 class="titulo-materia">
                    <?php echo htmlspecialchars($materia_actual); ?>
                </h2>

            <?php } ?>

            <article class="tarjeta-calificacion">

                <div class="info-calificacion">
                    <span class="tipo-calificacion">
                        <?php echo htmlspecialchars($calificacion['Tipo']); ?>
                    </span>

                    <h3>
                        <?php echo htmlspecialchars($calificacion['Titulo']); ?>
                    </h3>

                    <?php if ($filtro === 'recientes') { ?>
                        <p class="materia-calificacion">
                            <?php echo htmlspecialchars($calificacion['Asignatura']); ?>
                        </p>
                    <?php } ?>

                    <p class="fecha-calificacion">
                        <?php echo date("d/m/Y", strtotime($calificacion['Fecha'])); ?>
                    </p>

                    <?php if (!empty($calificacion['Comentario'])) { ?>
                        <p class="comentario-profesor">
                            <?php echo htmlspecialchars($calificacion['Comentario']); ?>
                        </p>
                    <?php } ?>

                </div>

                <div class="nota-calificacion">
                    <?php echo number_format($calificacion['Nota'], 2); ?>
                </div>

            </article>

        <?php } ?>

    <?php } ?>

</section>