<?php
session_start();
require_once 'conexion.php';
require_once 'validsession.php';
validarAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM cliente WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: clientes.php');
        exit();
    } else {
        echo "Error al eliminar el cliente: " . $mysqli->error;
    }
} else {
    die('ID de cliente no proporcionado');
}
?>