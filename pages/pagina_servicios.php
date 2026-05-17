
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
                <a href="/pages/log-in-producto.php" class="btn-demo">Ir a la prueba
                </a>
            </div>
            <!-- caja plan estandar -->
            <div class="caja">
                <img class="GTI_logo" src="assets/DoA color.svg" alt="DOA">
                <h2>(5000€)</h2>
                <p>Todo lo que necesitas para el día a día educativo, en un solo lugar.

                    Llena de funciones como:
                    -Distintos roles en la applicación(Alumno, Profesor, Administrador) para una mejor organización con distintas acciones por cada rol.
                    -Cada rol tiene diversas funciones como: Anuncios,Calendario,Asignaturas con: calificaciones, tareas, recursos y examenes, para crear un ecosistema online en donde alumnos y docentes se actualizen sin necesitar de ser presencialmente.
                    -Recomendado para instituciones que quieran ayudar a sus alumnos a mantenerse al dia.
                    ¡Todo esto, solo en DOA.!</p>

                <a class="btn-demo" onclick="seleccionarPlan('Plan estándar (5000€)')" >Seleccionar plan</a>
            </div>
        </div>
    </section>
    <section class="formulario_compra">
        <h2 class="titulo_dos">Formulario compra</h2>
        <div class="caja-compra">
            <input type="text" placeholder="Nombre institución" required>
            <input type="email" placeholder="Correo electrónico" required>
            <input type="text" placeholder="Subdominio(Solo letras y números)" required>
            <p id="plan-seleccionado"></p>
            <button type="button" class="boton-compra">Confirmar compra</button>
        </div>
    </section>
    <script>
        function seleccionarPlan(nombre) {
            const el = document.getElementById('plan-seleccionado');
            el.textContent = 'Plan seleccionado: ' + nombre;
            el.style.display = 'block';
            document.querySelector('.formulario_compra').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>