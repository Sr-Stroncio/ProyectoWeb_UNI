<?php

$servidor = "localhost";
$usuario = "doa_db";
$password = "Doa_2026.Mysql";
$base_datos = "doa_db";
$puerto = 3306;

$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos, $puerto);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8mb4");
