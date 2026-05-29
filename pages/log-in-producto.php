<?php

require_once __DIR__ . "/../database/conexion.php";

$error = $_SESSION['error_login'] ?? '';
$correo_guardado = $_SESSION['correo_login'] ?? '';

unset($_SESSION['error_login']);
unset($_SESSION['correo_login']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($correo === '' || $password === '') {
        $_SESSION['error_login'] = 'Debes introducir correo y contraseña.';
        $_SESSION['correo_login'] = $correo;

        header('Location: /pages/log-in-producto.php');
        exit;
    }

    $correo = mysqli_real_escape_string($conexion, $correo);
    $password = mysqli_real_escape_string($conexion, $password);

    $sql = "SELECT ID, Rol, Nombre, Apellido, Email, Password
            FROM Usuario
            WHERE Email = '$correo'
            AND Rol IN ('alumno', 'profesor', 'admin')
            LIMIT 1";

    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado) === 1) {

        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario['Password'] === $password) {

            $_SESSION['usuario_id'] = $usuario['ID'];
            $_SESSION['usuario_email'] = $usuario['Email'];
            $_SESSION['usuario_rol'] = $usuario['Rol'];
            $_SESSION['usuario_nombre'] = $usuario['Nombre'];

            if ($usuario['Apellido'] !== null && $usuario['Apellido'] !== '') {
                $_SESSION['usuario_nombre_completo'] = $usuario['Nombre'] . ' ' . $usuario['Apellido'];
            } else {
                $_SESSION['usuario_nombre_completo'] = $usuario['Nombre'];
            }

            if ($usuario['Rol'] === 'admin') {
                header('Location: /pages/dashboard-admin.php');
                exit;
            }

            if ($usuario['Rol'] === 'profesor') {
                header('Location: /pages/dashboard-profesor.php');
                exit;
            }

            if ($usuario['Rol'] === 'alumno') {
                header('Location: /pages/dashboard-alumno.php');
                exit;
            }
        }
    }

    $_SESSION['error_login'] = 'Correo o contraseña incorrectos.';
    $_SESSION['correo_login'] = $correo;

    header('Location: /pages/log-in-producto.php');
    exit;
}

?>

<!-- comienzo del html -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA — Accede a tu cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/lading_page.css">
    <link rel="stylesheet" href="../css/estilos-login.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
    <base href="/">
</head>

<body>
    <!-- include del header general (se usa en las paginas de producto) -->
    <?php include '../components/header.php'; ?>

    <div class="cuerpo">

        <div class="panel-oscuro">
            <img src="../assets/DoA color.svg" alt="DOA" class="logo-panel">
            <h1 class="titulo-panel">La plataforma académica de GTI</h1>
            <p class="descripcion-panel">
                Gestión de calificaciones, comunicación y
                recursos académicos en un solo lugar.
            </p>
            <div class="lista-caracteristicas">
                <div class="ventaja">
                    <span class="circulo">&#10003;</span>
                    <p class="texto-ventaja">Calendarios y entregas unificados</p>
                </div>
                <div class="ventaja">
                    <span class="circulo">&#10003;</span>
                    <p class="texto-ventaja">Comunicación directa con profesores</p>
                </div>
                <div class="ventaja">
                    <span class="circulo">&#10003;</span>
                    <p class="texto-ventaja">Acceso desde cualquier dispositivo</p>
                </div>
            </div>

        </div>

        <div class="panel-formulario">
            <p class="texto-bienvenido">BIENVENIDO</p>
            <h2 class="titulo-formulario">Accede a tu cuenta</h2>
            <p class="subtitulo-formulario">Portal de clientes DOA</p>

            <?php if ($error !== ''): ?>
                <p class="texto-error"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <p class="texto-campo">Correo institucional</p>
                <input class="caja-input" type="email" name="correo"
                    placeholder="correo@institución.es"
                    value="<?= htmlspecialchars($correo_guardado) ?>">

                <p class="texto-campo">Contraseña</p>
                <input class="caja-input" type="password" name="password"
                    placeholder="••••••••">

                <p class="olvide">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </p>

                <button type="submit" class="boton-entrar">ENTRAR</button>
            </form>
            <p class="texto-planes">
                ¿Aún no eres cliente? <a href="pages/pagina_servicios.php">Ver planes</a>
            </p>
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