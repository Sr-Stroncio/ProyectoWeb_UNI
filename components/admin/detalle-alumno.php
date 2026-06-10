<?php
$res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE ID = " . $id_alumno);
$alumno = $res->fetch_assoc();

$res = $conexion->query("SELECT DNI, Fecha_nacimiento FROM Alumno WHERE ID_user = " . $id_alumno);
$datos_alumno = $res->fetch_assoc();

if (!$alumno || !$datos_alumno) {
    echo '<p class="sin-datos">Alumno no encontrado.</p>';
    return;
}

$alumno['DNI'] = $datos_alumno['DNI'];
$alumno['Fecha_nacimiento'] = $datos_alumno['Fecha_nacimiento'];

// asignaturas del alumno, primero los ids y luego los datos de cada una
$asignaturas = [];
$res = $conexion->query("SELECT ID_asignatura FROM Alumno_Asignatura WHERE ID_alumno = " . $id_alumno);
while ($fila = $res->fetch_row()) {
    $res2 = $conexion->query("SELECT ID, Nombre, ID_curso FROM Asignatura WHERE ID = " . $fila[0]);
    $asig = $res2->fetch_assoc();

    $asig['nombre_curso'] = '';
    if ($asig['ID_curso']) {
        $res2 = $conexion->query("SELECT Nombre FROM Curso WHERE ID = " . $asig['ID_curso']);
        $curso = $res2->fetch_row();
        $asig['nombre_curso'] = $curso[0];
    }

    $asignaturas[] = $asig;
}

// el grado se saca encadenando la primera asignatura con su curso
$grados = [];
if (count($asignaturas) > 0 && $asignaturas[0]['ID_curso']) {
    $res = $conexion->query("SELECT ID_grado FROM Curso WHERE ID = " . $asignaturas[0]['ID_curso']);
    $fila = $res->fetch_row();
    if ($fila[0]) {
        $res = $conexion->query("SELECT ID, Nombre FROM Grado WHERE ID = " . $fila[0]);
        $grados[] = $res->fetch_assoc();
    }
}

$todosGrados = $conexion->query("SELECT ID, Nombre FROM Grado ORDER BY Nombre ASC")->fetch_all(MYSQLI_ASSOC);

// todas las asignaturas para el modal, con su curso y su grado
$todasAsignaturas = [];
$res = $conexion->query("SELECT ID, Nombre, ID_curso FROM Asignatura ORDER BY Nombre ASC");
while ($asig = $res->fetch_assoc()) {
    $asig['nombre_curso'] = '';
    $asig['nombre_grado'] = '';
    if ($asig['ID_curso']) {
        $res2 = $conexion->query("SELECT Nombre, ID_grado FROM Curso WHERE ID = " . $asig['ID_curso']);
        $curso = $res2->fetch_assoc();
        $asig['nombre_curso'] = $curso['Nombre'];
        if ($curso['ID_grado']) {
            $res3 = $conexion->query("SELECT Nombre FROM Grado WHERE ID = " . $curso['ID_grado']);
            $fila = $res3->fetch_row();
            $asig['nombre_grado'] = $fila[0];
        }
    }
    $todasAsignaturas[] = $asig;
}

$idsAsigAlumno = [];
foreach ($asignaturas as $asig) {
    $idsAsigAlumno[] = $asig['ID'];
}
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <div class="cabecera-izq">
            <a href="pages/dashboard-admin.php?seccion=alumnos" class="btn-volver">‹ Alumnos</a>
            <h3><?= $alumno['Nombre'] . ' ' . $alumno['Apellido'] ?></h3>
        </div>
        <div class="cabecera-acciones">
            <button class="btn-nuevo" id="btnEditarAlumno">Editar</button>
            <button class="btn-eliminar-rojo" onclick="eliminarAlumno(<?= $alumno['ID'] ?>)">Eliminar</button>
        </div>
    </div>

    <div class="info-card">
        <div class="info-fila">
            <span class="info-label">Nombre</span>
            <span class="info-valor"><?= $alumno['Nombre'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Apellido</span>
            <span class="info-valor"><?= $alumno['Apellido'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Email</span>
            <span class="info-valor"><?= $alumno['Email'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">DNI</span>
            <span class="info-valor"><?= $alumno['DNI'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Fecha de nacimiento</span>
            <span class="info-valor"><?= $alumno['Fecha_nacimiento'] ?? '—' ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Grado</span>
            <span class="info-valor"><?= count($grados) > 0 ? $grados[0]['Nombre'] : '—' ?></span>
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
                            <td><?= $asig['Nombre'] ?></td>
                            <td><?= $asig['nombre_curso'] ?></td>
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
        <form method="POST" action="utils/editar-alumno.php">
            <input type="hidden" name="id" value="<?= $alumno['ID'] ?>">
            <div class="campo">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= $alumno['Nombre'] ?>">
            </div>
            <div class="campo">
                <label>Apellido</label>
                <input type="text" name="apellido" value="<?= $alumno['Apellido'] ?>">
            </div>
            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" value="<?= $alumno['Email'] ?>">
            </div>
            <div class="campo">
                <label>Grado</label>
                <select name="id_grado" class="campo-select">
                    <option value="">Sin grado</option>
                    <?php foreach ($todosGrados as $g): ?>
                        <option value="<?= $g['ID'] ?>" <?= (count($grados) > 0 && $grados[0]['ID'] == $g['ID']) ? 'selected' : '' ?>>
                            <?= $g['Nombre'] ?>
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
        <form method="POST" action="utils/editar-asignaturas-alumno.php">
            <input type="hidden" name="id_alumno" value="<?= $alumno['ID'] ?>">
            <div class="campo">
                <?php foreach ($todasAsignaturas as $asig): ?>
                    <label class="campo-checkbox">
                        <input type="checkbox" name="asignaturas[]" value="<?= $asig['ID'] ?>"
                            <?= in_array($asig['ID'], $idsAsigAlumno) ? 'checked' : '' ?>>
                        <?= $asig['nombre_grado'] . ' › ' . $asig['nombre_curso'] . ' › ' . $asig['Nombre'] ?>
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
