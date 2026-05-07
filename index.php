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
    <header>
        <div class="div-logos">
            <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
            <img class="DOA_logo" src="assets/DoA color.svg" alt="DOA Logo">
        </div>

        <nav>
            <a href="#">Servicios</a>
            <a href="#home">Home</a>
            <a href="#sobre-nosotros">Sobre nosotros</a>
        </nav>

        <!-- redireccion hacia la pagina de servicios -->
        <a class="btn-empezar" href="#">
            Inicia sesion
        </a>
    </header>

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
                <a class="btn-demo" href="pages/registro_lading.php">
                    Resgistro
                </a>
            </div>
        </div>

        <div class="hero-img">
            <img src="img/hero-img.jpg" alt="hero-img">
            <div>
                <p>Registrate para probar nuestra demo abierta completamente gratis</p>
                <a class="btn-demo" href="#">
                    Resgistro
                </a>
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

    <section>

    </section>

    <footer>

    </footer>
    
</body>

</html>