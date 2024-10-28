<?php
session_start();
require_once 'conexion.php';

if (!isset($_GET['id'])) {
    echo "ID de cliente no especificado.";
    exit;
}

$id_cliente = $_GET['id'];

$query = "SELECT p.id, p.nombre, v.cantidad, v.valor_unitario, v.valor_total, v.fecha 
          FROM venta v
          JOIN producto p ON v.id_producto = p.id
          WHERE v.id_cliente = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Comprados por Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Fondo azul claro */
        }
        .navbar {
            background-color: #007bff; /* Color del navbar */
            padding: 15px;
        }
        .nav-link {
            color: white; /* Color de los enlaces */
            margin: 0 10px;
        }
        .nav-link:hover {
            text-decoration: underline; /* Efecto hover */
        }
        .container {
            margin-top: 30px;
            background-color: white; /* Fondo blanco para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para el contenedor */
            padding: 20px; /* Espaciado interno */
        }
        .table th {
            background-color: #007bff; /* Color de fondo de los encabezados */
            color: white; /* Color de texto de los encabezados */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #e9f3ff; /* Fondo alterno para filas */
        }
        .btn {
            margin: 0 5px; /* Espaciado entre botones */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleMenu() {
            $('.menu-items').toggleClass('active');
        }
    </script>
</head>
<body>
<nav class="navbar">
    <div class="nav-content">
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu-items">
            <a href="producto.php" class="nav-link">Productos</a>
            <a href="clientes.php" class="nav-link">Clientes</a>
            <a href="proveedores.php" class="nav-link">Proveedores</a>
            <a href="logout.php" class="nav-link">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Productos Comprados</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Valor Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['valor_unitario']); ?></td>
                    <td><?php echo htmlspecialchars($row['valor_total']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                    <td>
                        <a href="producto_update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="producto_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
