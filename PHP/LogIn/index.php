<?php
// Iniciar la sesión
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Redirigir al formulario de login si no hay sesión activa
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
include('conexion.php');

// Obtener el login del usuario desde la sesión
$login = $_SESSION['usuario'];

// Consulta para obtener los datos del usuario
$query = "SELECT id_sesion, contador_sesion FROM usuarios WHERE login = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $login);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si se encontraron los datos del usuario
if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    $id_sesion = $usuario['id_sesion'];
    $contador_sesion = $usuario['contador_sesion'];
} else {
    // En caso de no encontrar el usuario, redirigir o mostrar un mensaje
    echo "Error: No se encontraron datos para este usuario.";
    exit;
}

// Actualizar el contador de sesión
$contador_sesion += 1;
$update_query = "UPDATE usuarios SET contador_sesion = ? WHERE login = ?";
$stmt_update = $conn->prepare($update_query);
$stmt_update->bind_param('is', $contador_sesion, $login);
$stmt_update->execute();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #contenedor {
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .info-sesion {
            font-size: 1.2em;
            margin: 20px 0;
            padding: 15px;
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f0f0f0;
        }

        .info-sesion p {
            margin: 10px 0;
        }

        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #45a049;
        }

        #end-session {
            background-color: #f44336;
        }

        #end-session:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>
    <div id="contenedor">
        <h1>Nombre de la aplicación: Facturacion</h1>
        <h2>Nombre del alumno: Debora Monyeverde</h2>

        <div class="info-sesion">
            <h2>Información de Sesión</h2>
            <p><strong>Identificativo de sesión:</strong> <?php echo $id_sesion; ?></p>
            <p><strong>Login de usuario:</strong> <?php echo $login; ?></p>
            <p><strong>Contador de sesión:</strong> <?php echo $contador_sesion; ?></p>
        </div>

        <div class="buttons">
            <button id="modulo1" onclick="location.href='modulo1.php'">Ingrese a el Gestor de Facturas</button>
            <button id="end-session" onclick="location.href='logout.php'">Terminar sesión</button>
        </div>
    </div>
</body>

</html>
