<?php

session_start();

unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_email']);
unset($_SESSION['usuario_rol']);
unset($_SESSION['usuario_nombre']);
unset($_SESSION['usuario_nombre_completo']);

header('Location: /pages/log-in-app.php');
exit;

?>