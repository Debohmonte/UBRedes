<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['pass']); // Encrypt password

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario AND password = :password");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['usuario'] = $user['login'];
            header('Location: DataIngreso.php');
            exit();
        } else {
            echo "Usuario o contraseña incorrecta.";
        }
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
    }
}
?>
