<?php
$stmt = $conexion->prepare("
    SELECT u.ID, u.Nombre, u.Apellido, u.Email, a.DNI, a.Fecha_nacimiento
    FROM Usuario u
    JOIN Alumno a ON a.ID_user = u.ID
    WHERE u.ID = ?
");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$alumno = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$alumno) {
    echo '<p class="sin-datos">Alumno no encontrado.</p>';
    return;
}

$stmt = $conexion->prepare("
    SELECT DISTINCT g.ID, g.Nombre
    FROM Grado g
    JOIN Curso c ON c.ID_grado = g.ID
    JOIN Asignatura asig ON asig.ID_curso = c.ID
    JOIN Alumno_Asignatura aa ON aa.ID_asignatura = asig.ID
    WHERE aa.ID_alumno = ?
");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$grados = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $conexion->prepare("
    SELECT asig.ID, asig.Nombre, c.Nombre AS nombre_curso
    FROM Asignatura asig
    JOIN Curso c ON c.ID = asig.ID_curso
    JOIN Alumno_Asignatura aa ON aa.ID_asignatura = asig.ID
    WHERE aa.ID_alumno = ?
    ORDER BY c.Nombre ASC, asig.Nombre ASC
");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$asignaturas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$todosGrados = $conexion->query("SELECT ID, Nombre FROM Grado ORDER BY Nombre ASC")->fetch_all(MYSQLI_ASSOC);
$todasAsignaturas = $conexion->query("
    SELECT asig.ID, asig.Nombre, c.Nombre AS nombre_curso, g.Nombre AS nombre_grado
    FROM Asignatura asig
    JOIN Curso c ON c.ID = asig.ID_curso
    JOIN Grado g ON g.ID = c.ID_grado
    ORDER BY g.Nombre ASC, c.Nombre ASC, asig.Nombre ASC
")->fetch_all(MYSQLI_ASSOC);

$idsAsigAlumno = array_column($asignaturas, 'ID');
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <div class="cabecera-izq">
            <a href="/pages/dashboard-admin.php?seccion=alumnos" class="btn-volver">‹ Alumnos</a>
            <h3><?= htmlspecialchars($alumno['Nombre'] . ' ' . $alumno['Apellido']) ?></h3>
        </div>
        <div class="cabecera-acciones">
            <button class="btn-nuevo" id="btnEditarAlumno">Editar</button>
            <button class="btn-eliminar-rojo" onclick="eliminarAlumno(<?= $alumno['ID'] ?>)">Eliminar</button>
        </div>
    </div>

    <div class="info-card">
        <div class="info-fila">
            <span class="info-label">Nombre</span>
            <span class="info-valor"><?= htmlspecialchars($alumno['Nombre']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Apellido</span>
            <span class="info-valor"><?= htmlspecialchars($alumno['Apellido']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Email</span>
            <span class="info-valor"><?= htmlspecialchars($alumno['Email']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">DNI</span>
            <span class="info-valor"><?= htmlspecialchars($alumno['DNI']) ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Fecha de nacimiento</span>
            <span class="info-valor"><?= htmlspecialchars($alumno['Fecha_nacimiento'] ?? '—') ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Grado</span>
            <span class="info-valor"><?= count($grados) > 0 ? htmlspecialchars($grados[0]['Nombre']) : '—' ?></span>
        </div>
    </div>
</div>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Asignaturas</h3>
        <button class="btn-nuevo" id="btnEditarAsignaturas">Editar asignaturas</button>
    </div>

    <?php if (count($asignaturas) == 0): ?>
        <p class="sin-datos">No tiene asignaturas asignadas.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Asignatura</th>
                        <th>Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asignaturas as $asig): ?>
                        <tr>
                            <td><?= htmlspecialchars($asig['Nombre']) ?></td>
                            <td><?= htmlspecialchars($asig['nombre_curso']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-fondo" id="modalEditarAlumno">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Editar alumno</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalEditar">✕</button>
        </div>
        <form method="POST" action="/utils/editar-alumno.php">
            <input type="hidden" name="id" value="<?= $alumno['ID'] ?>">
            <div class="campo">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($alumno['Nombre']) ?>">
            </div>
            <div class="campo">
                <label>Apellido</label>
                <input type="text" name="apellido" value="<?= htmlspecialchars($alumno['Apellido']) ?>">
            </div>
            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($alumno['Email']) ?>">
            </div>
            <div class="campo">
                <label>Grado</label>
                <select name="id_grado" class="campo-select">
                    <option value="">Sin grado</option>
                    <?php foreach ($todosGrados as $g): ?>
                        <option value="<?= $g['ID'] ?>" <?= (count($grados) > 0 && $grados[0]['ID'] == $g['ID']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['Nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalEditar">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-fondo" id="modalEditarAsignaturas">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Editar asignaturas</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalAsig">✕</button>
        </div>
        <form method="POST" action="/utils/editar-asignaturas-alumno.php">
            <input type="hidden" name="id_alumno" value="<?= $alumno['ID'] ?>">
            <div class="campo">
                <?php foreach ($todasAsignaturas as $asig): ?>
                    <label class="campo-checkbox">
                        <input type="checkbox" name="asignaturas[]" value="<?= $asig['ID'] ?>"
                            <?= in_array($asig['ID'], $idsAsigAlumno) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($asig['nombre_grado'] . ' › ' . $asig['nombre_curso'] . ' › ' . $asig['Nombre']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalAsig">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
