<?php 
    include_once'../config/constants.php'; 
    include_once'../config/functions.php'; 

    // Autorisation - Access Control
    
    session_start();
    
    // Checker si l'utilisateur est connecter ou non
    if (!isset($_SESSION['user'])) { //if user is not logged in
        
        // rediriger a la page de connexion avec un msg
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";

        header('location:'.SITEURL.'admin/login.php');
    }
    
?>

<html>
	<head>
		<title>Food Order Website - Home Page</title>
        
        <link rel="stylesheet" href="../css/admin.css">
	</head>

	<body>
		<!-- Menu section Starts-->
		<div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Categoriy</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
		<!-- Menu section Ends-->