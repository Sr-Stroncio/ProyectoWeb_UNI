<aside id="sidebar">
    <div class="sidebar-grupo">
        <p class="sidebar-label">PRINCIPAL</p>
        <ul class="sidebar-nav">
            <li class="nav-item nav-item-link-wrap <?= $seccion === null ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-admin.php">
                    <img src="assets/iconos/home.svg" alt="" class="nav-icon">
                    Inicio
                </a>
            </li>
        </ul>
    </div>

    <hr class="separador">

    <div class="sidebar-grupo">
        <p class="sidebar-label">ADMINISTRACIÓN</p>
        <ul class="sidebar-nav">
            <li class="nav-item nav-item-link-wrap <?= $seccion == 'grados' ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-admin.php?seccion=grados">
                    <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                    Grados
                </a>
            </li>
            <li class="nav-item nav-item-link-wrap <?= $seccion == 'alumnos' ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-admin.php?seccion=alumnos">
                    <img src="assets/iconos/user-circle.svg" alt="" class="nav-icon">
                    Alumnos
                </a>
            </li>
            <li class="nav-item nav-item-link-wrap <?= $seccion == 'profesores' ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-admin.php?seccion=profesores">
                    <img src="assets/iconos/school.svg" alt="" class="nav-icon">
                    Profesores
                </a>
            </li>
            <li class="nav-item nav-item-link-wrap <?= $seccion == 'anuncios' ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-admin.php?seccion=anuncios">
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
