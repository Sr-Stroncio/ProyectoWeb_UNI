<?php

session_start();

require_once __DIR__ . "/../database/conexion.php";

$error = $_SESSION['error_registro'] ?? '';

$nombre_guardado = $_SESSION['registro_nombre'] ?? '';
$correo_guardado = $_SESSION['registro_correo'] ?? '';
$nif_guardado = $_SESSION['registro_nif'] ?? '';

unset($_SESSION['error_registro']);
unset($_SESSION['registro_nombre']);
unset($_SESSION['registro_correo']);
unset($_SESSION['registro_nif']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_institucion = trim($_POST['nombre_institucion'] ?? '');
    $correo_institucion = trim($_POST['correo_institucion'] ?? '');
    $nif = trim($_POST['nif'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';

    // Convertimos el NIF a mayúscula y quitamos espacios y guiones
    $nif = strtoupper($nif);
    $nif = str_replace([' ', '-'], '', $nif);

    // Guardamos datos para que no se borren si hay error
    $_SESSION['registro_nombre'] = $nombre_institucion;
    $_SESSION['registro_correo'] = $correo_institucion;
    $_SESSION['registro_nif'] = $nif;

    // 1. Validar campos vacíos
    if (
        $nombre_institucion === '' ||
        $correo_institucion === '' ||
        $nif === '' ||
        $password === '' ||
        $password_confirmar === ''
    ) {
        $_SESSION['error_registro'] = 'Todos los campos son obligatorios.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 2. Validar correo
    if (!filter_var($correo_institucion, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_registro'] = 'El correo no tiene un formato válido.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 3. Validar contraseñas iguales
    if ($password !== $password_confirmar) {
        $_SESSION['error_registro'] = 'Las contraseñas no coinciden.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 4. Validar longitud mínima de contraseña
    if (strlen($password) < 6) {
        $_SESSION['error_registro'] = 'La contraseña debe tener al menos 6 caracteres.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 5. Validar NIF: una letra y 8 números
    if (!preg_match('/^[A-Z][0-9]{8}$/', $nif)) {
        $_SESSION['error_registro'] = 'El NIF tiene que ser una letra y 8 números.';
        header('Location: /pages/registro.php');
        exit;
    }

    // Limpiar datos antes de meterlos en consultas SQL
    $nombre_institucion = mysqli_real_escape_string($conexion, $nombre_institucion);
    $correo_institucion = mysqli_real_escape_string($conexion, $correo_institucion);
    $nif = mysqli_real_escape_string($conexion, $nif);
    $password = mysqli_real_escape_string($conexion, $password);

    // 6. Comprobar si ya existe el correo
    $sql_email = "SELECT ID 
                  FROM Usuario 
                  WHERE Email = '$correo_institucion'
                  LIMIT 1";

    $resultado_email = mysqli_query($conexion, $sql_email);

    if (!$resultado_email) {
        die("Error consultando el correo: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado_email) > 0) {
        $_SESSION['error_registro'] = 'Ya existe una cuenta con ese correo.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 7. Comprobar si ya existe el NIF
    $sql_nif = "SELECT ID_user 
                FROM Cliente 
                WHERE NIF = '$nif'
                LIMIT 1";

    $resultado_nif = mysqli_query($conexion, $sql_nif);

    if (!$resultado_nif) {
        die("Error consultando el NIF: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado_nif) > 0) {
        $_SESSION['error_registro'] = 'Ya existe una cuenta con ese NIF.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 8. Insertar en Usuario
    $rol = 'cliente';

    $sql_usuario = "INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password)
                    VALUES ('$rol', '$nombre_institucion', NULL, '$correo_institucion', '$password')";

    $resultado_usuario = mysqli_query($conexion, $sql_usuario);

    if (!$resultado_usuario) {
        $_SESSION['error_registro'] = 'No se pudo crear el usuario.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 9. Obtener el ID del usuario creado
    $id_usuario_nuevo = mysqli_insert_id($conexion);

    // 10. Insertar en Cliente
    $sql_cliente = "INSERT INTO Cliente (ID_user, NIF)
                    VALUES ($id_usuario_nuevo, '$nif')";

    $resultado_cliente = mysqli_query($conexion, $sql_cliente);

    if (!$resultado_cliente) {
        $_SESSION['error_registro'] = 'No se pudo crear el cliente.';
        header('Location: /pages/registro.php');
        exit;
    }

    // 11. Crear sesión de empresa
    $_SESSION['empresa_id'] = $id_usuario_nuevo;
    $_SESSION['empresa_usuario'] = $correo_institucion;
    $_SESSION['empresa_rol'] = $rol;
    $_SESSION['empresa_nombre'] = $nombre_institucion;

    unset($_SESSION['registro_nombre']);
    unset($_SESSION['registro_correo']);
    unset($_SESSION['registro_nif']);

    header('Location: /index.php');
    exit;
}

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
                        placeholder="Ej: Universitat Politècnica de València"
                        value="<?= htmlspecialchars($nombre_guardado) ?>">

                    <p class="texto-campo">Correo de la institución</p>
                    <input class="caja-input" type="email" name="correo_institucion"
                        placeholder="contacto@institucion.es"
                        value="<?= htmlspecialchars($correo_guardado) ?>">

                    <p class="texto-campo">NIF</p>
                    <input class="caja-input" type="text" name="nif"
                        placeholder="B12345678"
                        value="<?= htmlspecialchars($nif_guardado) ?>">

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