<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$alumno_id = (int)$_POST['alumno_id'];
$notas = isset($_POST['notas']) ? $_POST['notas'] : [];

// se recorre el array de notas[id_examen] = valor
foreach ($notas as $id_examen => $valor) {
    $id_ex = (int)$id_examen;
    $nota = $valor !== '' ? (float)$valor : null;

    // se comprueba si ya existe la nota para este alumno y examen
    $stmt_chk = mysqli_prepare($conexion, "SELECT COUNT(*) FROM Nota_Examen WHERE ID_examen = ? AND ID_alumno = ?");
    mysqli_stmt_bind_param($stmt_chk, "ii", $id_ex, $alumno_id);
    mysqli_stmt_execute($stmt_chk);
    $row_chk = mysqli_fetch_row(mysqli_stmt_get_result($stmt_chk));
    $existe = (int)$row_chk[0];

    if ($existe) {
        $stmt_up = mysqli_prepare($conexion, "UPDATE Nota_Examen SET Nota = ? WHERE ID_examen = ? AND ID_alumno = ?");
        mysqli_stmt_bind_param($stmt_up, "dii", $nota, $id_ex, $alumno_id);
        mysqli_stmt_execute($stmt_up);
    } else {
        $stmt_in = mysqli_prepare($conexion, "INSERT INTO Nota_Examen (ID_examen, ID_alumno, Nota) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_in, "iid", $id_ex, $alumno_id, $nota);
        mysqli_stmt_execute($stmt_in);
    }
}
