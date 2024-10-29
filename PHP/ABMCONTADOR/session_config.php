<?php
session_start(); //inicia la session

// redireccion si el usuario no esta logiado
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time(); 
} else if (time() - $_SESSION['created'] > 1800) { // tiempo
   
    session_regenerate_id(true); 
    $_SESSION['created'] = time();
}

//
session_set_cookie_params([
    'lifetime' => 0, 
    'path' => '/', // dominio
    'domain' => $_SERVER['HTTP_HOST'], // dominio
    'secure' => true, // cokkies HTTPS
    'httponly' => true, // acessible HTTP 
    'samesite' => 'Strict', //previene ataques
]);
?>
