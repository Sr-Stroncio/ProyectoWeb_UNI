<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head class="header">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Página de compra</title>
    <base href="/">
    <link rel="stylesheet" href="css/pagina_servicios.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">

</head>

<body>

    <?php include '../components/header.php'; ?>
    <!-- seleccionar plan -->

    <section>
        <h2 class="titulo_dos">Seleccionar producto</h2>
        <div class="seleccionar_producto">
            <!-- caja plan estándar -->
            <div class="caja">
                <img class="GTI_logo" src="assets/DoA color.svg" alt="DOA">
                <p class="producto-etiqueta">DOA</p>
                <p class="producto-precio">5.000 €</p>
                <p class="producto-nota">Pago único · Licencia institucional</p>
                <hr class="separador">
                <p class="producto-tagline">Todo lo que necesitas para el día a día educativo, en un solo lugar.</p>
                <p class="producto-incluye-titulo">Incluye</p>
                <ul class="producto-lista">
                    <li>
                        <p class="producto-li-titulo">Tres roles diferenciados</p>
                        <p class="producto-li-sub">Alumno, Profesor y Administrador, cada uno con sus propias acciones y vistas.</p>
                    </li>
                    <li>
                        <p class="producto-li-titulo">Módulos completos por rol</p>
                        <p class="producto-li-sub">Anuncios, calendario y asignaturas con calificaciones, tareas, recursos y exámenes.</p>
                    </li>
                    <li>
                        <p class="producto-li-titulo">Ecosistema 100 % online</p>
                        <p class="producto-li-sub">Alumnos y docentes siempre actualizados, sin necesidad de presencia física.</p>
                    </li>
                    <li>
                        <p class="producto-li-titulo">Ideal para instituciones educativas</p>
                        <p class="producto-li-sub">Diseñado para centros que quieren mantener a sus alumnos al día.</p>
                    </li>
                </ul>
                <hr class="separador">
                <a class="btn-demo" onclick="seleccionarProducto('Producto estándar (5000€)')">Seleccionar producto</a>
            </div>

            <!-- caja prueba -->
            <div class="caja">
                <img class="GTI_logo" src="assets/DoA color.svg" alt="DOA">
                <p class="producto-etiqueta">Prueba gratuita</p>
                <p class="producto-precio">Gratis</p>
                <p class="producto-nota">Sin compromiso · Sin tarjeta</p>
                <hr class="separador">
                <p class="producto-tagline">Prueba DOA sin compromiso y comprueba todo lo que puede hacer por tu institución.</p>
                <p class="producto-incluye-titulo">Incluye</p>
                <ul class="producto-lista">
                    <li>
                        <p class="producto-li-titulo">Acceso completo a la plataforma</p>
                        <p class="producto-li-sub">Explora todas las funcionalidades antes de elegir un producto.</p>
                    </li>
                    <li>
                        <p class="producto-li-titulo">Todos los roles disponibles</p>
                        <p class="producto-li-sub">Prueba la experiencia de Alumno, Profesor y Administrador.</p>
                    </li>
                    <li>
                        <p class="producto-li-titulo">Sin tarjeta ni contrato</p>
                        <p class="producto-li-sub">Completamente gratis, empieza en segundos.</p>
                    </li>
                </ul>
                <hr class="separador">
                <a href="/pages/log-in-producto.php" class="btn-demo btn-demo-secundario">Ir a la prueba</a>
            </div>
        </div>
    </section>
    <!--<section class="formulario_compra">
        <h2 class="titulo_dos">Formulario compra</h2>
        <div class="caja-compra">
            <input type="text" placeholder="Nombre institución" required>
            <input type="email" placeholder="Correo electrónico" required>
            <input type="text" placeholder="Subdominio(Solo letras y números)" required>
            <p id="plan-seleccionado"></p>
            <button type="button" class="boton-compra">Confirmar compra</button>
        </div>
    </section>
    formulario de compra que falta acabar de implementar.-->
    <!--<script>
        function seleccionarPlan(nombre) {
            const el = document.getElementById('plan-seleccionado');
            el.textContent = 'Plan seleccionado: ' + nombre;
            el.style.display = 'block';
            document.querySelector('.formulario_compra').scrollIntoView({ behavior: 'smooth' });
        }
    </script>-->
</body>

</html>