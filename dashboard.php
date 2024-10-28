<?php
require_once 'validsession.php';
session_start();
validarAdmin();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="decoracion.css">
    <script src="script.js" defer></script>
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


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Bienvenido a tu panel de control</h2>
                <p>Tu rol es: <?php echo htmlspecialchars($_SESSION['rol'] ?? ''); ?></p>
            </div>
        </div>
    </div>
</body>
</html>