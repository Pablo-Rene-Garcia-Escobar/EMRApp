<?php
session_start();

if (!isset($_SESSION['usuario_logeado'])) {
    // Redirigir al login si no hay un usuario logueado
    header('location:login/login.php');
    exit(); // Asegura que el script se detenga después de la redirección
}

require_once "include/sidebar/sidebar.php"
?>
