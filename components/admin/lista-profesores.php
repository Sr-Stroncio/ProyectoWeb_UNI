<?php
$res = $conexion->query("
    SELECT u.ID, u.Nombre, u.Apellido, u.Email,
        GROUP_CONCAT(DISTINCT asig.Nombre ORDER BY asig.Nombre ASC SEPARATOR ', ') AS materias
    FROM Usuario u
    JOIN Profesor p ON p.ID_user = u.ID
    LEFT JOIN Profesor_Asignatura pa ON pa.ID_profesor = u.ID
    LEFT JOIN Asignatura asig ON asig.ID = pa.ID_asignatura
    GROUP BY u.ID
    ORDER BY u.Apellido ASC
");
$profesores = $res->fetch_all(MYSQLI_ASSOC);
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Profesores</h3>
        <button class="btn-nuevo" id="btnNuevoProfesor">+ Nuevo profesor</button>
    </div>

    <div class="buscador-wrap">
        <input type="text" id="buscadorProfesores" class="buscador" placeholder="Buscar por nombre o correo...">
    </div>

    <?php if (count($profesores) == 0): ?>
        <p class="sin-datos">No hay profesores registrados.</p>
    <?php else: ?>
        <div class="tabla-wrap">
            <table class="tabla" id="tablaProfesores">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Materias</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profesores as $prof): ?>
                        <tr>
                            <td><?= htmlspecialchars($prof['Nombre']) ?></td>
                            <td><?= htmlspecialchars($prof['Apellido']) ?></td>
                            <td><?= htmlspecialchars($prof['Email']) ?></td>
                            <td><?= $prof['materias'] ? htmlspecialchars($prof['materias']) : '—' ?></td>
                            <td>
                                <a href="/pages/dashboard-admin.php?seccion=profesores&id=<?= $prof['ID'] ?>" class="btn-ver">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-fondo" id="modalNuevoProfesor">
    <div class="modal">
        <div class="modal-cabecera">
            <h4>Nuevo profesor</h4>
            <button class="btn-cerrar-modal" id="btnCerrarModalProfesor">✕</button>
        </div>
        <form method="POST" action="/utils/crear-profesor.php">
            <div class="campo">
                <label for="nombreProfesor">Nombre</label>
                <input type="text" id="nombreProfesor" name="nombre" placeholder="Nombre del profesor">
            </div>
            <div class="campo">
                <label for="apellidoProfesor">Apellido</label>
                <input type="text" id="apellidoProfesor" name="apellido" placeholder="Apellido del profesor">
            </div>
            <div class="campo">
                <label for="emailProfesor">Correo</label>
                <input type="email" id="emailProfesor" name="email" placeholder="correo@ejemplo.com">
            </div>
            <div class="campo">
                <label for="dniProfesor">DNI</label>
                <input type="text" id="dniProfesor" name="dni" placeholder="DNI del profesor">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalProfesor">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
