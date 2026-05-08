<?php
// codigo php para manejar el inicio de sesion permisos roles etc...
session_start();

$usuarios_app = [
    'dapasa@har.upv.es' => [
        'password' => '1234',
        'rol' => 'admin',
        'nombre' => 'Daniel'
    ],

    'jogilo@upvnet.upv.es' => [
        'password' => '4567',
        'rol' => 'admin',
        'nombre' => 'José'
    ],
];

$error = $_SESSION['error_login'] ?? '';
$correo_guardado = $_SESSION['correo_login'] ?? '';

unset($_SESSION['error_login']);
unset($_SESSION['correo_login']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($usuarios_app[$correo]) && $usuarios_app[$correo]['password'] === $password) {
        $_SESSION['empresa_usuario'] = $correo;
        $_SESSION['empresa_rol'] = $usuarios_app[$correo]['rol'];
        $_SESSION['empresa_nombre'] = $usuarios_app[$correo]['nombre'];

        header('Location: /index.php');
        exit;
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
                    <p class="texto-campo">Usuario / correo</p>
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
                    ¿Problemas de acceso? <a href="#">Contacta con soporte</a>
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