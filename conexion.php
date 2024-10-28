<?php
$host = 'localhost';
$dbname = 'empresa';
$username = 'root';
$password = '';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Error de conexión: " . htmlspecialchars($mysqli->connect_error));
}

if (!$mysqli->set_charset("utf8")) {
    die("Error cargando el conjunto de caracteres utf8: " . htmlspecialchars($mysqli->error));
}
?>