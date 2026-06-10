<main>
    <!-- anuncios -->
    <div class="bloque">
        <div class="bloque-cabecera">
            <h3>Anuncios</h3>
            <a class="btn-nuevo" href="/pages/dashboard-profesor.php#anuncios-nuevo">+ Nuevo anuncio</a>
        </div>

        <div class="lista-anuncios">
        <?php
        $count = 0;
        if (!empty($anuncios_js)) {
            foreach ($anuncios_js as $an) {
                if ($count >= 3) break;
                $count++;
                ?>
                <div class="anuncio-card">
                    <div class="anuncio-top">
                        <span class="anuncio-asig"><?= htmlspecialchars($an['autor']) ?></span>
                        <span class="anuncio-tiempo"><?= htmlspecialchars($an['tiempo']) ?></span>
                    </div>
                    <p class="anuncio-titulo"><?= htmlspecialchars($an['titulo']) ?></p>
                    <p class="anuncio-desc"><?= htmlspecialchars($an['desc']) ?></p>
                    <div class="anuncio-botones">
                        <?php if ($an['propio']): ?>
                            <a class="btn-icono" href="/pages/dashboard-profesor.php#anuncios">
                                <img src="assets/iconos/pencil.svg" alt="editar">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p style="padding: 20px; color: #888;">No hay anuncios disponibles.</p>';
        }
        ?>
        </div>
    </div>

    <!-- vista general -->
    <div class="bloque">
        <div class="bloque-cabecera">
            <h3>Vista General</h3>
        </div>

        <div class="stats-fila">
            <div class="stat-card">
                <p class="stat-label">POR CORREGIR</p>
                <p class="stat-num rojo">13</p>
                <p class="stat-sub">entregas sin revisar</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">TAREAS ACTIVAS</p>
                <p class="stat-num">5</p>
                <p class="stat-sub">en 3 asignaturas</p>
            </div>
        </div>

        <div class="dos-col">
            <div class="col-bloque">
                <p class="col-titulo">COLA DE CORRECCIÓN</p>

                <div class="correccion-fila">
                    <div class="avatar">L</div>
                    <div>
                        <p class="nombre-alumno">Lief Simants</p>
                        <p class="sub-alumno">Práctica 3 · Programación</p>
                    </div>
                    <div class="fila-derecha">
                        <span class="tiempo-entrega">Hace 1h</span>
                        <button class="btn-corregir">Corregir</button>
                    </div>
                </div>

                <div class="correccion-fila">
                    <div class="avatar">M</div>
                    <div>
                        <p class="nombre-alumno">Merline Kirdsch</p>
                        <p class="sub-alumno">Tarea SQL · BD</p>
                    </div>
                    <div class="fila-derecha">
                        <span class="tiempo-entrega">Hace 2h</span>
                        <button class="btn-corregir">Corregir</button>
                    </div>
                </div>

                <div class="correccion-fila">
                    <div class="avatar">D</div>
                    <div>
                        <p class="nombre-alumno">Debora Rawstorne</p>
                        <p class="sub-alumno">Entrega P2 · HCI</p>
                    </div>
                    <div class="fila-derecha">
                        <span class="tiempo-entrega">Hace 4h</span>
                        <button class="btn-corregir">Corregir</button>
                    </div>
                </div>

                <div class="correccion-fila">
                    <div class="avatar">K</div>
                    <div>
                        <p class="nombre-alumno">Kevan Pounds</p>
                        <p class="sub-alumno">Práctica 3 · Programación</p>
                    </div>
                    <div class="fila-derecha">
                        <span class="tiempo-entrega">Ayer</span>
                        <button class="btn-corregir">Corregir</button>
                    </div>
                </div>
            </div>

            <div class="col-bloque">
                <p class="col-titulo">AGENDA DE HOY</p>

                <div class="agenda-fila">
                    <div class="agenda-hora">
                        <span class="hora">10:00</span>
                        <span class="duracion">2h</span>
                    </div>
                    <div>
                        <p class="nombre-alumno">Clase Programación</p>
                        <p class="sub-alumno">A-204</p>
                    </div>
                </div>

                <div class="agenda-fila">
                    <div class="agenda-hora">
                        <span class="hora">12:30</span>
                        <span class="duracion">30m</span>
                    </div>
                    <div>
                        <p class="nombre-alumno">Tutoría — Lief Simants</p>
                        <p class="sub-alumno">B-101</p>
                    </div>
                </div>

                <div class="agenda-fila">
                    <div class="agenda-hora">
                        <span class="hora">16:00</span>
                        <span class="duracion">2h</span>
                    </div>
                    <div>
                        <p class="nombre-alumno">Clase Bases de Datos</p>
                        <p class="sub-alumno">A-110</p>
                    </div>
                </div>

                <div class="agenda-fila">
                    <div class="agenda-hora">
                        <span class="hora">18:00</span>
                        <span class="duracion">1h</span>
                    </div>
                    <div>
                        <p class="nombre-alumno">Reunión departamento</p>
                        <p class="sub-alumno">Sala 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
