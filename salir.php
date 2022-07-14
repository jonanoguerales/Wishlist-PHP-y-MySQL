<?php
session_start();
session_destroy();
// Redireccionar a la página de login:
header('Location: login.php');
?>