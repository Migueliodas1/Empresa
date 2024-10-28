<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM proveedor WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proveedor = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $tel = $_POST['tel'];
    $cel = $_POST['cel'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    $query = "UPDATE proveedor SET nombre=?, nit=?, tel=?, cel=?, email=?, direccion=?, estado=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssssi", $nombre, $nit, $tel, $cel, $email, $direccion, $estado, $id);

    if ($stmt->execute()) {
        header("Location: proveedor.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el proveedor: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; 
        }
        .container {
            margin-top: 50px;
            background-color: white; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #007bff; 
        }
        .btn-primary {
            background-color: #007bff; 
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3; 
        }
        .btn-secondary {
            background-color: #6c757d; 
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Editar Proveedor</h2>
        <form action="proveedor_update.php" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($proveedor['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nit" class="form-label">NIT:</label>
                <input type="text" name="nit" id="nit" class="form-control" value="<?php echo htmlspecialchars($proveedor['nit']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="tel" class="form-label">Teléfono:</label>
                <input type="text" name="tel" id="tel" class="form-control" value="<?php echo htmlspecialchars($proveedor['tel']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="cel" class="form-label">Celular:</label>
                <input type="text" name="cel" id="cel" class="form-control" value="<?php echo htmlspecialchars($proveedor['cel']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($proveedor['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo htmlspecialchars($proveedor['direccion']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="activo" <?php if ($proveedor['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                    <option value="inactivo" <?php if ($proveedor['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
                </select>
            </div>

            <div class="text-center">
                <input type="submit" value="Actualizar" class="btn btn-primary">
                <a href="proveedor.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
