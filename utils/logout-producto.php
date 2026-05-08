<?php
session_start();

unset($_SESSION['usuario']);
unset($_SESSION['rol']);
unset($_SESSION['nombre']);

header('Location: /pages/log-in-producto.php');
exit;
?>