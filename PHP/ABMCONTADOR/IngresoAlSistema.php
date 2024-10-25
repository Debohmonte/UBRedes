<?php
session_start();
include('db_connection.php'); // Make sure the path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['pass']); // Hash the password with SHA-1 to match the stored hash

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario AND password = :password");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // If user exists and password matches, set session and redirect
            $_SESSION['usuario'] = $user['login'];
            header('Location: DataIngreso.php');
            exit();
        } else {
            // If user not found or password doesn't match
            echo "Usuario o contraseña incorrecta.";
        }
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
    }
}
?>
