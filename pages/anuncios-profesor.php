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
    <link rel="stylesheet" href="css/anuncios-profesor.css">
    <title>Anuncios — Profesor</title>
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
        <h2>Anuncios</h2>
    </div>

    <div class="div-centro">
        <button class="btn-nuevo" id="btnNuevoAnuncio">+ Nuevo anuncio</button>
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
            <h3 id="modalTitulo">Nuevo anuncio</h3>
            <button class="modal-cerrar" id="modalCerrar">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Título</label>
            <input class="campo-input" type="text" id="inputTitulo" placeholder="Ej: Cambio de aula">

            <label class="campo-label">Descripción</label>
            <textarea class="campo-input campo-textarea" id="inputDesc" placeholder="Escribe el contenido del anuncio..."></textarea>

            <label class="campo-label">Asignatura</label>
            <select class="campo-input" id="inputAsig">
                <option value="Programación">Programación</option>
                <option value="BD">Bases de Datos</option>
                <option value="HCI">HCI</option>
            </select>

            <label class="campo-label">Tipo</label>
            <select class="campo-input" id="inputTipo">
                <option value="mios">Asignatura</option>
                <option value="general">General</option>
            </select>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar oculto" id="btnBorrarAnuncio">Eliminar anuncio</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelar">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardar">Publicar</button>
            </div>
        </div>
    </div>
</div>

<section class="section-principal">

    <?php include '../components/sidebar-profesor.php'; ?>

    <main>
        <div class="main-cabecera">
            <h2>Anuncios</h2>
        </div>

        <div class="filtros">
            <button class="filtro activo" data-filtro="todos">Todos</button>
            <button class="filtro" data-filtro="mios">Mis anuncios</button>
            <button class="filtro" data-filtro="general">General</button>
        </div>

        <div class="lista-anuncios" id="listaAnuncios"></div>
    </main>

</section>

<script src="js/dashboard-profesor.js"></script>
<script src="js/anuncios-profesor.js"></script>
</body>
</html>