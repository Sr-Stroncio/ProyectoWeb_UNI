<?php
session_start();

unset($_SESSION['empresa_usuario']);
unset($_SESSION['empresa_rol']);
unset($_SESSION['empresa_nombre']);

header('Location: /index.php');
exit;
?>