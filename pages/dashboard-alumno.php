<?php
session_start();

/* 
codigo que comprueba que el usuario ha iniciado sesion y que cumple con su rol
*/

// Si no hay usuario guardado en sesión, vuelve al login
if (!isset($_SESSION['usuario'])) {
    header('Location: /pages/log-in-producto.php');
    exit;
}

// Si el usuario existe, pero no es alumno, vuelve al login
if ($_SESSION['rol'] !== 'alumno') {
    header('Location: /pages/log-in-producto.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <title>Dashboard alumno</title>
</head>

<body>

    <header>

        <div>

        </div>

        <div>
            <h1>Dashboard alumno</h1>

            <p>Bienvenido/a, <?= $_SESSION['nombre'] ?></p>
            <p>Rol: <?= $_SESSION['rol'] ?></p>

            <a href="/utils/logout-producto.php">Cerrar sesión</a>
        </div>

    </header>

    <aside>

    </aside>

    <main>

    </main>


</body>

</html>