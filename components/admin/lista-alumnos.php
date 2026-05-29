<?php
$res = $conexion->query("
    SELECT u.ID, u.Nombre, u.Apellido, u.Email, g.Nombre AS nombre_grado
    FROM Usuario u
    JOIN Alumno a ON a.ID_user = u.ID
    LEFT JOIN Alumno_Asignatura aa ON aa.ID_alumno = u.ID
    LEFT JOIN Asignatura asig ON asig.ID = aa.ID_asignatura
    LEFT JOIN Curso c ON c.ID = asig.ID_curso
    LEFT JOIN Grado g ON g.ID = c.ID_grado
    GROUP BY u.ID
    ORDER BY u.Apellido ASC
");
$alumnos = $res->fetch_all(MYSQLI_ASSOC);
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
                            <td><?= htmlspecialchars($alumno['Nombre']) ?></td>
                            <td><?= htmlspecialchars($alumno['Apellido']) ?></td>
                            <td><?= htmlspecialchars($alumno['Email']) ?></td>
                            <td><?= $alumno['nombre_grado'] ? htmlspecialchars($alumno['nombre_grado']) : '—' ?></td>
                            <td>
                                <a href="/pages/dashboard-admin.php?seccion=alumnos&id=<?= $alumno['ID'] ?>" class="btn-ver">Ver</a>
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
        <form method="POST" action="/utils/crear-alumno.php">
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
                        <option value="<?= $g['ID'] ?>"><?= htmlspecialchars($g['Nombre']) ?></option>
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
