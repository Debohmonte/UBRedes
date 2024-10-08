<?php

sleep(3);


if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];
    
    // Recibe PST y encrpta
    $md5Hash = md5($clave);
    $sha1Hash = sha1($clave);
    

    echo "Clave original: $clave<br>";
    echo "Clave encriptada en MD5: $md5Hash<br>";
    echo "Clave encriptada en SHA1: $sha1Hash";
} else {
    
    echo "No se recibió ninguna clave.";
}
?>
