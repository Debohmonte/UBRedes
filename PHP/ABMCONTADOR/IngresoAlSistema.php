<?php
session_start();


include('./DEBORA/db.php');

//  errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($db)) {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
    exit();
}

// datos from
$log = $_POST['usuario'] ?? '';
$cl = $_POST['pass'] ?? '';


if (empty($log) || empty($cl)) {
    echo "Usuario o contraseña no pueden estar vacíos.";
    exit();
}


$encriptada = sha1($cl);

// consutla sql para la base de datps
$stmt = $db->prepare("SELECT * FROM usuarios WHERE login = :usuario");
$stmt->bindParam(':usuario', $log);
$stmt->execute();
$usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);

//usuraio encontraso
if ($usuario_bd) {
    if (hash_equals($usuario_bd['password'], $encriptada)) {
        session_regenerate_id(true);
        
        // ssesion id
        $_SESSION['usuario'] = $usuario_bd['login'];
        $_SESSION['nuevaSesion'] = session_id();

        // contador
        $contadorActual = $usuario_bd['contador'] + 1;
        $stmt2 = $db->prepare("UPDATE usuarios SET contador = :contador WHERE login = :usuario");
        $stmt2->bindParam(':contador', $contadorActual);
        $stmt2->bindParam(':usuario', $log);
        $stmt2->execute();
        $_SESSION['contador'] = $contadorActual;

        // manda a info swsion
        header('Location: sessionInfo.php'); 
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo 'Usuario no encontrado';
}
?>