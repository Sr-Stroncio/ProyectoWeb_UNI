<?php

session_start();

require_once __DIR__ . "/../database/conexion.php";
require_once __DIR__ . "/../utils/rutas.php";

$error = $_SESSION['error_registro'] ?? '';

$nombre_guardado = $_SESSION['registro_nombre'] ?? '';
$correo_guardado = $_SESSION['registro_correo'] ?? '';

// Borramos todas las sesion que habian antes luego de guardarlas para mostrarlas en los input
// y asi que el usuario no tenga que escribir todo de nuevo cuando cometa un error en el registro

unset($_SESSION['error_registro']);
unset($_SESSION['registro_nombre']);
unset($_SESSION['registro_correo']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_institucion = trim($_POST['nombre_institucion'] ?? '');
    $correo_institucion = trim($_POST['correo_institucion'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';

    // Guardamos datos para que no se borren si hay error y luego ponerlas en las bariables de arriba
    // y repetir esto cada que se ponga un campo erroneo

    $_SESSION['registro_nombre'] = $nombre_institucion;
    $_SESSION['registro_correo'] = $correo_institucion;

    // apartir de aqui todos estos IF son de validaciones del formulario
    // cosas como que no esten los campos vacios, que las contrasenas sean iguales etc...

    // 1. Validar campos vacíos
    if (
        $nombre_institucion === '' ||
        $correo_institucion === '' ||
        $password === '' ||
        $password_confirmar === ''
    ) {
        $_SESSION['error_registro'] = 'Todos los campos son obligatorios.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 2. Validar correo
    if (!filter_var($correo_institucion, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_registro'] = 'El correo no tiene un formato válido.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 3. Validar contraseñas iguales
    if ($password !== $password_confirmar) {
        $_SESSION['error_registro'] = 'Las contraseñas no coinciden.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 4. Validar longitud mínima de contraseña
    if (strlen($password) < 6) {
        $_SESSION['error_registro'] = 'La contraseña debe tener al menos 6 caracteres.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // Limpiar datos antes de meterlos en consultas SQL
    $nombre_institucion = mysqli_real_escape_string($conexion, $nombre_institucion);
    $correo_institucion = mysqli_real_escape_string($conexion, $correo_institucion);
    $password = mysqli_real_escape_string($conexion, $password);

    // 5. Comprobar si ya existe el correo, aqui pongo limit 1 porque si ya existe uno no cumple con la
    // validacion

    $sql_email = "SELECT ID 
                    FROM Usuario 
                    WHERE Email = '$correo_institucion'
                    LIMIT 1";

    // aqui hago la llamda a la consulta que guarte arriba en sql_email

    $resultado_email = mysqli_query($conexion, $sql_email);

    if (!$resultado_email) {
        die("Error consultando el correo: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado_email) > 0) {
        $_SESSION['error_registro'] = 'Ya existe una cuenta con ese correo.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 6. Insertar en Usuario
    $rol = 'cliente';

    $sql_usuario = "INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password)
                    VALUES ('$rol', '$nombre_institucion', NULL, '$correo_institucion', '$password')";

    $resultado_usuario = mysqli_query($conexion, $sql_usuario);

    if (!$resultado_usuario) {
        $_SESSION['error_registro'] = 'No se pudo crear el usuario.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 7. Obtener el ID del usuario creado
    $id_usuario_nuevo = mysqli_insert_id($conexion);


    // 8. Insertar en Cliente
    $sql_cliente = "INSERT INTO Cliente (ID_user)
                    VALUES ($id_usuario_nuevo)";

    $resultado_cliente = mysqli_query($conexion, $sql_cliente);

    if (!$resultado_cliente) {
        $_SESSION['error_registro'] = 'No se pudo crear el cliente.';
        header('Location: ' . $base_url . 'pages/registro.php');
        exit;
    }

    // 9. Crear sesión de empresa
    $_SESSION['empresa_id'] = $id_usuario_nuevo;
    $_SESSION['empresa_usuario'] = $correo_institucion;
    $_SESSION['empresa_rol'] = $rol;
    $_SESSION['empresa_nombre'] = $nombre_institucion;

    unset($_SESSION['registro_nombre']);
    unset($_SESSION['registro_correo']);

    header('Location: ' . $base_url . 'index.php');
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

    <base href="<?= $base_url ?>">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/lading_page.css">
    <link rel="stylesheet" href="css/estilos-login-app.css">
    <link rel="stylesheet" href="css/estilos-registro.css">
    <link rel="shortcut icon" href="assets/DoA color.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../components/header.php'; ?>

    <div class="contenedor-tarjeta">
        <div class="tarjeta">

            <div class="panel-institucion">
                <img src="assets/logoGTI.svg" alt="GTI" class="logo-gti-grande">
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