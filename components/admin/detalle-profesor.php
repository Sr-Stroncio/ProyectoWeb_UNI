<?php
$stmt = $conexion->prepare("
    SELECT u.ID, u.Nombre, u.Apellido, u.Email, p.DNI, p.Fecha_nacimiento
    FROM Usuario u
    JOIN Profesor p ON p.ID_user = u.ID
    WHERE u.ID = ?
");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$profesor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$profesor) {
    echo '<p class="sin-datos">Profesor no encontrado.</p>';
    return;
}

$stmt = $conexion->prepare("
    SELECT asig.ID, asig.Nombre, c.Nombre AS nombre_curso, g.Nombre AS nombre_grado
    FROM Asignatura asig
    JOIN Curso c ON c.ID = asig.ID_curso
    JOIN Grado g ON g.ID = c.ID_grado
    JOIN Profesor_Asignatura pa ON pa.ID_asignatura = asig.ID
    WHERE pa.ID_profesor = ?
    ORDER BY g.Nombre ASC, c.Nombre ASC, asig.Nombre ASC
");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$asignaturas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$todasAsignaturas = $conexion->query("
    SELECT asig.ID, asig.Nombre, c.Nombre AS nombre_curso, g.Nombre AS nombre_grado
    FROM Asignatura asig
    JOIN Curso c ON c.ID = asig.ID_curso
    JOIN Grado g ON g.ID = c.ID_grado
    ORDER BY g.Nombre ASC, c.Nombre ASC, asig.Nombre ASC
")->fetch_all(MYSQLI_ASSOC);

$idsAsigProfesor = array_column($asignaturas, 'ID');
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <div class="cabecera-izq">
            <a href="/pages/dashboard-admin.php?seccion=profesores" class="btn-volver">‹ Profesores</a>
            <h3><?= htmlspecialchars($profesor['Nombre'] . ' ' . $profesor['Apellido']) ?></h3>
        </div>
        <div class="cabecera-acciones">
            <button class="btn-nuevo" id="btnEditarProfesor">Editar</button>
            <button class="btn-eliminar-rojo" onclick="eliminarProfesorAdmin(<?= $profesor['ID'] ?>)">Eliminar</button>
        </div>
    </div>

    <div class="info-card">
        <div class="info-fila">
            <span class="info-label">Nombre</span>
            <span class="info-valor"><?= htmlspecialchars($profesor['Nombre']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Apellido</span>
            <span class="info-valor"><?= htmlspecialchars($profesor['Apellido']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Email</span>
            <span class="info-valor"><?= htmlspecialchars($profesor['Email']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">DNI</span>
            <span class="info-valor"><?= htmlspecialchars($profesor['DNI']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Fecha de nacimiento</span>
            <span class="info-valor"><?= htmlspecialchars($profesor['Fecha_nacimiento'] ?? '—') ?></span>
        </div>
    </div>
</div>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Materias asignadas</h3>
        <button class="btn-nuevo" id="btnEditarMaterias">Editar materias</button>
    </div>

    <?php if (count($asignaturas) == 0): ?>
        <p class="sin-datos">No tiene materias asignadas.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Curso</th>
                        <th>Grado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asignaturas as $asig): ?>
                        <tr>
                            <td><?= htmlspecialchars($asig['Nombre']) ?></td>
                            <td><?= htmlspecialchars($asig['nombre_curso']) ?></td>
                            <td><?= htmlspecialchars($asig['nombre_grado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-fondo" id="modalEditarProfesor">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Editar profesor</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalEditarProfesor">✕</button>
        </div>
        <form method="POST" action="/utils/editar-profesor.php">
            <input type="hidden" name="id" value="<?= $profesor['ID'] ?>">
            <div class="campo">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($profesor['Nombre']) ?>">
            </div>
            <div class="campo">
                <label>Apellido</label>
                <input type="text" name="apellido" value="<?= htmlspecialchars($profesor['Apellido']) ?>">
            </div>
            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($profesor['Email']) ?>">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalEditarProfesor">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-fondo" id="modalEditarMaterias">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Editar materias</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalMaterias">✕</button>
        </div>
        <form method="POST" action="/utils/editar-materias-profesor.php">
            <input type="hidden" name="id_profesor" value="<?= $profesor['ID'] ?>">
            <div class="campo">
                <?php foreach ($todasAsignaturas as $asig): ?>
                    <label class="campo-checkbox">
                        <input type="checkbox" name="asignaturas[]" value="<?= $asig['ID'] ?>"
                            <?= in_array($asig['ID'], $idsAsigProfesor) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($asig['nombre_grado'] . ' › ' . $asig['nombre_curso'] . ' › ' . $asig['Nombre']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalMaterias">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
