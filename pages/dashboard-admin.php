<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /pages/log-in-producto.php');
    exit;
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    switch ($_SESSION['rol']) {
        case 'profesor':
            header('Location: /pages/dashboard-profesor.php');
            break;
        case 'alumno':
            header('Location: /pages/dashboard-alumno.php');
            break;
        default:
            header('Location: /pages/log-in-producto.php');
    }
    exit;
}

$tituloPagina = 'Dashboard';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/header-profesor.css">
    <link rel="stylesheet" href="css/dashboard-admin.css">
    <title>Dashboard administrador</title>
</head>
<body>

<header>
    <div class="div-izquierdo">
        <button class="btn-menu" id="btnMenu">
            <img src="assets/iconos/menu-2.svg" alt="menu">
        </button>
        <div class="div-logos">
            <img class="DOA_logo" src="assets/DoA color.svg" alt="DOA Logo">
            <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
        </div>
        <h2><?= $tituloPagina ?? 'Dashboard' ?></h2>
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

    <aside id="sidebar">

        <div class="sidebar-grupo">
            <p class="sidebar-label">PRINCIPAL</p>
            <ul class="sidebar-nav">
                <li class="nav-item activo">
                    <img src="assets/iconos/home.svg" alt="" class="nav-icon">
                    Inicio
                </li>
            </ul>
        </div>

        <hr class="separador">

        <div class="sidebar-grupo">
            <p class="sidebar-label">ADMINISTRACIÓN</p>
            <ul class="sidebar-nav">
                <li class="nav-item nav-item-link-wrap">
                    <a class="nav-item-link" href="/pages/grados-admin.php">
                        <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                        Grados
                    </a>
                </li>
                <li class="nav-item nav-item-link-wrap">
                    <a class="nav-item-link" href="/pages/alumnos-admin.php">
                        <img src="assets/iconos/user-circle.svg" alt="" class="nav-icon">
                        Alumnos
                    </a>
                </li>
                <li class="nav-item nav-item-link-wrap">
                    <a class="nav-item-link" href="/pages/profesores-admin.php">
                        <img src="assets/iconos/school.svg" alt="" class="nav-icon">
                        Profesores
                    </a>
                </li>
                <li class="nav-item nav-item-link-wrap">
                    <a class="nav-item-link" href="/pages/anuncios-admin.php">
                        <img src="assets/iconos/speakerphone.svg" alt="" class="nav-icon">
                        Anuncios
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-img">
            <img src="img/sidebar-img.png" alt="imagen">
        </div>

    </aside>

    <main>

        <!-- vista general -->
        <div class="bloque">
            <div class="bloque-cabecera">
                <h3>Vista General</h3>
            </div>

            <div class="stats-fila">
                <div class="stat-card">
                    <p class="stat-label">ALUMNOS REGISTRADOS</p>
                    <p class="stat-num">248</p>
                    <p class="stat-sub">en toda la institución</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">PROFESORES REGISTRADOS</p>
                    <p class="stat-num">31</p>
                    <p class="stat-sub">activos este ciclo</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">GRADOS EXISTENTES</p>
                    <p class="stat-num">12</p>
                    <p class="stat-sub">grupos activos</p>
                </div>
            </div>
        </div>

        <!-- gestión -->
        <div class="bloque">
            <div class="bloque-cabecera">
                <h3>Gestión</h3>
            </div>

            <div class="gestion-grid">

                <a href="/pages/grados-admin.php" class="gestion-card">
                    <div class="gestion-icono">
                        <img src="assets/iconos/book.svg" alt="Grados">
                    </div>
                    <div class="gestion-info">
                        <p class="gestion-titulo">Grados</p>
                        <p class="gestion-desc">Administra los grupos y niveles académicos de la institución</p>
                    </div>
                    <span class="gestion-flecha">›</span>
                </a>

                <a href="/pages/alumnos-admin.php" class="gestion-card">
                    <div class="gestion-icono">
                        <img src="assets/iconos/user-circle.svg" alt="Alumnos">
                    </div>
                    <div class="gestion-info">
                        <p class="gestion-titulo">Alumnos</p>
                        <p class="gestion-desc">Consulta y gestiona el registro de estudiantes de la plataforma</p>
                    </div>
                    <span class="gestion-flecha">›</span>
                </a>

                <a href="/pages/profesores-admin.php" class="gestion-card">
                    <div class="gestion-icono">
                        <img src="assets/iconos/school.svg" alt="Profesores">
                    </div>
                    <div class="gestion-info">
                        <p class="gestion-titulo">Profesores</p>
                        <p class="gestion-desc">Gestiona el personal docente y sus asignaciones de asignaturas</p>
                    </div>
                    <span class="gestion-flecha">›</span>
                </a>

                <a href="/pages/anuncios-admin.php" class="gestion-card">
                    <div class="gestion-icono">
                        <img src="assets/iconos/speakerphone.svg" alt="Anuncios">
                    </div>
                    <div class="gestion-info">
                        <p class="gestion-titulo">Anuncios</p>
                        <p class="gestion-desc">Publica y administra comunicados para toda la comunidad educativa</p>
                    </div>
                    <span class="gestion-flecha">›</span>
                </a>

            </div>
        </div>

    </main>

</section>

<script src="js/header-profesor.js"></script>
</body>
</html>
