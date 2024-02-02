<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Invalidar la cookie de sesión si se ha establecido
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Eliminar la cookie de mantener sesión
if (isset($_COOKIE['keep_session'])) {
    setcookie('keep_session', '', time()-3600, '/');
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("Location: login.php");
exit();
?>
