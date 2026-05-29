<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    exit;
}

require_once __DIR__ . "/../database/conexion.php";

$alumno_id = (int)$_POST['alumno_id'];
$asignatura = $_POST['asignatura'];

$p1 = $_POST['p1'] !== '' ? (float)$_POST['p1'] : null;
$p2 = $_POST['p2'] !== '' ? (float)$_POST['p2'] : null;
$final = $_POST['final'] !== '' ? (float)$_POST['final'] : null;

// se busca el id de la asignatura
if ($asignatura === 'prog') {
    $nombre_busqueda = '%Programación%';
} elseif ($asignatura === 'bd') {
    $nombre_busqueda = '%Bases de Datos%';
} else {
    $nombre_busqueda = '%HCI%';
}

$stmt_as = mysqli_prepare($conexion, "SELECT ID FROM Asignatura WHERE Nombre LIKE ?");
mysqli_stmt_bind_param($stmt_as, "s", $nombre_busqueda);
mysqli_stmt_execute($stmt_as);
$row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
$asig_id = $row_as ? (int)$row_as[0] : false;

if ($asig_id) {
    // se obtienen los examenes
    $stmt_ex = mysqli_prepare($conexion, "SELECT ID, Titulo FROM Examen WHERE ID_asignatura = ?");
    mysqli_stmt_bind_param($stmt_ex, "i", $asig_id);
    mysqli_stmt_execute($stmt_ex);
    $examenes = mysqli_fetch_all(mysqli_stmt_get_result($stmt_ex), MYSQLI_ASSOC);

    foreach ($examenes as $ex) {
        $nota = null;
        if (strpos(strtolower($ex['Titulo']), 'parcial 1') !== false) {
            $nota = $p1;
        } elseif (strpos(strtolower($ex['Titulo']), 'parcial 2') !== false) {
            $nota = $p2;
        } elseif (strpos(strtolower($ex['Titulo']), 'final') !== false) {
            $nota = $final;
        }

        // se comprueba si ya existe nota
        $stmt_chk = mysqli_prepare($conexion, "SELECT COUNT(*) FROM Nota_Examen WHERE ID_examen = ? AND ID_alumno = ?");
        mysqli_stmt_bind_param($stmt_chk, "ii", $ex['ID'], $alumno_id);
        mysqli_stmt_execute($stmt_chk);
        $row_chk = mysqli_fetch_row(mysqli_stmt_get_result($stmt_chk));
        $existe_nota = (int)$row_chk[0];

        if ($existe_nota) {
            $stmt_up = mysqli_prepare($conexion, "UPDATE Nota_Examen SET Nota = ? WHERE ID_examen = ? AND ID_alumno = ?");
            mysqli_stmt_bind_param($stmt_up, "dii", $nota, $ex['ID'], $alumno_id);
            mysqli_stmt_execute($stmt_up);
        } else {
            $stmt_in = mysqli_prepare($conexion, "INSERT INTO Nota_Examen (ID_examen, ID_alumno, Nota) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt_in, "iid", $ex['ID'], $alumno_id, $nota);
            mysqli_stmt_execute($stmt_in);
        }
    }
}
