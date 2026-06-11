<?php

$id_alumno = intval($_SESSION['usuario_id']);
$id_asignatura = intval($_GET['id']);

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
    Consulta de exámenes.
    LEFT JOIN con Nota_Examen porque puede que el profesor todavía no haya puesto nota.
*/

$sql_examenes = "SELECT 
                    Examen.ID,
                    Examen.Titulo,
                    Examen.Fecha_examen,
                    Nota_Examen.Nota
                FROM Examen
                LEFT JOIN Nota_Examen
                    ON Examen.ID = Nota_Examen.ID_examen
                    AND Nota_Examen.ID_alumno = $id_alumno
                WHERE Examen.ID_asignatura = $id_asignatura
                ORDER BY Examen.Fecha_examen DESC";

$resultado_examenes = mysqli_query($conexion, $sql_examenes);

if (!$resultado_examenes) {
    die("Error al consultar exámenes: " . mysqli_error($conexion));
}

?>

<section class="main-contenido pagina-tareas">

    <div class="bloque">

        <div class="bloque-cabecera">
            <h3>Exámenes - <?= htmlspecialchars($nombre_asignatura) ?></h3>
        </div>

        <div class="contenedor-anuncios">

            <?php if (mysqli_num_rows($resultado_examenes) > 0): ?>

                <?php while ($examen = mysqli_fetch_assoc($resultado_examenes)): ?>

                    <a href="pages/dashboard-alumno.php?seccion=detalle-examen&id=<?= $examen['ID'] ?>&asignatura=<?= $id_asignatura ?>&volver=examenes">
                        <article class="anuncio-card tarea-card">

                            <div class="anuncio-info">

                                <div class="anuncio-top">

                                    <span class="anuncio-asig">
                                        <?= htmlspecialchars($nombre_asignatura) ?>
                                    </span>

                                    <?php if (!empty($examen['Fecha_examen'])): ?>
                                        <span class="anuncio-tiempo">
                                            Fecha:
                                            <?= date("d/m/Y H:i", strtotime($examen['Fecha_examen'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="anuncio-tiempo">
                                            Fecha pendiente
                                        </span>
                                    <?php endif; ?>

                                </div>

                                <h4 class="anuncio-titulo">
                                    <?= htmlspecialchars($examen['Titulo']) ?>
                                </h4>

                            </div>

                            <div class="anuncio-contenido tarea-contenido">

                                <p class="anuncio-desc tarea-desc">
                                    Consulta aquí la información y calificación del examen.
                                </p>

                                <div class="tarea-estado">

                                    <?php if ($examen['Nota'] !== null): ?>

                                        <span class="estado-entregada">
                                            Nota: <?= number_format($examen['Nota'], 2) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="estado-pendiente">
                                            Sin nota
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </article>
                    </a>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="anuncio-vacio">
                    <p>No hay exámenes disponibles para esta asignatura.</p>
                </div>

            <?php endif; ?>

        </div>

    </div>

</section>