<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: FormLogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e6f7ff;
        }
        .welcome-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        a {
            display: block;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
        <a href="DestruirSesion.php">Cerrar sesión</a>
    </div>
</body>
</html>
