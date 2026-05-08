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
// if ($_SESSION['rol'] !== 'alumno') {
//     header('Location: /pages/log-in-producto.php');
//     exit;
// }

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard-principal.css">
    <title>Dashboard alumno</title>
</head>

<body>

    <header>
        <div class="div-izquierdo">
            <div class="div-logos">
                <img class="DOA_logo" src="assets/DoA color.svg" alt="DOA Logo">
                <img class="GTI_logo" src="assets/logoGTI.svg" alt="GTI Logo">
            </div>
            <h2>Dashboard</h2>
        </div>


        <!-- redireccion hacia la pagina de servicios -->
        <div class="div-nav">
            <div class="perfil">
                <div class="perfil-info">
                    <p class="perfil-saludo">Bienvenido/a, <?= $_SESSION['nombre'] ?></p>
                    <span class="perfil-rol"><?= $_SESSION['rol'] ?></span>
                </div>

                <a class="btn-logout" href="/utils/logout-producto.php">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <section class="section-principal">
        <aside>

            <div>

            </div>

            <div>

            </div>

        </aside>

        <main>

        </main>
    </section>

</body>

</html>