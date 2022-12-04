<?php 
// Autorisation - Access Control

// Checker si l'utilisateur est connecter ou non
if (!isset($_SESSION['user-admin'])) { //if user is not logged in
	// rediriger a la page de connexion avec un msg
	$_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
    
    header('location:'.SITEURL.'admin/login.php');
}


?>
