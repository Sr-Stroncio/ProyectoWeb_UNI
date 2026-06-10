<?php
$res = $conexion->query("SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE Rol = 'profesor' ORDER BY Apellido ASC");
$profesores = $res->fetch_all(MYSQLI_ASSOC);

// se juntan los nombres de las materias de cada profesor
for ($i = 0; $i < count($profesores); $i++) {
    $nombres = [];
    $res2 = $conexion->query("SELECT ID_asignatura FROM Profesor_Asignatura WHERE ID_profesor = " . $profesores[$i]['ID']);
    while ($fila = $res2->fetch_row()) {
        $res3 = $conexion->query("SELECT Nombre FROM Asignatura WHERE ID = " . $fila[0]);
        $fila3 = $res3->fetch_row();
        $nombres[] = $fila3[0];
    }
    sort($nombres);
    $profesores[$i]['materias'] = implode(', ', $nombres);
}
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
                            <td><?= $prof['Nombre'] ?></td>
                            <td><?= $prof['Apellido'] ?></td>
                            <td><?= $prof['Email'] ?></td>
                            <td><?= $prof['materias'] ? $prof['materias'] : '—' ?></td>
                            <td>
                                <a href="pages/dashboard-admin.php?seccion=profesores&id=<?= $prof['ID'] ?>" class="btn-ver">Ver</a>
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
        <form method="POST" action="utils/crear-profesor.php">
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
            <div class="campo">
                <label for="passwordProfesor">Contraseña</label>
                <input type="text" id="passwordProfesor" name="password" placeholder="Si se deja vacía será profesor123">
            </div>
            <div class="modal-botones">
                <button type="button" class="btn-cancelar" id="btnCancelarModalProfesor">Cancelar</button>
                <button type="submit" class="btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>
