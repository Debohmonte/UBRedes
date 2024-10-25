<?php
// session_start();
// if(isset($_SESSION['usuario'])){
//     header('Location: Index.html');
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <form id="Login" method="post" action="IngresoAlSistema.php">
        <h1>Iniciar Sesión</h1>
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>
        </div>
        <div class="form-group">
            <label for="pass">Contraseña</label>
            <input type="password" id="pass" name="pass" placeholder="Ingresa tu contraseña" required>
        </div>
        <div class="credenciales">
            <h3>Credenciales</h3>
            <p>Usuario: test</p>
            <p>Contraseña: redes</p>
        </div>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>