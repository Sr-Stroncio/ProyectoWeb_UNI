
<?php include '../utils/check-empresa.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head class="header">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Página de compra</title>
    <base href="/">
    <link rel="stylesheet" href="css/pagina_servicios.css">
    <link rel="stylesheet" href="css/lading_page.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">

</head>

<body>

    <?php include '../components/header.php'; ?>
    <!-- seleccionar plan -->

    <section>
        <h2 class="titulo_dos">Seleccionar plan</h2>
        <div class="seleccionar_plan">
            <!-- caja prueba -->
            <div class="caja">
                <h3>Pagina de prueba</h3>
                <p>¡Empieza ahora con doa!


                    Prueba nuestra plataforma y experimenta de primera mano cómo simplifica la enseñanza. Accede a las funcionalidades clave y comprueba todo lo que puedes hacer antes de elegir un plan de compra.

                    Prueba DOA!</p>
                <a href="/pages/log-in-producto.php" class="boton-seleccionar-plan">Ir a la prueba
                </a>
            </div>
            <!-- caja plan estandar -->
            <div class="caja">
                <h3>Plan de estandar (5000€)</h3>
                <p>Todo lo que necesitas para el día a día educativo, en un solo lugar.


                    Llena de funciones como:
                    -Anuncios
                    -Calendario
                    -Asignaturas con: calificaciones, tareas, recursos y examenes.

                    ¡Todo esto, solo en DOA.!</p>

                <button type="button" class="boton-seleccionar-plan">Seleccionar plan</button>
            </div>
            <!-- caja plan profesional -->
            <div class="caja">
                <h3>Plan profesional (8000€)</h3>
                <p>Diseñado para instituciones que buscan una experiencia completa y sin límites.

                    -Todas las funciones del Plan Estándar
                    -Soporte premium durante 12 meses
                    -Atención prioritaria
                    -Configuración y ayuda personalizada
                    -Herramientas avanzadas para docentes y administración
                    -Máximo rendimiento y estabilidad

                    ¡Con este plan, no te quedaras atrás!</p><button type="button" class="boton-seleccionar-plan">Seleccionar plan</button>
            </div>
        </div>
    </section>
    <section class="formulario_compra">
        <h2 class="titulo_dos">Formulario compra</h2>
        <div class="caja-compra">
            <input type="text" placeholder="Nombre institución" required>
            <input type="email" placeholder="Correo electrónico" required>
            <input type="text" placeholder="Subdominio(Solo letras y números)" required>
            <button type="button" class="boton-compra">Confirmar compra</button>
        </div>
    </section>
</body>

</html>