<?php
session_start();
require_once 'conexion.php';
 
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../LoginConRoles/login.php');
    exit();
}

$roles = [];
$result = $mysqli->query("SELECT * FROM roles");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_rol = intval($_POST['id_rol']);

    $stmt = $mysqli->prepare("INSERT INTO usuario (nombre, mail, email, password, id_rol) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssssi", $nombre, $email, $email, $password, $id_rol);
        
        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $error = "Error al crear el usuario. Inténtalo de nuevo más tarde.";
        }
        
        $stmt->close();
    } else {
        $error = "Error preparando la consulta. Inténtalo de nuevo más tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Crear Nuevo Usuario</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
                <label for="id_rol" class="form-label">Rol:</label>
                <select class="form-control" id="id_rol" name="id_rol" required>
                    <?php foreach($roles as $rol): ?>
                        <option value="<?php echo htmlspecialchars($rol['id']); ?>">
                            <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>