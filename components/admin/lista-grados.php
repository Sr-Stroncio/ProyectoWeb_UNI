<?php
$res = $conn->query("SELECT ID, Nombre FROM Grado ORDER BY Nombre ASC");
$grados = $res->fetch_all(MYSQLI_ASSOC);
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Grados</h3>
        <button class="btn-nuevo" id="btnNuevoGrado">+ Nuevo grado</button>
    </div>

    <?php if (count($grados) == 0): ?>
        <p class="sin-datos">No hay grados registrados.</p>
    <?php else: ?>
        <div class="lista-grados">
            <?php foreach ($grados as $grado): ?>
                <a href="/pages/dashboard-admin.php?seccion=grados&id=<?= $grado['ID'] ?>" class="grado-card">
                    <div class="grado-icono">
                        <img src="assets/iconos/book.svg" alt="">
                    </div>
                    <div class="grado-info">
                        <p class="grado-nombre"><?= htmlspecialchars($grado['Nombre']) ?></p>
                    </div>
                    <span class="grado-flecha">›</span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="modal-fondo" id="modalNuevoGrado">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Nuevo grado</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModal">✕</button>
        </div>
        <form method="POST" action="/utils/crear-grado.php">
            <div class="campo">
                <label for="nombreGrado">Nombre del grado</label>
                <input type="text" id="nombreGrado" name="nombre" placeholder="Ej: Desarrollo de Aplicaciones Web">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModal">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
