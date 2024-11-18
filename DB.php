<?php
$host = "localhost"; // Cambia esto si tu servidor de base de datos está en otra dirección
$dbname = "Tareas"; // Cambia esto por el nombre de tu base de datos
$user = "postgres"; // Cambia esto por tu usuario de base de datos
$password = "root"; // Cambia esto por tu contraseña de base de datos

try {
    $dsn = "pgsql:host=$host;dbname=$dbname"; // Data Source Name
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>