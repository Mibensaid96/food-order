<?php
include'partials/menu.php';

// Detruire la session de l'utilisateur qui  se deconnecte
session_destroy();

header('location:'.SITEURL.'admin/login.php');




?>