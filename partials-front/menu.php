<?php 
    include_once 'config/constants.php'; 
    if(session_status() == PHP_SESSION_NONE){ // s'il n'y a pas de session
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wow Food</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="js/script.js" ></script>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            
            <div class="topnav" id="myTopnav">
                
                <div class="menu text-right">
                    <ul>
                        <li class="">
                            <a id="Home" class="nav-link" href="<?php echo SITEURL; ?>">Home</a>
                        </li>
                        <li class="">
                            <a id="Categories" class="nav-link" href="<?php echo SITEURL; ?>categories.php">Categories</a>
                        </li>
                        <li class="">
                            <a id="Foods" class="nav-link" href="<?php echo SITEURL; ?>foods.php">Foods</a>
                        </li>
                        <?php if(isset($_SESSION['auth'])): ?>
                         <li class="">
                             <a id="Deconnexion" class="nav-link" href="<?php echo SITEURL; ?>user/user-logout.php" class="nav-link">Log out</a>
                        </li>
                        <li class="">
                             <a id="Commandes" class="nav-link" href="<?php echo SITEURL; ?>user/user-account.php" class="nav-link">My Orders</a>
                        </li>
                        <?php else: ?>
                        <li class="">
                            <a id="Inscription" class="nav-link" href="<?php echo SITEURL; ?>user/user-register.php" class="nav-link active" aria-current="<?php echo SITEURL; ?>user/user-register.php">Register</a>
                        </li>
                        <li class="">
                            <a id="Connexion" class="nav-link" href="<?php echo SITEURL; ?>user/user-login.php">Sign in</a>
                        </li>
                        
                        <?php endif; ?>
                        
                        <li class=" "> 
                            <a class="nav-link" href="javascript:void(0);" class="icon" onclick="myFunction()">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->