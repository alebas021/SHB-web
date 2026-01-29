<?php
session_start();
require '../conexion.php'; // Ruta correcta hacia la conexión

// Si ya hay sesión activa → manda al panel
if (isset($_SESSION['admin'])) {
    header("Location: productos.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $admin = $stmt->fetch();

        if ($admin) {
            $_SESSION['admin'] = $admin['id'];
            header("Location: productos.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Por favor completa ambos campos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="admin-style.css">
</head>

<body class="admin-login-body">

    <div class="login-container">

        <h2 class="login-title">Panel Admin</h2>

        <?php if ($error): ?>
            <p class="alert error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" autocomplete="off" class="login-form">

            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit">
                Ingresar
            </button>

        </form>

    </div>

</body>
</html>
