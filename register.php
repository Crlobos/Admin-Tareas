<?php
include 'db.php'; // Asegúrate de que este archivo esté en la misma carpeta o proporciona la ruta correcta

$message = ""; // Variable para almacenar mensajes de éxito o error

// Manejo del registro de usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashea la contraseña

    // Inserta el nuevo usuario en la base de datos
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$username, $email, $password]);
        $message = "Registro exitoso. Puedes iniciar sesión ahora.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de tener este archivo CSS -->
</head>
<body>
    <section>
        <form action="register.php" method="POST">
            <h1>Registro</h1>
            <div class="inputbox">
                <ion-icon name="person-outline"></ion-icon>
                <input type="text" id="username" name="username" required>
                <label for="username">Nombre de usuario</label>
            </div>
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
            <button type="submit">Registrarse</button>
            <div class="register">
                <p>Ya tengo cuenta <a href="index.html">Iniciar sesión</a></p>
            </div>
        </form>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
    </section>
</body>
</html>