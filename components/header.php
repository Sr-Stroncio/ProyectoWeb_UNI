<header>
    <div class="div-logos">
        <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
        <img class="DOA_logo" src="assets/DoA color.svg" alt="DOA Logo">
    </div>

    <nav>
        <a href="/pages/pagina_servicios.php">Servicios</a>
        <a href="/#home">Home</a>
        <a href="/#sobre-nosotros">Sobre nosotros</a>
    </nav>

    <div class="header-empresa">
        <?php if (isset($_SESSION['empresa_usuario'])): ?>

            <div class="empresa-info">
                <p class="nombre-empresa">
                    <?= htmlspecialchars($_SESSION['empresa_nombre']) ?>
                </p>
            </div>

            <a class="btn-logout-empresa" href="/utils/logout-empresa.php">
                Cerrar sesión
            </a>

        <?php else: ?>

            <a class="btn-empezar" href="/pages/log-in-app.php">
                Inicia sesión
            </a>

        <?php endif; ?>
    </div>
</header>