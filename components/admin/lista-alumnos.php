<?php
$res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE Rol = 'alumno' ORDER BY Apellido ASC");
$alumnos = $res->fetch_all(MYSQLI_ASSOC);

// se busca el grado de cada alumno pasando por asignatura y curso
for ($i = 0; $i < count($alumnos); $i++) {
    $alumnos[$i]['nombre_grado'] = null;

    $res2 = $conexion->query("SELECT ID_asignatura FROM Alumno_Asignatura WHERE ID_alumno = " . $alumnos[$i]['ID'] . " LIMIT 1");
    $fila = $res2->fetch_row();
    if ($fila) {
        $res2 = $conexion->query("SELECT ID_curso FROM Asignatura WHERE ID = " . $fila[0]);
        $fila = $res2->fetch_row();
    }
    if ($fila && $fila[0]) {
        $res2 = $conexion->query("SELECT ID_grado FROM Curso WHERE ID = " . $fila[0]);
        $fila = $res2->fetch_row();
    }
    if ($fila && $fila[0]) {
        $res2 = $conexion->query("SELECT Nombre FROM Grado WHERE ID = " . $fila[0]);
        $fila = $res2->fetch_row();
        $alumnos[$i]['nombre_grado'] = $fila[0];
    }
}
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Alumnos</h3>
        <button class="btn-nuevo" id="btnNuevoAlumno">+ Nuevo alumno</button>
    </div>

    <div class="buscador-wrap">
        <input type="text" id="buscadorAlumnos" class="buscador" placeholder="Buscar por nombre o correo...">
    </div>

    <?php if (count($alumnos) == 0): ?>
        <p class="sin-datos">No hay alumnos registrados.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla" id="tablaAlumnos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Grado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                            <td><?= $alumno['Nombre'] ?></td>
                            <td><?= $alumno['Apellido'] ?></td>
                            <td><?= $alumno['Email'] ?></td>
                            <td><?= $alumno['nombre_grado'] ? $alumno['nombre_grado'] : '—' ?></td>
                            <td>
                                <a href="pages/dashboard-admin.php?seccion=alumnos&id=<?= $alumno['ID'] ?>" class="btn-ver">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-fondo" id="modalNuevoAlumno">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Nuevo alumno</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalAlumno">✕</button>
        </div>
        <form method="POST" action="utils/crear-alumno.php">
            <div class="campo">
                <label for="nombreAlumno">Nombre</label>
                <input type="text" id="nombreAlumno" name="nombre" placeholder="Nombre del alumno">
            </div>
            <div class="campo">
                <label for="apellidoAlumno">Apellido</label>
                <input type="text" id="apellidoAlumno" name="apellido" placeholder="Apellido del alumno">
            </div>
            <div class="campo">
                <label for="emailAlumno">Correo</label>
                <input type="email" id="emailAlumno" name="email" placeholder="correo@ejemplo.com">
            </div>
            <div class="campo">
                <label for="dniAlumno">DNI</label>
                <input type="text" id="dniAlumno" name="dni" placeholder="DNI del alumno">
            </div>
            <div class="campo">
                <label for="gradoAlumno">Grado</label>
                <select id="gradoAlumno" name="id_grado" class="campo-select">
                    <option value="">Sin grado</option>
                    <?php
                    $grados = $conexion->query("SELECT ID, Nombre FROM Grado ORDER BY Nombre ASC");
                    while ($g = $grados->fetch_assoc()):
                    ?>
                        <option value="<?= $g['ID'] ?>"><?= $g['Nombre'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalAlumno">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
