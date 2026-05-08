<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/lading_page.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <title>Lading page</title>
    <base href="/">
</head>

<body>

    <!-- barra de navegacion dentro de la lading page-->
    <?php include 'components/header.php'; ?>

    <!-- este apartado sera la primera parte de la pagina lo primero que ve el cliente al entrar en esta misma,
    le puse hero pues asi es llamada comunmente -->

    <section id="home" class="hero-section">
        <div class="hero-contenido">
            <h1>
                Una estructura estetica para
                <span>universidades que innovan</span>
            </h1>
            <div>
                <p>Registrate para probar nuestra demo abierta completamente gratis</p>
                <?php if (isset($_SESSION['empresa_usuario'])): ?>
                    <a class="btn-demo" href="/pages/log-in-producto.php">
                        Demo
                    </a>
                <?php else: ?>
                    <a class="btn-demo" href="/pages/registro_lading.php">
                        Registro
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="hero-img">
            <img src="img/hero-img.jpg" alt="hero-img">
            <div>
                <p>Registrate para probar nuestra demo abierta completamente gratis</p>
                <?php if (isset($_SESSION['empresa_usuario'])): ?>
                    <a class="btn-demo" href="/pages/log-in-producto.php">
                        Demo
                    </a>
                <?php else: ?>
                    <a class="btn-demo" href="/pages/registro_lading.php">
                        Registro
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- seccion de informacion general sobre DOA   -->

    <section id="sobre-nosotros" class="section-sobre-nosotros">

        <div class="sobre-nosotros-div-pregunta">
            <h2>Que es <span>DOA?</span></h2>
            <img class="atlas-informacion" src="img/atlas.jpg" alt="Atlas-img">
        </div>

        <div class="sobre-nosotros-div-informacion">

            <div class="div-informativo">
                <div>
                    <h3>Centraliza la gestion academica</h3>
                    <p>
                        Organiza recursos, procesos y seguimientos
                        en un solo lugar con DOA.
                    </p>
                </div>
                <img src="img/nivel.jpg" alt="">
            </div>


            <div class="div-informativo">
                <div>
                    <h3>Mejora la comunicacion</h3>
                    <p>
                        Facilita la conexion entre instutucion, profesorado y alumno
                        con una experiencia clara, accesible y ordenada.
                    </p>
                </div>
                <img src="img/comunicacion.jpg" alt="">
            </div>


            <div class="div-informativo">
                <div>
                    <h3>Una experiencia estetica</h3>
                    <p>
                        Proyecta orden, innovacion y confiaza desde el primer vistazo.
                    </p>
                </div>
                <img src="img/estetica.jpg" alt="">
            </div>

        </div>
    </section>

    <!-- ultimo apartado de la pagina -->

    <section id="servicios" class="last-section">
        <div class="last-img">
            <img src="img/footer-img_2.jpg" alt="footer-img-2">
        </div>

        <div class="last-content">
            <div class="last-text">
                <h3>No esperes más</h3>
                <p>
                    Descubre todo lo que nuestra plataforma puede hacer por tu centro,
                    accede a la demo y elige el plan que mejor se adapte a ti.
                </p>
            </div>
            <a class="last-btn" href="pages/pagina_servicios.php">Página de servicios</a>
        </div>

        <div class="last-img">
            <img src="img/footer-img.jpg" alt="footer-img-1">
        </div>
    </section>

</body>

</html>