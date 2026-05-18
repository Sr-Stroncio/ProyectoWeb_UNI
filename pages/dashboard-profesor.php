<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /pages/log-in-producto.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard-profesor.css">
    <title>Dashboard profesor</title>
</head>
<body>

<header>
    <div class="div-izquierdo">
        <button class="btn-menu" id="btnMenu">
            <img src="assets/icons/menu.svg" alt="menu">
        </button>
        <div class="div-logos">
            <img class="DOA_logo" src="assets/DoA color.svg" alt="DOA Logo">
            <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
        </div>
        <h2>Dashboard</h2>
    </div>

    <div class="div-nav">
        <div class="perfil">
            <div class="perfil-info">
                <p class="perfil-saludo">Bienvenido/a, <?= $_SESSION['nombre'] ?></p>
                <span class="perfil-rol"><?= $_SESSION['rol'] ?></span>
            </div>
            <a class="btn-logout" href="/utils/logout-producto.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<div class="overlay" id="overlay"></div>

<section class="section-principal">

    <?php include '../components/sidebar-profesor.php'; ?>

    <main>

    <main>
        <!-- anuncios -->
        <div class="bloque">
            <div class="bloque-cabecera">
                <h3>Anuncios</h3>
                <a class="btn-nuevo" href="/pages/anuncios-profesor.php">+ Nuevo anuncio</a>
            </div>

            <div class="anuncio-card">
                <div class="anuncio-top">
                    <span class="anuncio-asig">Programación</span>
                    <span class="anuncio-tiempo">Hace 2h</span>
                </div>
                <p class="anuncio-titulo">Examen parcial – cambio de fecha</p>
                <p class="anuncio-desc">El examen del día 20 se traslada al 22 de mayo.</p>
                <div class="anuncio-botones">
                    <button class="btn-icono">
                        <img src="assets/icons/edit.svg" alt="editar">
                    </button>
                    <button class="btn-icono btn-borrar">
                        <img src="assets/icons/delete.svg" alt="borrar">
                    </button>
                </div>
            </div>

            <div class="anuncio-card">
                <div class="anuncio-top">
                    <span class="anuncio-asig">Bases de Datos</span>
                    <span class="anuncio-tiempo">Ayer</span>
                </div>
                <p class="anuncio-titulo">Material adicional unidad 3</p>
                <p class="anuncio-desc">He subido los apuntes de la sesión del martes.</p>
                <div class="anuncio-botones">
                    <button class="btn-icono">
                        <img src="assets/icons/edit.svg" alt="editar">
                    </button>
                    <button class="btn-icono btn-borrar">
                        <img src="assets/icons/delete.svg" alt="borrar">
                    </button>
                </div>
            </div>

            <div class="anuncio-card">
                <div class="anuncio-top">
                    <span class="anuncio-asig">HCI</span>
                    <span class="anuncio-tiempo">Hace 3d</span>
                </div>
                <p class="anuncio-titulo">Recordatorio entrega prototipo</p>
                <p class="anuncio-desc">Fecha límite el 20 de mayo a las 23:59.</p>
                <div class="anuncio-botones">
                    <button class="btn-icono">
                        <img src="assets/icons/edit.svg" alt="editar">
                    </button>
                    <button class="btn-icono btn-borrar">
                        <img src="assets/icons/delete.svg" alt="borrar">
                    </button>
                </div>
            </div>
        </div>

        <!-- vista general -->
        <div class="bloque">
            <div class="bloque-cabecera">
                <h3>Vista General</h3>
            </div>

            <div class="stats-fila">
                <div class="stat-card">
                    <p class="stat-label">POR CORREGIR</p>
                    <p class="stat-num rojo">13</p>
                    <p class="stat-sub">entregas sin revisar</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">TAREAS ACTIVAS</p>
                    <p class="stat-num">5</p>
                    <p class="stat-sub">en 3 asignaturas</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">CLASES ESTA SEMANA</p>
                    <p class="stat-num">6</p>
                    <p class="stat-sub">próxima: hoy 10:00</p>
                </div>
            </div>

            <div class="dos-col">
                <div class="col-bloque">
                    <p class="col-titulo">COLA DE CORRECCIÓN</p>

                    <div class="correccion-fila">
                        <div class="avatar">L</div>
                        <div>
                            <p class="nombre-alumno">Lief Simants</p>
                            <p class="sub-alumno">Práctica 3 · Programación</p>
                        </div>
                        <div class="fila-derecha">
                            <span class="tiempo-entrega">Hace 1h</span>
                            <button class="btn-corregir">Corregir</button>
                        </div>
                    </div>

                    <div class="correccion-fila">
                        <div class="avatar">M</div>
                        <div>
                            <p class="nombre-alumno">Merline Kirdsch</p>
                            <p class="sub-alumno">Tarea SQL · BD</p>
                        </div>
                        <div class="fila-derecha">
                            <span class="tiempo-entrega">Hace 2h</span>
                            <button class="btn-corregir">Corregir</button>
                        </div>
                    </div>

                    <div class="correccion-fila">
                        <div class="avatar">D</div>
                        <div>
                            <p class="nombre-alumno">Debora Rawstorne</p>
                            <p class="sub-alumno">Entrega P2 · HCI</p>
                        </div>
                        <div class="fila-derecha">
                            <span class="tiempo-entrega">Hace 4h</span>
                            <button class="btn-corregir">Corregir</button>
                        </div>
                    </div>

                    <div class="correccion-fila">
                        <div class="avatar">K</div>
                        <div>
                            <p class="nombre-alumno">Kevan Pounds</p>
                            <p class="sub-alumno">Práctica 3 · Programación</p>
                        </div>
                        <div class="fila-derecha">
                            <span class="tiempo-entrega">Ayer</span>
                            <button class="btn-corregir">Corregir</button>
                        </div>
                    </div>
                </div>

                <div class="col-bloque">
                    <p class="col-titulo">AGENDA DE HOY</p>

                    <div class="agenda-fila">
                        <div class="agenda-hora">
                            <span class="hora">10:00</span>
                            <span class="duracion">2h</span>
                        </div>
                        <div>
                            <p class="nombre-alumno">Clase Programación</p>
                            <p class="sub-alumno">A-204</p>
                        </div>
                    </div>

                    <div class="agenda-fila">
                        <div class="agenda-hora">
                            <span class="hora">12:30</span>
                            <span class="duracion">30m</span>
                        </div>
                        <div>
                            <p class="nombre-alumno">Tutoría — Lief Simants</p>
                            <p class="sub-alumno">B-101</p>
                        </div>
                    </div>

                    <div class="agenda-fila">
                        <div class="agenda-hora">
                            <span class="hora">16:00</span>
                            <span class="duracion">2h</span>
                        </div>
                        <div>
                            <p class="nombre-alumno">Clase Bases de Datos</p>
                            <p class="sub-alumno">A-110</p>
                        </div>
                    </div>

                    <div class="agenda-fila">
                        <div class="agenda-hora">
                            <span class="hora">18:00</span>
                            <span class="duracion">1h</span>
                        </div>
                        <div>
                            <p class="nombre-alumno">Reunión departamento</p>
                            <p class="sub-alumno">Sala 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</section>

<script src="js/dashboard-profesor.js"></script>
</body>
</html>
