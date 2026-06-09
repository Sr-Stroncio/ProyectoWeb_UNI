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

// cuentas para el desplegable de demo (no se consulta la password real)
$demo_password = '123456';
$cuentas_demo = [];
$sql_demo = "SELECT Nombre, Apellido, Email, Rol
             FROM Usuario
             WHERE Rol IN ('alumno', 'profesor', 'admin')
             ORDER BY Rol, Nombre";
$res_demo = mysqli_query($conexion, $sql_demo);
if ($res_demo) {
    while ($fila = mysqli_fetch_assoc($res_demo)) {
        $cuentas_demo[] = $fila;
    }
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

            <?php if (!empty($cuentas_demo)): ?>
                <div class="demo-cuentas" id="demoCuentas" data-password="<?= $demo_password ?>">
                    <button type="button" class="demo-toggle" id="demoToggle">
                        <span>Cuentas de demostración</span>
                        <span class="demo-flecha">&#9662;</span>
                    </button>
                    <ul class="demo-lista">
                        <?php foreach ($cuentas_demo as $cuenta): ?>
                            <li class="demo-item"
                                data-email="<?= htmlspecialchars($cuenta['Email']) ?>">
                                <span class="demo-nombre"><?= htmlspecialchars(trim($cuenta['Nombre'] . ' ' . $cuenta['Apellido'])) ?></span>
                                <span class="demo-rol"><?= ucfirst($cuenta['Rol']) ?></span>
                                <span class="demo-email"><?= htmlspecialchars($cuenta['Email']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <p class="texto-campo">Correo institucional</p>
                <input class="caja-input" type="email" name="correo" id="campoCorreo"
                    placeholder="correo@institución.es"
                    value="<?= htmlspecialchars($correo_guardado) ?>">

                <p class="texto-campo">Contraseña</p>
                <input class="caja-input" type="password" name="password" id="campoPassword"
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

        // se rellena el formulario al elegir una cuenta del desplegable
        var demoCuentas = document.getElementById('demoCuentas');

        if (demoCuentas) {
            var demoToggle = document.getElementById('demoToggle');
            var campoCorreo = document.getElementById('campoCorreo');
            var campoPassword = document.getElementById('campoPassword');
            var demoPassword = demoCuentas.getAttribute('data-password');
            var demoItems = demoCuentas.querySelectorAll('.demo-item');

            demoToggle.addEventListener('click', function() {
                demoCuentas.classList.toggle('abierto');
            });

            demoItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    campoCorreo.value = item.getAttribute('data-email');
                    campoPassword.value = demoPassword;
                    demoCuentas.classList.remove('abierto');
                });
            });

            document.addEventListener('click', function(evento) {
                if (!demoCuentas.contains(evento.target)) {
                    demoCuentas.classList.remove('abierto');
                }
            });
        }
    </script>
</body>

</html>