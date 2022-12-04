<?php
session_start();
setcookie('remember', NULL, -1); // -1 => duree validité cookie 14 jours -1 
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous etes maintenant deconnecté';
header('Location: user-login.php');