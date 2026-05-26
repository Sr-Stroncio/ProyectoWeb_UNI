<aside id="sidebar">

    <div class="sidebar-grupo">
        <p class="sidebar-label">PRINCIPAL</p>
        <ul class="sidebar-nav">
            <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=inicio">
                <li class="nav-item <?= $seccion === 'inicio' ? 'activo' : '' ?>">

                    <img src="assets/iconos/home.svg" alt="" class="nav-icon">
                    Inicio

                </li>
            </a>
            <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=calendario">
                <li class="nav-item <?= $seccion === 'calendario' ? 'activo' : '' ?>">

                    <img src="assets/iconos/calendar.svg" alt="" class="nav-icon">
                    Calendario

                </li>
            </a>

        </ul>
    </div>

    <hr class="separador">

    <div class="sidebar-grupo">
        <p class="sidebar-label">UTILIDADES</p>
        <ul class="sidebar-nav">
            <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=calificaciones">
                <li class="nav-item nav-item-link-wrap <?= $seccion === 'calificaciones' ? 'activo' : '' ?>">

                    <img src="assets/iconos/school.svg" alt="" class="nav-icon">
                    Calificaciones

                </li>
            </a>
            <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=anuncios">
                <li class="nav-item nav-item-link-wrap <?= $seccion === 'anuncios' ? 'activo' : '' ?>">

                    <img src="assets/iconos/speakerphone.svg" alt="" class="nav-icon">
                    Anuncios

                </li>
            </a>
        </ul>
    </div>

    <hr class="separador">

    <div class="sidebar-grupo">
        <p class="sidebar-label">MIS ASIGNATURAS</p>

        <ul class="sidebar-nav">

            <?php while ($asignatura = mysqli_fetch_assoc($resultado_asignaturas)): ?>

                <?php
                    $id_actual = $asignatura['ID'];
                    $asignatura_activa = ($seccion === 'asignatura' && $id_asignatura == $id_actual);
                ?>

                <li class="nav-item nav-asig <?= $asignatura_activa ? 'activo' : '' ?>" data-id="<?= $id_actual ?>">
                    <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                    <?= htmlspecialchars($asignatura['Nombre']) ?>
                    <span class="chevron">&#8250;</span>
                </li>

                <ul class="submenu <?= $asignatura_activa ? 'abierto' : '' ?>" id="sub-<?= $id_actual ?>">

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=asignatura&id=<?= $id_actual ?>&vista=recursos">
                        <li class="nav-item nav-sub <?= ($asignatura_activa && $vista === 'recursos') ? 'activo' : '' ?>">

                            Recursos

                        </li>
                    </a>

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=asignatura&id=<?= $id_actual ?>&vista=examenes">
                        <li class="nav-item nav-sub <?= ($asignatura_activa && $vista === 'examenes') ? 'activo' : '' ?>">

                            Exámenes

                        </li>
                    </a>

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=asignatura&id=<?= $id_actual ?>&vista=tareas">
                        <li class="nav-item nav-sub <?= ($asignatura_activa && $vista === 'tareas') ? 'activo' : '' ?>">

                            Tareas

                        </li>
                    </a>

                </ul>

            <?php endwhile; ?>

        </ul>

    </div>

    <div class="sidebar-img">
        <img src="img/sidebar-img.png" alt="img-aside">
    </div>
</aside>