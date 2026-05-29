<aside id="sidebar">
    <div class="sidebar-grupo">
        <p class="sidebar-label">PRINCIPAL</p>
        <ul class="sidebar-nav">
            <li class="nav-item nav-item-link-wrap <?= $seccion === 'inicio' ? 'activo' : '' ?>">
                <a class="nav-item-link" href="/pages/dashboard-profesor.php">
                    <img src="assets/iconos/home.svg" alt="" class="nav-icon">
                    Inicio
                </a>
            </li>
            <li class="nav-item nav-item-link-wrap">
                <a class="nav-item-link" href="/pages/dashboard-profesor.php#calendario">
                    <img src="assets/iconos/calendar.svg" alt="" class="nav-icon">
                    Calendario
                </a>
            </li>
        </ul>
    </div>

    <hr class="separador">

    <div class="sidebar-grupo">
        <p class="sidebar-label">UTILIDADES</p>
        <ul class="sidebar-nav">
            <li class="nav-item nav-item-link-wrap">
                <a class="nav-item-link" href="/pages/dashboard-profesor.php#tareas">
                    <img src="assets/iconos/checklist.svg" alt="" class="nav-icon">
                    Tareas
                </a>
            </li>
            <li class="nav-item nav-item-link-wrap">
                <a class="nav-item-link" href="/pages/dashboard-profesor.php#anuncios">
                    <img src="assets/iconos/speakerphone.svg" alt="" class="nav-icon">
                    Anuncios
                </a>
            </li>
        </ul>
    </div>

    <hr class="separador">

    <div class="sidebar-grupo">
        <p class="sidebar-label">MIS ASIGNATURAS</p>
        <ul class="sidebar-nav">
            <li class="nav-item nav-asig" data-id="prog">
                <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                Programación
                <span class="chevron">&#8250;</span>
            </li>
            <ul class="submenu" id="sub-prog">
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#recursos-prog">Recursos</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#tareas-prog">Tareas</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#calificaciones-prog">Calificaciones</a>
                </li>
            </ul>

            <li class="nav-item nav-asig" data-id="bd">
                <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                Bases de Datos
                <span class="chevron">&#8250;</span>
            </li>
            <ul class="submenu" id="sub-bd">
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#recursos-bd">Recursos</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#tareas-bd">Tareas</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#calificaciones-bd">Calificaciones</a>
                </li>
            </ul>

            <li class="nav-item nav-asig" data-id="hci">
                <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                HCI
                <span class="chevron">&#8250;</span>
            </li>
            <ul class="submenu" id="sub-hci">
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#recursos-hci">Recursos</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#tareas-hci">Tareas</a>
                </li>
                <li class="nav-item nav-sub">
                    <a class="nav-item-link" href="/pages/dashboard-profesor.php#calificaciones-hci">Calificaciones</a>
                </li>
            </ul>
        </ul>
    </div>
</aside>