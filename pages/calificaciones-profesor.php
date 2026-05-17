<?php
session_start();

// si no hay sesion activa, vuelve al login
if (!isset($_SESSION['usuario'])) {
    header('Location: /pages/log-in-producto.php');
    exit;
}

// if ($_SESSION['rol'] !== 'profesor') {
//     header('Location: /pages/log-in-producto.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/calificaciones-profesor.css">
    <title>Calificaciones — Profesor</title>
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
        <h2>Calificaciones</h2>
    </div>

    <div class="div-centro">
        <button class="btn-nuevo" id="btnNuevaCalif">+ Nueva calificación</button>
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

<div class="modal-fondo" id="modalFondo">
    <div class="modal">
        <div class="modal-cabecera">
            <h3 id="modalTitulo">Editar calificación</h3>
            <button class="modal-cerrar" id="modalCerrar">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Alumno</label>
            <input class="campo-input" type="text" id="inputAlumno" placeholder="Nombre completo">

            <div class="notas-fila">
                <div class="nota-grupo">
                    <label class="campo-label">Parcial 1</label>
                    <input class="campo-input" type="number" id="inputP1" placeholder="—" min="0" max="10" step="0.1">
                </div>
                <div class="nota-grupo">
                    <label class="campo-label">Parcial 2</label>
                    <input class="campo-input" type="number" id="inputP2" placeholder="—" min="0" max="10" step="0.1">
                </div>
                <div class="nota-grupo">
                    <label class="campo-label">Final</label>
                    <input class="campo-input" type="number" id="inputFinal" placeholder="—" min="0" max="10" step="0.1">
                </div>
            </div>

            <div class="media-preview">
                <span class="media-label">Media calculada</span>
                <span class="media-valor" id="mediaPreview">—</span>
            </div>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar" id="btnBorrarAlumno">Eliminar alumno</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelar">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<section class="section-principal">

    <aside id="sidebar">
        <div class="sidebar-grupo">
            <p class="sidebar-label">PRINCIPAL</p>
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <img src="assets/icons/home.svg" alt="" class="nav-icon">
                    Inicio
                </li>
                <li class="nav-item">
                    <img src="assets/icons/calendar.svg" alt="" class="nav-icon">
                    Calendario
                </li>
            </ul>
        </div>

        <hr class="separador">

        <div class="sidebar-grupo">
            <p class="sidebar-label">UTILIDADES</p>
            <ul class="sidebar-nav">
                <li class="nav-item activo">
                    <img src="assets/icons/grade.svg" alt="" class="nav-icon">
                    Calificaciones
                </li>
                <li class="nav-item">
                    <img src="assets/icons/task.svg" alt="" class="nav-icon">
                    Tareas
                </li>
                <li class="nav-item">
                    <img src="assets/icons/announcement.svg" alt="" class="nav-icon">
                    Anuncios
                </li>
                <li class="nav-item">
                    <img src="assets/icons/chat.svg" alt="" class="nav-icon">
                    Chats
                </li>
            </ul>
        </div>

        <hr class="separador">

        <div class="sidebar-grupo">
            <p class="sidebar-label">MIS ASIGNATURAS</p>
            <ul class="sidebar-nav">
                <li class="nav-item nav-asig" data-id="prog">
                    <img src="assets/icons/book.svg" alt="" class="nav-icon">
                    Programación
                    <span class="chevron">&#8250;</span>
                </li>
                <ul class="submenu" id="sub-prog">
                    <li class="nav-item nav-sub">Recursos</li>
                    <li class="nav-item nav-sub">Exámenes</li>
                    <li class="nav-item nav-sub">Tareas</li>
                </ul>

                <li class="nav-item nav-asig" data-id="bd">
                    <img src="assets/icons/book.svg" alt="" class="nav-icon">
                    Bases de Datos
                    <span class="chevron">&#8250;</span>
                </li>
                <ul class="submenu" id="sub-bd">
                    <li class="nav-item nav-sub">Recursos</li>
                    <li class="nav-item nav-sub">Exámenes</li>
                    <li class="nav-item nav-sub">Tareas</li>
                </ul>

                <li class="nav-item nav-asig" data-id="hci">
                    <img src="assets/icons/book.svg" alt="" class="nav-icon">
                    HCI
                    <span class="chevron">&#8250;</span>
                </li>
                <ul class="submenu" id="sub-hci">
                    <li class="nav-item nav-sub">Recursos</li>
                    <li class="nav-item nav-sub">Exámenes</li>
                    <li class="nav-item nav-sub">Tareas</li>
                </ul>
            </ul>
        </div>

        <div class="sidebar-img">
            <img src="img/sidebar-img.png" alt="imagen">
        </div>
    </aside>

    <main>
        <div class="main-cabecera">
            <div>
                <h2>Calificaciones</h2>
                <p class="main-sub" id="subtitulo">Programación · 28 alumnos</p>
            </div>
            <div class="pills">
                <button class="pill activo" data-asig="prog">Programación</button>
                <button class="pill" data-asig="bd">Bases de Datos</button>
                <button class="pill" data-asig="hci">HCI</button>
            </div>
        </div>

        <div class="tabla-wrapper">
            <div class="tabla-top">
                <span class="tabla-titulo">REGISTRO DE NOTAS</span>
                <div class="tabla-acciones">
                    <button class="btn-accion" id="btnExportarCSV">Exportar CSV</button>
                    <button class="btn-accion" id="btnOrdenar">Ordenar ↕</button>
                </div>
            </div>
            <div class="tabla-cabecera">
                <span class="col-alumno">ALUMNO</span>
                <span class="col-nota">PARCIAL 1</span>
                <span class="col-nota">PARCIAL 2</span>
                <span class="col-nota">FINAL</span>
                <span class="col-media">MEDIA</span>
                <span class="col-accion"></span>
            </div>
            <div id="cuerpoTabla"></div>
        </div>
    </main>

</section>

<script src="js/dashboard-profesor.js"></script>
<script src="js/calificaciones-profesor.js"></script>
</body>
</html>