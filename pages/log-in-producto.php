<!-- 


codigo php para manejar el inicio de sesion permisos roles etc... 


-->
<?php
// codigo php para manejar el inicio de sesion permisos roles etc...
// codigo php para manejar el inicio de sesion permisos roles etc...

include '../utils/check-empresa.php';

$usuarios = [
    'l.simdre@epsg.upv.es' => [
        'password' => '9218611',
        'rol' => 'alumno',
        'nombre' => 'Lief Simants Dredge'
    ],

    'm.kirkam@epsg.upv.es' => [
        'password' => '1320191',
        'rol' => 'alumno',
        'nombre' => 'Merline Kirdsch Kampshell'
    ],

    'd.rawabc@epsg.upv.es' => [
        'password' => '9971924',
        'rol' => 'alumno',
        'nombre' => 'Debora Rawstorne'
    ],

    'k.poumai@upv.es' => [
        'password' => '4525956',
        'rol' => 'profesor',
        'nombre' => 'Kevan Pounds Mainston'
    ],

    'l.prista@upv.es' => [
        'password' => '6055365',
        'rol' => 'profesor',
        'nombre' => 'Luelle Pridmore Starsmeare'
    ],

    'e.mermiz@upv.es' => [
        'password' => '6738133',
        'rol' => 'profesor',
        'nombre' => 'Eolande Merriton Mizzi'
    ],

    'o.breshe@upv.es' => [
        'password' => '1316390',
        'rol' => 'admin',
        'nombre' => 'Ondrea Brezlaw Sherwill'
    ],

    'b.maltho@upv.es' => [
        'password' => '1970980',
        'rol' => 'admin',
        'nombre' => 'Brooke Malimoe Thomerson'
    ],
];
$error = $_SESSION['error_login'] ?? '';
$correo_guardado = $_SESSION['correo_login'] ?? '';

unset($_SESSION['error_login']);
unset($_SESSION['correo_login']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($usuarios[$correo]) && $usuarios[$correo]['password'] === $password) {
        $_SESSION['usuario'] = $correo;
        $_SESSION['rol'] = $usuarios[$correo]['rol'];
        $_SESSION['nombre'] = $usuarios[$correo]['nombre'];

        if ($_SESSION['rol'] === 'admin') {
            header('Location: /pages/dashboard-alumno.php');
            exit;
        }

        if ($_SESSION['rol'] === 'profesor') {
            header('Location: /pages/dashboard-alumno.php');
            exit;
        }

        header('Location: /pages/dashboard-alumno.php');
        exit;
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
            <p class="texto-pie">
                ¿No tienes cuenta? <a href="#">Ver planes →</a>
            </p>
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