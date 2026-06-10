<?php
$res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE ID = " . $id_profesor);
$profesor = $res->fetch_assoc();

$res = $conexion->query("SELECT DNI, Fecha_nacimiento FROM Profesor WHERE ID_user = " . $id_profesor);
$datos_profesor = $res->fetch_assoc();

if (!$profesor || !$datos_profesor) {
    echo '<p class="sin-datos">Profesor no encontrado.</p>';
    return;
}

$profesor['DNI'] = $datos_profesor['DNI'];
$profesor['Fecha_nacimiento'] = $datos_profesor['Fecha_nacimiento'];

// materias del profesor, primero los ids y luego el detalle de cada una
$asignaturas = [];
$res = $conexion->query("SELECT ID_asignatura FROM Profesor_Asignatura WHERE ID_profesor = " . $id_profesor);
while ($fila = $res->fetch_row()) {
    $res2 = $conexion->query("SELECT ID, Nombre, ID_curso FROM Asignatura WHERE ID = " . $fila[0]);
    $asig = $res2->fetch_assoc();

    $asig['nombre_curso'] = '';
    $asig['nombre_grado'] = '';
    if ($asig['ID_curso']) {
        $res2 = $conexion->query("SELECT Nombre, ID_grado FROM Curso WHERE ID = " . $asig['ID_curso']);
        $curso = $res2->fetch_assoc();
        $asig['nombre_curso'] = $curso['Nombre'];
        if ($curso['ID_grado']) {
            $res3 = $conexion->query("SELECT Nombre FROM Grado WHERE ID = " . $curso['ID_grado']);
            $fila2 = $res3->fetch_row();
            $asig['nombre_grado'] = $fila2[0];
        }
    }

    $asignaturas[] = $asig;
}

// todas las asignaturas para el modal de materias
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

$idsAsigProfesor = [];
foreach ($asignaturas as $asig) {
    $idsAsigProfesor[] = $asig['ID'];
}
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <div class="cabecera-izq">
            <a href="pages/dashboard-admin.php?seccion=profesores" class="btn-volver">‹ Profesores</a>
            <h3><?= $profesor['Nombre'] . ' ' . $profesor['Apellido'] ?></h3>
        </div>
        <div class="cabecera-acciones">
            <button class="btn-nuevo" id="btnEditarProfesor">Editar</button>
            <button class="btn-eliminar-rojo" onclick="eliminarProfesorAdmin(<?= $profesor['ID'] ?>)">Eliminar</button>
        </div>
    </div>

    <div class="info-card">
        <div class="info-fila">
            <span class="info-label">Nombre</span>
            <span class="info-valor"><?= $profesor['Nombre'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Apellido</span>
            <span class="info-valor"><?= $profesor['Apellido'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Email</span>
            <span class="info-valor"><?= $profesor['Email'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">DNI</span>
            <span class="info-valor"><?= $profesor['DNI'] ?></span>
        </div>
        <div class="info-fila">
            <span class="info-label">Fecha de nacimiento</span>
            <span class="info-valor"><?= $profesor['Fecha_nacimiento'] ?? '—' ?></span>
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
                            <td><?= $asig['Nombre'] ?></td>
                            <td><?= $asig['nombre_curso'] ?></td>
                            <td><?= $asig['nombre_grado'] ?></td>
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
        <form method="POST" action="utils/editar-profesor.php">
            <input type="hidden" name="id" value="<?= $profesor['ID'] ?>">
            <div class="campo">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= $profesor['Nombre'] ?>">
            </div>
            <div class="campo">
                <label>Apellido</label>
                <input type="text" name="apellido" value="<?= $profesor['Apellido'] ?>">
            </div>
            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" value="<?= $profesor['Email'] ?>">
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
        <form method="POST" action="utils/editar-materias-profesor.php">
            <input type="hidden" name="id_profesor" value="<?= $profesor['ID'] ?>">
            <div class="campo">
                <?php foreach ($todasAsignaturas as $asig): ?>
                    <label class="campo-checkbox">
                        <input type="checkbox" name="asignaturas[]" value="<?= $asig['ID'] ?>"
                            <?= in_array($asig['ID'], $idsAsigProfesor) ? 'checked' : '' ?>>
                        <?= $asig['nombre_grado'] . ' › ' . $asig['nombre_curso'] . ' › ' . $asig['Nombre'] ?>
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
