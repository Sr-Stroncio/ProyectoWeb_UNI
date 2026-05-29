<?php

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
                ORDER BY Anuncio.Fecha_publicacion DESC";

$resultado_anuncios = mysqli_query($conexion, $sql_anuncios);

if (!$resultado_anuncios) {
    die("Error al consultar anuncios: " . mysqli_error($conexion));
}

?>

<section class="main-contenido pagina-anuncios">

    <div class="bloque">

        <div class="bloque-cabecera">
            <h3>Anuncios</h3>
        </div>

        <a href="">
            <div class="contenedor-anuncios">

                <?php if (mysqli_num_rows($resultado_anuncios) > 0): ?>

                    <?php while ($anuncio = mysqli_fetch_assoc($resultado_anuncios)): ?>

                        <article class="anuncio-card">

                            <div class="anuncio-info">

                                <div class="anuncio-top">

                                    <?php if ($anuncio['Tipo'] === 'global'): ?>

                                        <span class="anuncio-asig anuncio-global">
                                            General
                                        </span>

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

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="anuncio-vacio">
                        <p>No hay anuncios disponibles por ahora.</p>
                    </div>

                <?php endif; ?>

            </div>
        </a>
    </div>

</section>