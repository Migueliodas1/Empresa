<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM proveedor WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: proveedor.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al eliminar el proveedor: " . $stmt->error . "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No se ha proporcionado un ID de proveedor.</div>";
}
?>
