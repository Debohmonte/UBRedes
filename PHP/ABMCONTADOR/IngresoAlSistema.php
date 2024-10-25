<?php
include('./db_connection.php');  // Replace with your database connection file

session_start();
$log = $_POST['usuario'];
$cl = $_POST['pass'];
$encriptada = sha1($cl);

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario");
$stmt->bindParam(':usuario', $log);
$stmt->execute();
$usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario_bd) {
    if (hash_equals($usuario_bd['password'], $encriptada)) {
        $_SESSION['usuario'] = $usuario_bd['login'];
        $stmt2 = $conn->prepare("SELECT contador FROM usuarios WHERE login= :usuario");
        $stmt2->bindParam(':usuario', $log);
        $stmt2->execute();
        $usuarioContador = $stmt2->fetch(PDO::FETCH_ASSOC);
        $contadorActual = $usuarioContador['contador'];
        $SumarContador = $contadorActual + 1;

        $stmt3 = $conn->prepare("UPDATE usuarios SET contador = :contador WHERE login = :usuario");
        $stmt3->bindParam(':usuario', $log);
        $stmt3->bindParam(':contador', $SumarContador);
        $stmt3->execute();

        header('Location: ./DataIngreso.php?contador=' . $SumarContador);
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo 'Usuario no encontrado';
}
?>
