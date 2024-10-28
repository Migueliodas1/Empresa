<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$mysqli = new mysqli($host, $username, $password, $dbname);

$sql_roles = "SELECT * FROM roles";
$result_roles = $mysqli->query($sql_roles);
$roles = $result_roles->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql_usuario = "SELECT * FROM usuario WHERE id = ?";
    $stmt_usuario = $mysqli->prepare($sql_usuario);
    $stmt_usuario->bind_param('i', $id);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $usuario = $result_usuario->fetch_assoc();
    
    if (!$usuario) {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $id_rol = filter_var($_POST['id_rol'], FILTER_SANITIZE_NUMBER_INT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico no válido.";
    } else {
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nombre = ?, email = ?, password = ?, id_rol = ? WHERE id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('sssii', $username, $email, $password, $id_rol, $id);
        } else {
            $sql = "UPDATE usuario SET nombre = ?, email = ?, id_rol = ? WHERE id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ssii', $username, $email, $id_rol, $id);
        }

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $error = "Error al actualizar el usuario: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Actualizar Usuario</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña (dejar en blanco para mantener la actual):</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            
            <div class="mb-3">
                <label for="id_rol" class="form-label">Rol:</label>
                <select class="form-control" id="id_rol" name="id_rol" required>
                    <?php foreach($roles as $rol): ?>
                        <option value="<?php echo $rol['id']; ?>" 
                                <?php echo ($rol['id'] == $usuario['id_rol']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
