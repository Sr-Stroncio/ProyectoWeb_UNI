<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Por defecto, el logo lleva al inicio
$enlace_doa = "index.php";

// Si hay usuario DOA conectado, mandamos a su dashboard
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === 'admin') {
        $enlace_doa = "pages/dashboard-admin.php";
    } elseif ($_SESSION['rol'] === 'profesor') {
        $enlace_doa = "pages/dashboard-profesor.php";
    } elseif ($_SESSION['rol'] === 'alumno') {
        $enlace_doa = "pages/dashboard-alumno.php";
    }
}
?>

<header>
    <div class="div-logos">
        <a href="<?= $enlace_doa ?>">
            <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
        </a>
    </div>

    <nav>
        <a href="pages/pagina_servicios.php">Productos</a>
    </nav>

    <div class="header-empresa">
        <?php if (isset($_SESSION['empresa_usuario'])): ?>

            <div class="empresa-info">
                <p class="nombre-empresa">
                    <?= htmlspecialchars($_SESSION['empresa_nombre']) ?>
                </p>
            </div>

            <a class="btn-logout-empresa" href="utils/logout-empresa.php">
                Cerrar sesión
            </a>

        <?php else: ?>

            <a class="btn-empezar" href="pages/log-in-app.php">
                Inicia sesión
            </a>

        <?php endif; ?>
    </div>
</header>