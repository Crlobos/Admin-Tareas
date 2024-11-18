<?php
session_start();
include 'DB.php'; // Asegúrate de que este archivo esté en la misma carpeta o proporciona la ruta correcta

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // Redirigir a la página de tareas si ya está autenticado
    header("Location: task.php");
    exit;
}

$message = ""; // Variable para almacenar mensajes de error

// Manejo del inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar que el usuario exista y que la contraseña sea correcta
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Guardar el ID del usuario en la sesión
        header("Location: task.php"); // Redirigir a la página de tareas
        exit;
    } else {
        $message = "Credenciales incorrectas"; // Manejar el error de credenciales
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de tener este archivo CSS -->
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.5.2/dist/css/ionicons.min.css"> <!-- Para los iconos -->
</head>
<body>
    <section id="login-section">
        <form action="login.php" method="POST">
            <h1>Inicio</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="inputbox"> 
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" id="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="forget">
                <label for="remember-me"><input type="checkbox" id="remember-me"> Recuerdame</label>
                <a href="#">Olvidé mi Contraseña</a>
            </div>
            <button type="submit">Iniciar Sesión</button>
            <div class="register">
                <p>No tengo cuenta <a href="register.php">Regístrate</a></p>
            </div>
        </form>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
    </section>
</body>
</html>