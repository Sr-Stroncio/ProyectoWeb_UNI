<?php
// logica de registro — pendiente de base de datos
session_start();

$error = $_SESSION['error_registro'] ?? '';
unset($_SESSION['error_registro']);

?>

<!-- comienzo del html -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA — Crear cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/lading_page.css">
    <link rel="stylesheet" href="../css/estilos-login-app.css">
    <link rel="stylesheet" href="../css/estilos-registro.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <base href="/">
</head>

<body>
    <?php include '../components/header.php'; ?>

    <div class="contenedor-tarjeta">
        <div class="tarjeta">

            <div class="panel-institucion">
                <img src="../assets/logoGTI.svg" alt="GTI" class="logo-gti-grande">
                <p class="nombre-grado">Grado en Tecnologías Interactivas</p>
                <p class="campus">Campus de Gandia — Universitat Politècnica de València</p>

                <div class="separador"></div>

                <p class="texto-credenciales">
                    Registra tu institución para<br>
                    acceder a la plataforma DOA.
                </p>

                <div class="caja-instancia">
                    <p class="label-instancia">INSTANCIA</p>
                    <p class="valor-instancia">gti.doa.edu</p>
                </div>
            </div>

            <div class="panel-form">
                <p class="texto-acceso">REGISTRO</p>
                <h2 class="titulo-form">Crear cuenta</h2>

                <?php if ($error !== ''): ?>
                    <p class="texto-error"><?= $error ?></p>
                <?php endif; ?>

                <form method="POST" action="">

                    <p class="texto-campo">Nombre de la institución</p>
                    <input class="caja-input" type="text" name="nombre_institucion"
                        placeholder="Ej: Universitat Politècnica de València">

                    <p class="texto-campo">Correo de la institución</p>
                    <input class="caja-input" type="email" name="correo_institucion"
                        placeholder="contacto@institucion.es">

                    <p class="texto-campo">Dirección</p>
                    <input class="caja-input" type="text" name="direccion"
                        placeholder="Calle, número, ciudad">

                    <p class="texto-campo">Contraseña</p>
                    <input class="caja-input" type="password" name="password"
                        placeholder="••••••••">

                    <p class="texto-campo">Confirmar contraseña</p>
                    <input class="caja-input" type="password" name="password_confirmar"
                        placeholder="••••••••">

                    <button type="submit" class="boton-entrar">CREAR CUENTA</button>

                </form>

                <p class="texto-soporte">
                    ¿Ya tienes cuenta? <a href="pages/log-in-app.php">Inicia sesión</a>
                </p>
            </div>

        </div>
    </div>

    <script>
        const mensajeError = document.querySelector(".texto-error");

        if (mensajeError) {
            setTimeout(() => {
                mensajeError.style.display = "none";
            }, 2000);
        }
    </script>
</body>

</html>