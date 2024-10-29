<?php
session_start();//ssi hay sesion 
session_destroy();// matar session 
header('Location: FormLogin.php');// redirigir a login
exit();
?>