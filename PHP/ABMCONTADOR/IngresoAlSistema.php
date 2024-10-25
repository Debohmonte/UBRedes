<?php
session_start();
include('db_connection.php'); // Ensure this file has a proper database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['pass']); // Encrypt the password for comparison

    try {
        // Query to check user credentials
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario AND password = :password");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['usuario'] = $user['login'];
            header('Location: DataIngreso.php'); // Redirect on success
            exit();
        } else {
            echo "Usuario o contraseña incorrecta.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display any connection/query errors
    }
}
?>
