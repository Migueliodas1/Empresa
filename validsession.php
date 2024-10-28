<?php
function validarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

function validarAdmin() {
    validarSesion();
    if ($_SESSION['rol'] !== 'admin') {
        header('Location: dashboard.php');
        exit();
    }
}

function validarSupervisor() {
    validarSesion();
    if ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'supervisor') {
        header('Location: dashboard.php');
        exit();
    }
}
?>
