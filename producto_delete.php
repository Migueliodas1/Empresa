<?php
require_once 'validsession.php';
require_once 'conexion.php';
validarAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM producto WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: producto.php");
        exit;
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }
}
?>