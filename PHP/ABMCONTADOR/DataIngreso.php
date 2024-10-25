<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: FormLogin.php');  // Redirect if no session
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Data de Ingreso</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
    <p>Esta es la página de datos después de iniciar sesión.</p>
    <a href="DestruirSesion.php">Cerrar sesión</a>
</body>
</html>
