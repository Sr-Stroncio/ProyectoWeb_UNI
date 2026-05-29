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
                <p class="perfil-saludo">Bienvenido/a, <?= $_SESSION['usuario_nombre'] ?></p>
                <span class="perfil-rol"><?= $_SESSION['usuario_rol'] ?></span>
            </div>
            <a class="btn-logout" href="/utils/logout-producto.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<div class="overlay" id="overlay"></div>
