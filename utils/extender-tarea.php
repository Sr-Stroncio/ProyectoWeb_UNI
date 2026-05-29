<?php
include '../utils/check-usuario.php';
comprobarUsuario('profesor');

require_once __DIR__ . "/../database/conexion.php";

$id = (int)$_POST['id'];
$cantidad = (int)$_POST['cantidad'];
$unidad = $_POST['unidad'];

// se validan las unidades aceptadas
if ($unidad !== 'MINUTE' && $unidad !== 'HOUR' && $unidad !== 'DAY') {
    exit;
}

if ($cantidad <= 0) {
    exit;
}

// se construye el SQL con la unidad validada (no se puede bindear como parametro)
$sql = "UPDATE Tarea SET Fecha_limite = DATE_ADD(Fecha_limite, INTERVAL ? " . $unidad . ") WHERE ID = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $cantidad, $id);
mysqli_stmt_execute($stmt);

// se devuelve la nueva fecha de cierre para que el JS la actualice
$stmt_get = mysqli_prepare($conexion, "SELECT Fecha_limite FROM Tarea WHERE ID = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$row = mysqli_fetch_row(mysqli_stmt_get_result($stmt_get));
echo $row ? $row[0] : '';
