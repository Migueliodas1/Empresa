<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM producto WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio_compra = $_POST['precio_compra'];
    $precio_venta = $_POST['precio_venta'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];

    $query = "UPDATE producto SET nombre=?, precio_compra=?, precio_venta=?, stock=?, estado=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sdddsi", $nombre, $precio_compra, $precio_venta, $stock, $estado, $id);

    if ($stmt->execute()) {
        header("Location: producto.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el producto: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Fondo azul claro */
        }
        .container {
            margin-top: 50px;
            background-color: white; /* Fondo blanco para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para el contenedor */
            padding: 30px; /* Espaciado interno */
        }
        h2 {
            color: #007bff; /* Color del título */
        }
        .btn-primary {
            background-color: #007bff; /* Color del botón de actualización */
            border: none; /* Sin borde */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Color al pasar el ratón */
        }
        .btn-secondary {
            background-color: #6c757d; /* Color del botón de cancelar */
            border: none; /* Sin borde */
        }
        .btn-secondary:hover {
            background-color: #5a6268; /* Color al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Editar Producto</h2>
        <form action="producto_update.php" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="precio_compra" class="form-label">Precio Compra:</label>
                <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control" value="<?php echo $producto['precio_compra']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="precio_venta" class="form-label">Precio Venta:</label>
                <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control" value="<?php echo $producto['precio_venta']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" id="stock" class="form-control" value="<?php echo $producto['stock']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="disponible" <?php if ($producto['estado'] == 'disponible') echo 'selected'; ?>>Disponible</option>
                    <option value="agotado" <?php if ($producto['estado'] == 'agotado') echo 'selected'; ?>>Agotado</option>
                </select>
            </div>

            <div class="text-center">
                <input type="submit" value="Actualizar" class="btn btn-primary">
                <a href="producto.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
