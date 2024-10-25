<?php
// session_start();
// if(isset($_SESSION['usuario'])){
//     header('Location: Index.html');
// }
?>

<!-- FormLogin.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <form method="post" action="IngresoAlSistema.php">
        <h1>Iniciar Sesión</h1>
        <div>
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <label for="pass">Contraseña</label>
            <input type="password" id="pass" name="pass" required>
        </div>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
