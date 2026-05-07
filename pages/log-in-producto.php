<?php
session_start();

$usuarios = [
    'alumno@gti.doa.edu'   => ['password' => 'alumno1234',  'rol' => 'alumno',   'nombre' => 'Laura García'],
    'profesor@gti.doa.edu' => ['password' => 'profe1234',   'rol' => 'profesor', 'nombre' => 'Prof. García'],
    'admin@doa.edu'        => ['password' => 'admin1234',   'rol' => 'admin',    'nombre' => 'Administrador'],
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo   = htmlspecialchars(trim($_POST['correo'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (isset($usuarios[$correo])) {
        if ($usuarios[$correo]['password'] === $password) {
            $_SESSION['usuario'] = $correo;
            $_SESSION['rol']     = $usuarios[$correo]['rol'];
            $_SESSION['nombre']  = $usuarios[$correo]['nombre'];

            if ($usuarios[$correo]['rol'] === 'admin') {
                // TODO: cambiar cuando este lista la pagina
                header('Location: ../pages/dashboard-admin.php');
            } elseif ($usuarios[$correo]['rol'] === 'profesor') {
                // TODO: cambiar cuando este lista la pagina
                header('Location: ../pages/dashboard-profesor.php');
            } else {
                // TODO: cambiar cuando este lista la pagina
                header('Location: ../pages/dashboard-alumno.php');
            }
            exit;
        } else {
            $error = 'Contraseña incorrecta.';
        }
    } else {
        $error = 'No existe una cuenta con ese correo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA — Accede a tu cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/lading_page.css">
    <link rel="stylesheet" href="../css/estilos-login.css">
</head>
<body>

    <header>
        <div class="div-logos">
            <img class="GTI_logo" src="../assets/logoGTI.svg" alt="GTI Logo">
            <img class="DOA_logo" src="../assets/DoA color.svg" alt="DOA Logo">
        </div>

        <nav>
            <a href="#">Servicios</a>
            <a href="#home">Home</a>
            <a href="#sobre-nosotros">Sobre nosotros</a>
        </nav>

        <!-- redireccion hacia la pagina de login -->
        <a class="btn-empezar" href="#">
            Inicia sesion
        </a>
    </header>

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
                    value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">

                <p class="texto-campo">Contraseña</p>
                <input class="caja-input" type="password" name="password"
                    placeholder="••••••••">

                <p class="olvide">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </p>

                <button type="submit" class="boton-entrar">ENTRAR</button>
            </form>

            <p class="texto-planes">
                ¿Aún no eres cliente? <a href="#">Ver planes</a>
            </p>
        </div>

    </div>

</body>
</html>