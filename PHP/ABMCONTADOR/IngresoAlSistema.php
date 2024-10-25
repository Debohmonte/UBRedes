<?php
session_start();
include('db_connection.php'); // Make sure this path is correct and points to db_connection.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['pass']); // Encrypt password

    // Ensure $conn is defined and valid
    if (isset($conn)) {
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
    } else {
        echo "Database connection not established.";
    }
}
?>
