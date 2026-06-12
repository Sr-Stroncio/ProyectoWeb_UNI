<?php

$id_alumno = intval($_SESSION['usuario_id']);
$id_anuncio = intval($_GET['id']);

$volver = $_GET['volver'] ?? 'inicio';

if ($volver === 'anuncios') {
    $url_volver = "pages/dashboard-alumno.php?seccion=anuncios";
    $texto_volver = "<- Volver a anuncios";
} else {
    $url_volver = "pages/dashboard-alumno.php?seccion=inicio";
    $texto_volver = "<- Volver al inicio";
}

$sql_detalle_anuncio = "SELECT 
                            Anuncio.ID,
                            Anuncio.Titulo,
                            Anuncio.Contenido,
                            Anuncio.Fecha_publicacion,
                            Anuncio.Tipo,
                            Asignatura.Nombre AS Nombre_asignatura,
                            Usuario.Nombre AS Nombre_autor,
                            Usuario.Apellido AS Apellido_autor
                        FROM Anuncio
                        INNER JOIN Usuario
                            ON Anuncio.ID_autor = Usuario.ID
                        LEFT JOIN Asignatura
                            ON Anuncio.ID_asignatura = Asignatura.ID
                        WHERE 
                            Anuncio.ID = $id_anuncio
                            AND (
                                Anuncio.Tipo = 'global'
                                OR (
                                    Anuncio.Tipo = 'asignatura'
                                    AND Anuncio.ID_asignatura IN (
                                        SELECT ID_asignatura
                                        FROM Alumno_Asignatura
                                        WHERE ID_alumno = $id_alumno
                                    )
                                )
                            )
                        LIMIT 1";

$resultado_detalle_anuncio = mysqli_query($conexion, $sql_detalle_anuncio);

if (!$resultado_detalle_anuncio) {
    die("Error al consultar detalle del anuncio: " . mysqli_error($conexion));
}

$anuncio = mysqli_fetch_assoc($resultado_detalle_anuncio);

?>

<section class="main-contenido pagina-detalle">

    <div class="detalle-volver">
        <a href="<?= $url_volver ?>"><?= $texto_volver ?></a>
    </div>

    <?php if ($anuncio): ?>

        <article class="detalle-card">

            <div class="detalle-header">

                <div>
                    <h2 class="detalle-titulo">
                        <?= htmlspecialchars($anuncio['Titulo']) ?>
                    </h2>

                    <div class="detalle-subtitulo">
                        <span>
                            <?= date("d/m/Y H:i", strtotime($anuncio['Fecha_publicacion'])) ?>
                        </span>

                        <span>·</span>

                        <?php if ($anuncio['Tipo'] === 'global'): ?>
                            <span>General</span>
                        <?php else: ?>
                            <span><?= htmlspecialchars($anuncio['Nombre_asignatura']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($anuncio['Tipo'] === 'global'): ?>

                    <span class="detalle-etiqueta detalle-global">
                        General
                    </span>

                <?php else: ?>

                    <span class="detalle-etiqueta">
                        <?= htmlspecialchars($anuncio['Nombre_asignatura']) ?>
                    </span>

                <?php endif; ?>

            </div>

            <div class="detalle-meta">
                <p>
                    Publicado por:
                    <?= htmlspecialchars($anuncio['Nombre_autor'] . ' ' . $anuncio['Apellido_autor']) ?>
                </p>
            </div>

            <div class="detalle-contenido">
                <?= nl2br(htmlspecialchars($anuncio['Contenido'])) ?>
            </div>

        </article>

    <?php else: ?>

        <div class="detalle-vacio">
            <h3>Anuncio no encontrado</h3>
            <p>Este anuncio no existe o no tienes permiso para verlo.</p>
        </div>

    <?php endif; ?>

</section>