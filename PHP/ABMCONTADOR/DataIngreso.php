<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../FormLogin.php');
    exit();
}

// Create a new session ID
$_SESSION['nuevaSesion'] = session_create_id();
$usuario = $_SESSION['usuario'];
$Contador = isset($_GET['contador']) ? $_GET['contador'] : 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Datos de Sesión</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="sesion.css">
</head>
<body>

<?php if (isset($_SESSION['usuario'])) { ?>
    <div class="session-container">
        <h1>Acceso Permitido</h1>
        <p>Variable Contador: <strong><?php echo $Contador; ?></strong></p>
        <h2>Sus parámetros de sesión son los siguientes:</h2>
        <div class="session-info">
            <p>Identificativo de Sesión: <strong><?php echo $_SESSION['nuevaSesion']; ?></strong></p>
            <p>Login de Usuario: <strong><?php echo $usuario; ?></strong></p>
            <p>Contador de Sesión: <strong><?php echo $Contador; ?></strong></p>
        </div>
        <div class="actions">
            <button onClick="location.href='./CRUD/index.php'">Ingrese a la aplicación</button>
            <button onClick="location.href='./DestruirSesion.php'">Terminar sesión</button>
        </div>
    </div>
<?php } ?>

</body>
</html>
