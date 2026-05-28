<?php
$host = 'localhost';
$dbname = 'doa_db';
$usuario = 'root';
$contrasena = '';

$conn = new mysqli($host, $usuario, $contrasena, $dbname);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>
