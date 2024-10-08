<?php

$clave = '';
$md5 = '';
$sha256 = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = htmlspecialchars($_POST['clave']); //  la clave y la sanitizamos
    $md5 = md5($clave); // Encriptamos MD5
    $sha256 = hash('sha256', $clave); // Encriptamos  SHA256
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Encriptación</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .resultado {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #5c67f2;
            margin-bottom: 20px;
        }

        .clave {
            margin: 10px 0;
        }

        .encriptacion {
            color: #5c67f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="resultado">
        <h1>Resultado de Encriptación</h1>
        <?php if ($clave): ?>
            <div class="clave">Clave: <br><?php echo $clave; ?></div>
            <div class="encriptacion">Clave encriptada en MD5:<br><?php echo $md5; ?></div>
            <div class="encriptacion">Clave encriptada en SHA256:<br><?php echo $sha256; ?></div>
        <?php else: ?>
            <p>Por favor, ingrese una clave para encriptar.</p>
        <?php endif; ?>
    </div>
</body>
</html>
