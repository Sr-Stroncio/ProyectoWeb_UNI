<?php
$stmt = $conexion->prepare("SELECT ID, Nombre FROM Grado WHERE ID = ?");
$stmt->bind_param("i", $id_grado);
$stmt->execute();
$grado = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$grado) {
    echo '<p class="sin-datos">Grado no encontrado.</p>';
    return;
}

$stmt = $conexion->prepare("SELECT ID, Nombre FROM Curso WHERE ID_grado = ? ORDER BY Nombre ASC");
$stmt->bind_param("i", $id_grado);
$stmt->execute();
$cursos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$alumnos = [];
$profesores = [];
$asignaturas = [];

$ids_alumnos = [];
$ids_profesores = [];

// se recorren los cursos del grado para sacar sus materias y la gente apuntada
foreach ($cursos as $curso) {
    $res = $conexion->query("SELECT ID, Nombre FROM Asignatura WHERE ID_curso = " . $curso['ID'] . " ORDER BY Nombre ASC");
    while ($asig = $res->fetch_assoc()) {
        $asig['nombre_curso'] = $curso['Nombre'];
        $asignaturas[] = $asig;

        $res2 = $conexion->query("SELECT ID_alumno FROM Alumno_Asignatura WHERE ID_asignatura = " . $asig['ID']);
        while ($fila = $res2->fetch_row()) {
            $ids_alumnos[] = $fila[0];
        }

        $res2 = $conexion->query("SELECT ID_profesor FROM Profesor_Asignatura WHERE ID_asignatura = " . $asig['ID']);
        while ($fila = $res2->fetch_row()) {
            $ids_profesores[] = $fila[0];
        }
    }
}

// con los ids juntados se sacan los datos de los usuarios
if (count($ids_alumnos) > 0) {
    $res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE ID IN (" . implode(',', $ids_alumnos) . ") ORDER BY Apellido ASC");
    $alumnos = $res->fetch_all(MYSQLI_ASSOC);
}

if (count($ids_profesores) > 0) {
    $res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE ID IN (" . implode(',', $ids_profesores) . ") ORDER BY Apellido ASC");
    $profesores = $res->fetch_all(MYSQLI_ASSOC);
}

// para los selects de los modales de grado
$res = $conexion->query("SELECT ID, Nombre FROM Grado ORDER BY Nombre ASC");
$todosGrados = $res->fetch_all(MYSQLI_ASSOC);
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <div class="cabecera-izq">
            <a href="pages/dashboard-admin.php?seccion=grados" class="btn-volver">‹ Grados</a>
            <h3><?= $grado['Nombre'] ?></h3>
        </div>
    </div>

    <div class="stats-fila">
        <div class="stat-card">
            <p class="stat-label">ALUMNOS</p>
            <p class="stat-num"><?= count($alumnos) ?></p>
            <p class="stat-sub">matriculados en el grado</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">PROFESORES</p>
            <p class="stat-num"><?= count($profesores) ?></p>
            <p class="stat-sub">asignados al grado</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">MATERIAS</p>
            <p class="stat-num"><?= count($asignaturas) ?></p>
            <p class="stat-sub">en <?= count($cursos) ?> curso(s)</p>
        </div>
    </div>
</div>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Alumnos</h3>
        <button class="btn-nuevo" id="btnAddAlumno">+ Añadir alumno</button>
    </div>

    <div class="buscador-wrap">
        <input type="text" id="buscadorAlumnos" class="buscador" placeholder="Buscar alumno...">
    </div>

    <?php if (count($alumnos) == 0): ?>
        <p class="sin-datos">No hay alumnos en este grado.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla" id="tablaAlumnos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                            <td><?= $alumno['Nombre'] ?></td>
                            <td><?= $alumno['Apellido'] ?></td>
                            <td><?= $alumno['Email'] ?></td>
                            <td>
                                <button class="btn-eliminar" onclick="eliminarAlumno(<?= $alumno['ID'] ?>, <?= $id_grado ?>)">
                                    <img src="assets/iconos/trash.svg" alt="eliminar">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Profesores</h3>
        <button class="btn-nuevo" id="btnAddProfesor">+ Añadir profesor</button>
    </div>

    <?php if (count($profesores) == 0): ?>
        <p class="sin-datos">No hay profesores en este grado.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profesores as $prof): ?>
                        <tr>
                            <td><?= $prof['Nombre'] ?></td>
                            <td><?= $prof['Apellido'] ?></td>
                            <td><?= $prof['Email'] ?></td>
                            <td>
                                <button class="btn-eliminar" onclick="eliminarProfesor(<?= $prof['ID'] ?>, <?= $id_grado ?>)">
                                    <img src="assets/iconos/trash.svg" alt="eliminar">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Materias</h3>
    </div>

    <?php if (count($asignaturas) == 0): ?>
        <p class="sin-datos">No hay materias en este grado.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Curso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asignaturas as $asig): ?>
                        <tr>
                            <td><?= $asig['Nombre'] ?></td>
                            <td><?= $asig['nombre_curso'] ?></td>
                            <td>
                                <button class="btn-eliminar" onclick="eliminarMateria(<?= $asig['ID'] ?>, <?= $id_grado ?>)">
                                    <img src="assets/iconos/trash.svg" alt="eliminar">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- modal añadir alumno — mismo util que la sección de alumnos, con id_grado relleno -->
<div class="modal-fondo" id="modalAddAlumno">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Nuevo alumno</h4>
            <button class="btn-cerrar-modal" id="btnCerrarAddAlumno">✕</button>
        </div>
        <form method="POST" action="utils/crear-alumno.php">
            <input type="hidden" name="id_grado" value="<?= $id_grado ?>">
            <div class="campo">
                <label for="addNombreAlumno">Nombre</label>
                <input type="text" id="addNombreAlumno" name="nombre" placeholder="Nombre del alumno">
            </div>
            <div class="campo">
                <label for="addApellidoAlumno">Apellido</label>
                <input type="text" id="addApellidoAlumno" name="apellido" placeholder="Apellido del alumno">
            </div>
            <div class="campo">
                <label for="addEmailAlumno">Correo</label>
                <input type="email" id="addEmailAlumno" name="email" placeholder="correo@ejemplo.com">
            </div>
            <div class="campo">
                <label for="addDniAlumno">DNI</label>
                <input type="text" id="addDniAlumno" name="dni" placeholder="DNI del alumno">
            </div>
            <div class="campo">
                <label for="addPasswordAlumno">Contraseña</label>
                <input type="text" id="addPasswordAlumno" name="password" placeholder="Si se deja vacía será alumno123">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarAddAlumno">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal añadir profesor — mismo util que la sección de profesores -->
<div class="modal-fondo" id="modalAddProfesor">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Nuevo profesor</h4>
            <button class="btn-cerrar-modal" id="btnCerrarAddProfesor">✕</button>
        </div>
        <form method="POST" action="utils/crear-profesor.php">
            <input type="hidden" name="id_grado" value="<?= $id_grado ?>">
            <div class="campo">
                <label for="addNombreProfesor">Nombre</label>
                <input type="text" id="addNombreProfesor" name="nombre" placeholder="Nombre del profesor">
            </div>
            <div class="campo">
                <label for="addApellidoProfesor">Apellido</label>
                <input type="text" id="addApellidoProfesor" name="apellido" placeholder="Apellido del profesor">
            </div>
            <div class="campo">
                <label for="addEmailProfesor">Correo</label>
                <input type="email" id="addEmailProfesor" name="email" placeholder="correo@ejemplo.com">
            </div>
            <div class="campo">
                <label for="addDniProfesor">DNI</label>
                <input type="text" id="addDniProfesor" name="dni" placeholder="DNI del profesor">
            </div>
            <div class="campo">
                <label for="addPasswordProfesor">Contraseña</label>
                <input type="text" id="addPasswordProfesor" name="password" placeholder="Si se deja vacía será profesor123">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarAddProfesor">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
