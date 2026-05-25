<?php

session_start();

require_once __DIR__ . "/../database/conexion.php";

$error = $_SESSION['error_login'] ?? '';
$correo_guardado = $_SESSION['correo_login'] ?? '';

unset($_SESSION['error_login']);
unset($_SESSION['correo_login']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    $sql = "SELECT ID, Rol, Nombre, Email, Password
            FROM Usuario
            WHERE Email = ?
            AND Rol = 'cliente'
            LIMIT 1";

    $stmt = mysqli_prepare($conexion, $sql);

    if (!$stmt) {
        die("Error preparando la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "s", $correo);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($resultado)) {

        if ($usuario['Password'] === $password) {

            $_SESSION['empresa_id'] = $usuario['ID'];
            $_SESSION['empresa_usuario'] = $usuario['Email'];
            $_SESSION['empresa_rol'] = $usuario['Rol'];
            $_SESSION['empresa_nombre'] = $usuario['Nombre'];

            header('Location: /index.php');
            exit;
        }
    }

    $_SESSION['error_login'] = 'Correo o contraseña incorrectos.';
    $_SESSION['correo_login'] = $correo;

    header('Location: /pages/log-in-app.php');
    exit;
}

?>

<!-- comienzo del html -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA — Iniciar sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/lading_page.css">
    <link rel="stylesheet" href="../css/estilos-login-app.css">
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
                    Accede con las credenciales<br>
                    proporcionadas por tu institución.
                </p>

                <div class="caja-instancia">
                    <p class="label-instancia">INSTANCIA</p>
                    <p class="valor-instancia">gti.doa.edu</p>
                </div>
            </div>

            <div class="panel-form">
                <p class="texto-acceso">ACCESO</p>
                <h2 class="titulo-form">Iniciar sesión</h2>

                <?php if ($error !== ''): ?>
                    <p class="texto-error"><?= $error ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <p class="texto-campo">correo</p>
                    <input class="caja-input" type="text" name="correo"
                        placeholder="usuario@gti.doa.edu"
                        value="<?= htmlspecialchars($correo_guardado) ?>">

                    <p class="texto-campo">Contraseña</p>
                    <input class="caja-input" type="password" name="password"
                        placeholder="••••••••">

                    <div class="fila-opciones">
                        <label class="label-recordar">
                            <input type="checkbox" name="recordar">
                            Recordarme
                        </label>
                        <a href="#">¿Olvidaste la contraseña?</a>
                    </div>

                    <button type="submit" class="boton-entrar">ENTRAR</button>
                </form>

                <p class="texto-soporte">
                    ¿No tienes cuenta? <a href="/pages/registro.php">Registrate</a>
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