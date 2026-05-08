<?php
session_start();

$_SESSION = [];

session_destroy();

header('Location: /pages/log-in-producto.php');
exit;
?>