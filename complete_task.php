<?php
session_start();
include 'DB.php'; // Asegúrate de que este archivo esté en la misma carpeta o proporciona la ruta correcta

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}

// Manejo de la actualización de la tarea
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];

    // Actualizar el estado de la tarea
    $sql = "UPDATE tasks SET completed = NOT completed WHERE id = ?"; // Cambiar el estado
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_id]);
}
?>