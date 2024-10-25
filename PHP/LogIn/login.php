<?php
session_start();

// Verifica si el usuario ya está logueado
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('conexion.php');
    
    $login = $_POST['login'];
    $clave = $_POST['clave'];
    
    // Verificar las credenciales del usuario
    $query = "SELECT * FROM usuarios WHERE login = ? AND clave = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $login, $clave);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $login;
        header("Location: index.php");
        exit;
    } else {
        // Error en las credenciales
        echo "Usuario o clave incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #login-container {
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div id="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="login.php">
            <input type="text" name="login" placeholder="Usuario" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>

</html>
