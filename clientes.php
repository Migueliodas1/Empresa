<?php
session_start();
require_once 'conexion.php';
require_once 'validsession.php';
validarSesion();

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (!isset($_SESSION['rol'])) {
    die('Acceso denegado. Inicie sesión.');
}

$query = "SELECT * FROM cliente";
$result = $mysqli->query($query);

if (!$result) {
    die('Error en la consulta: ' . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar .nav-link {
            color: white;
        }
        .table {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Clientes</a>
        <div class="collapse navbar-collapse">
            <div class="ms-auto">
                <a href="producto.php" class="nav-link">Productos</a>
                <a href="proveedores.php" class="nav-link">Proveedores</a>
                <a href="logout.php" class="nav-link">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Clientes</h1>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <p>Tu rol es: <strong><?php echo htmlspecialchars($_SESSION['rol'] ?? ''); ?></strong></p>
            </div>
        </div>
    </div>

    <table id="clientesTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['dni']); ?></td>
                        <td><?php echo htmlspecialchars($row['tel']); ?></td>
                        <td><?php echo htmlspecialchars($row['cel']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado']); ?></td>
                        <td class="text-start">
                            <a href="clientes_update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="clientes_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            <a href="producto_cliente.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Registro</a>
                        </td>
                    </tr>
                <?php endwhile;
            } else {
                echo "<tr><td colspan='9' class='text-center'>No hay clientes registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#clientesTable').DataTable({
            "paging": true,
            "searching": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            }
        });
    });
</script>
</body>
</html>
