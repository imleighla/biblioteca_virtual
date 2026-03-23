<?php
//Este archivo se encarga de cerrar la sesión del usuario y redirigirlo a la página de inicio de sesión.
// Se accede a la sesion activada para poder eliminarla correctamente.
session_start();
// Se eliminan todas las variables almacenads en la sesión. 
session_unset();
// Se destruye completamente la sesion del usuario.
session_destroy();
// Al cerrar la sesion, se redirige al usuario a la página de inicio de sesión para que pueda iniciar sesión nuevamente si lo desea.
header("Location: login.php");
exit();