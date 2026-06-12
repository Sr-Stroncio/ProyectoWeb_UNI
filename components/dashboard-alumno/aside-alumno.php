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

                $asignatura_activa = (
                    ($seccion === 'recursos' || $seccion === 'examenes' || $seccion === 'tareas')
                    && $id_asignatura == $id_actual
                );
                ?>

                <li class="nav-item nav-asig <?= $asignatura_activa ? 'activo' : '' ?>" data-id="<?= $id_actual ?>">
                    <img src="assets/iconos/book.svg" alt="" class="nav-icon">
                    <?= htmlspecialchars($asignatura['Nombre']) ?>
                    <span class="chevron">&#8250;</span>
                </li>

                <ul class="submenu <?= $asignatura_activa ? 'abierto' : '' ?>" id="sub-<?= $id_actual ?>">

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=beta">
                        <li class="nav-item nav-sub <?= ($seccion === 'recursos' && $id_asignatura == $id_actual) ? 'activo' : '' ?>">

                            Recursos

                        </li>
                    </a>

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=examenes&id=<?= $id_actual ?>">
                        <li class="nav-item nav-sub <?= ($seccion === 'examenes' && $id_asignatura == $id_actual) ? 'activo' : '' ?>">

                            Exámenes

                        </li>
                    </a>

                    <a class="nav-item-link" href="pages/dashboard-alumno.php?seccion=tareas&id=<?= $id_actual ?>">
                        <li class="nav-item nav-sub <?= ($seccion === 'tareas' && $id_asignatura == $id_actual) ? 'activo' : '' ?>">

                            Tareas

                        </li>
                    </a>

                </ul>

            <?php endwhile; ?>

        </ul>

    </div>

    <div class="sidebar-img">
        <img src="img/alumno.jpg" alt="img-aside">
    </div>
</aside>