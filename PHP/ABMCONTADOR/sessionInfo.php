<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: FormLogin.php'); // Redirige si no hay usuario en sesión
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #e6f7ff;
            padding: 20px;
        }
        .session-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .session-container h2 {
            font-size: 1.5em;
        }
        .session-container p {
            margin: 10px 0;
        }
        .actions {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .close-session {
            background-color: #d9534f;
            color: #fff;
        }
        .go-to-facturas {
            background-color: #5bc0de;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="session-container">
        <h2>Información de Sesión</h2>
        <p>Identificativo de sesión: <strong><?php echo htmlspecialchars($_SESSION['nuevaSesion']); ?></strong></p>
        <p>Login de usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>
        <p>Contador de sesión: <strong><?php echo $_SESSION['contador']; ?></strong></p>
        <div class="actions">
            <button class="go-to-facturas" onclick="window.location.href='./DEBORA/index.php'">Ir a Gestión de Facturas</button>
            <button class="close-session" onclick="window.location.href='DestruirSesion.php'">Terminar sesión</button>
        </div>
    </div>
</body>
</html>