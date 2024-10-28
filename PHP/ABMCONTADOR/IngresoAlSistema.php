<?php
session_start();

// Intentar incluir la conexión a la base de datos
include('./DEBORA/db.php'); // Asegúrate de que la ruta sea correcta

// Habilitar el informe de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la conexión fue exitosa
if (!isset($db)) {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
    exit();
}

// Obtener los datos del formulario
$log = $_POST['usuario'] ?? '';
$cl = $_POST['pass'] ?? '';

// Verificar que los campos no estén vacíos
if (empty($log) || empty($cl)) {
    echo "Usuario o contraseña no pueden estar vacíos.";
    exit();
}

// Encriptar la contraseña
$encriptada = sha1($cl);

// Preparar y ejecutar la consulta para buscar al usuario
$stmt = $db->prepare("SELECT * FROM usuarios WHERE login = :usuario");
$stmt->bindParam(':usuario', $log);
$stmt->execute();
$usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario fue encontrado
if ($usuario_bd) {
    // Verificar si la contraseña es correcta
    if (hash_equals($usuario_bd['password'], $encriptada)) {
        // Generar un nuevo ID de sesión
        session_regenerate_id(true);
        
        // Guardar datos en la sesión
        $_SESSION['usuario'] = $usuario_bd['login'];
        $_SESSION['nuevaSesion'] = session_id(); // Guarda el nuevo ID de sesión

        // Incrementar el contador de sesiones
        $contadorActual = $usuario_bd['contador'] + 1;
        $stmt2 = $db->prepare("UPDATE usuarios SET contador = :contador WHERE login = :usuario");
        $stmt2->bindParam(':contador', $contadorActual);
        $stmt2->bindParam(':usuario', $log);
        $stmt2->execute();

        // Guardar el contador en la sesión
        $_SESSION['contador'] = $contadorActual;

        // Redirigir a la página de información de sesión
        header('Location: sessionInfo.php'); // Asegúrate de que la ruta sea correcta
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo 'Usuario no encontrado';
}
?>