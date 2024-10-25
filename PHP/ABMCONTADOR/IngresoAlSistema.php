<?php
session_start();
include('db_connection.php');  // Ensure db_connection.php is correctly configured

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['pass']); // Encrypt password to match stored format

    // Check if user exists in the database
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario AND password = :password");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['usuario'] = $user['login']; // Store user login in session
        header('Location: DataIngreso.php');   // Redirect on successful login
        exit();
    } else {
        echo 'Usuario o contraseña incorrecta';
    }
}
?>
