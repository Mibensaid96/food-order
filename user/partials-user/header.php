<?php 
    // start session
    ob_start();
//    session_start();
    if(session_status() == PHP_SESSION_NONE){ // s'il n'y a pas de session
        session_start();
    }
?>
<?php require_once '../config/constants.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wow Food</title>

    <!-- Link our CSS file -->
<!--    <link href="../css/bootstrap.min.css" rel="stylesheet"> <!-- derange le header-->
    <link rel="stylesheet" href="../css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="../js/script.js" ></script>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container ">
            
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="../images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            
            <div class="topnav" id="myTopnav">
                
                <div class="menu text-right ">
                    <ul>
                        <li class="">
                            <a class="nav-link" href="<?php echo SITEURL; ?>">Home</a>
                        </li>
                        <?php if(isset($_SESSION['auth'])): ?>

                         <li class=" ">
                             <a class="nav-link" href="<?php echo SITEURL; ?>user/user-logout.php" class="nav-link">Log out</a>
                        </li>

                        <?php else: ?>
                        
                        <li class=" ">
                            <a class="nav-link" href="<?php echo SITEURL; ?>user/user-register.php" class="nav-link" aria-current="<?php echo SITEURL; ?>user/user-register.php">Register</a>
                        </li>
                        <li class=" ">
                            <a class="nav-link" href="<?php echo SITEURL; ?>user/user-login.php" class="nav-link">Sign in</a>
                        </li>

                        <?php endif; ?>
                        
                        <li class=" ">
                            <a class="nav-link" href="<?php echo SITEURL; ?>user/user-account.php">Account</a>
                        </li>
                        <li class=" ">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class=" "> <!-- class="nav-item "-->
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
    
    <!-- Messages Flash Here -->
    <div class="container">
        <?php if(isset($_SESSION['flash'])): ?>
            <?php foreach($_SESSION['flash'] as $type => $message): ?>
                <div class="alert <?= $type; ?>">
                    <?= $message; ?>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
    </div>
<!-- Messages Flash Here -->