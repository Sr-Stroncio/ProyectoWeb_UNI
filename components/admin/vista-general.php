<?php
$res = $conn->query("SELECT COUNT(*) AS total FROM Alumno");
$totalAlumnos = $res->fetch_assoc()['total'];

$res = $conn->query("SELECT COUNT(*) AS total FROM Profesor");
$totalProfesores = $res->fetch_assoc()['total'];

$res = $conn->query("SELECT COUNT(*) AS total FROM Grado");
$totalGrados = $res->fetch_assoc()['total'];
?>

<div class="bloque">
    <div class="bloque-cabecera">
        <h3>Vista General</h3>
    </div>

    <div class="stats-fila">
        <div class="stat-card">
            <p class="stat-label">ALUMNOS REGISTRADOS</p>
            <p class="stat-num"><?= $totalAlumnos ?></p>
            <p class="stat-sub">en toda la institución</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">PROFESORES REGISTRADOS</p>
            <p class="stat-num"><?= $totalProfesores ?></p>
            <p class="stat-sub">activos este ciclo</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">GRADOS EXISTENTES</p>
            <p class="stat-num"><?= $totalGrados ?></p>
            <p class="stat-sub">grupos activos</p>
        </div>
    </div>
</div>
