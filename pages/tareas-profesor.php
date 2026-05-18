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
    <link rel="stylesheet" href="css/tareas-profesor.css">
    <title>Tareas — Profesor</title>
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
        <h2>Tareas</h2>
    </div>

    <div class="div-centro">
        <button class="btn-nuevo" id="btnNuevaTarea">+ Nueva tarea</button>
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
            <h3 id="modalTitulo">Nueva tarea</h3>
            <button class="modal-cerrar" id="modalCerrar">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Nombre de la tarea</label>
            <input class="campo-input" type="text" id="inputNombre" placeholder="Ej: Práctica 3 — Algoritmos">

            <label class="campo-label">Asignatura</label>
            <select class="campo-input" id="inputAsig">
                <option value="Programación">Programación</option>
                <option value="BD">Bases de Datos</option>
                <option value="HCI">HCI</option>
            </select>

            <label class="campo-label">Fecha de cierre</label>
            <input class="campo-input" type="date" id="inputCierre">

            <label class="campo-label">Total de alumnos</label>
            <input class="campo-input" type="number" id="inputTotal" placeholder="Ej: 28" min="1">

            <label class="campo-label">Descripción</label>
            <textarea class="campo-input campo-textarea" id="inputDesc" placeholder="Instrucciones de la tarea..."></textarea>

            <label class="campo-label">Estado</label>
            <select class="campo-input" id="inputEstado">
                <option value="futura">Futura</option>
                <option value="abierta">Abierta</option>
                <option value="cerrada">Cerrada</option>
            </select>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar" id="btnBorrarTarea">Eliminar tarea</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelar">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<section class="section-principal">

    <?php include '../components/sidebar-profesor.php'; ?>

    <main>

    <main>
        <div class="main-cabecera">
            <h2>Tareas</h2>
            <p class="main-sub">Todas las asignaturas</p>
        </div>

        <div class="filtros">
            <button class="filtro activo" data-filtro="todas">Todas</button>
            <button class="filtro" data-filtro="abierta">Abiertas</button>
            <button class="filtro" data-filtro="cerrada">Cerradas</button>
            <button class="filtro" data-filtro="futura">Futuras</button>
        </div>

        <div class="tabla-wrapper">
            <div class="tabla-cabecera">
                <span class="col-tarea">TAREA</span>
                <span class="col-asig">ASIGNATURA</span>
                <span class="col-cierre">CIERRE</span>
                <span class="col-entregas">ENTREGAS</span>
                <span class="col-estado">ESTADO</span>
                <span class="col-accion"></span>
            </div>
            <div id="cuerpoTabla"></div>
        </div>
    </main>

</section>

<script src="js/dashboard-profesor.js"></script>
<script src="js/tareas-profesor.js"></script>
</body>
</html>