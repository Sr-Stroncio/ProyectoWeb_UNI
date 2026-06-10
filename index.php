<?php
session_start();

require_once __DIR__ . "/utils/rutas.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?= $base_url ?>">

    <link rel="stylesheet" href="css/lading_page.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">

    <title>Landing page</title>
</head>

<body>

    <!-- barra de navegacion dentro de la landing page -->
    <?php include __DIR__ . "/components/header.php"; ?>

    <section id="home" class="hero-section">
        <div class="hero-contenido">
            <h1>
                Productos esteticos para
                <span>aquellos que innovan</span>
            </h1>

            <div>
                <?php if (isset($_SESSION['empresa_usuario'])): ?>
                    <a class="btn-demo" href="pages/pagina_servicios.php">
                        Productos
                    </a>
                <?php else: ?>
                    <p>Registrate para probar nuestras demos abiertas completamente gratis</p>
                    <a class="btn-demo" href="pages/registro.php">
                        Registro
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="hero-img">
            <img src="img/hero-img.jpg" alt="hero-img">

            <div>
                <?php if (isset($_SESSION['empresa_usuario'])): ?>
                    <a class="btn-demo" href="pages/pagina_servicios.php">
                        Productos
                    </a>
                <?php else: ?>
                    <p>Registrate para probar nuestras demos abiertas completamente gratis</p>
                    <a class="btn-demo" href="pages/registro.php">
                        Registro
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="sobre-nosotros" class="section-sobre-nosotros">

        <div class="sobre-nosotros-div-pregunta">
            <h2>Que es <span>GTI</span></h2>
            <img class="atlas-informacion" src="img/atlas.jpg" alt="Atlas-img">
        </div>

        <div class="sobre-nosotros-div-informacion">

            <div class="div-informativo">
                <div>
                    <h3>Soluciones web para diferentes sectores</h3>
                    <p>
                        En GTI desarrollamos aplicaciones web adaptadas a las necesidades
                        de empresas, instituciones y organizaciones.
                    </p>
                </div>
                <img src="img/nivel.jpg" alt="">
            </div>

            <div class="div-informativo">
                <div>
                    <h3>Tecnología pensada para cada proyecto</h3>
                    <p>
                        Creamos herramientas digitales para optimizar procesos,
                        mejorar la organización y facilitar la gestión diaria.
                    </p>
                </div>
                <img src="img/comunicacion.jpg" alt="">
            </div>

            <div class="div-informativo">
                <div>
                    <h3>Diseño funcional y experiencia clara</h3>
                    <p>
                        Nuestras aplicaciones combinan utilidad, accesibilidad y una interfaz cuidada
                        para ofrecer una experiencia sencilla desde el primer uso.
                    </p>
                </div>
                <img src="img/estetica.jpg" alt="">
            </div>

        </div>
    </section>

    <section id="servicios" class="last-section">
        <div class="last-img">
            <img src="img/footer-img_2.jpg" alt="footer-img-2">
        </div>

        <div class="last-content">
            <div class="last-text">
                <h3>No esperes más</h3>
                <p>
                    Descubre todo lo que nuestra plataforma puede hacer por tu empresa,
                    elige el producto que mejor se adapte a ti y accede a la demo.
                </p>
            </div>

            <a class="last-btn" href="pages/pagina_servicios.php">
                Página de productos
            </a>
        </div>

        <div class="last-img">
            <img src="img/footer-img.jpg" alt="footer-img-1">
        </div>
    </section>

</body>

</html>