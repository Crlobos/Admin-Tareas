<?php
session_start();
include 'DB.php'; // Asegúrate de que este archivo esté en la misma carpeta o proporciona la ruta correcta

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}

// Lógica para obtener las tareas del usuario desde la base de datos
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Manejo de la inserción de tareas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_text = $_POST['task_text']; // Cambié 'task_name' a 'task_text'
    $user_id = $_SESSION['user_id'];

    // Insertar la nueva tarea en la base de datos
    $sql = "INSERT INTO tasks (text, user_id, completed) VALUES (?, ?, FALSE)"; // Cambié 'task_name' a 'text' y agregué 'completed'
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_text, $user_id]);
}

// Luego, asegúrate de mostrar las tareas después de agregar una nueva
$query = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Asignadas</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de tener este archivo CSS -->
</head>
<body>
    <header>
        <a href="logout.php" class="logout-button">Salir</a>
    </header>
    <section class="lista">
        <h1>Tareas Asignadas</h1>
        <div id="task-list">
            <?php foreach ($tasks as $task): ?>
                <div class="task-item">
                    <p><?php echo htmlspecialchars($task['text']); ?></p> <!-- Cambié 'task_name' a 'text' -->
                    <button class="complete-task" data-id="<?php echo $task['id']; ?>">
                        <?php echo $task['completed'] ? 'Desmarcar' : 'Listo'; ?>
                    </button>
                    <button class="delete-task" data-id="<?php echo $task['id']; ?>">Eliminar</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="inputbox">
            <input type="text" id="task-input" placeholder="Agregar nueva tarea">
            <button id="add-task-button">Agregar Tarea</button>
        </div>
        <div id="message-container" style="display: none;">
            <p id="message" style="color: red;"></p> <!-- Mensaje de error o éxito -->
        </div>
    </section>
    <script src="script.js"></script> <!-- Asegúrate de que este archivo exista -->
</body>
</html>