<?php 
include_once'../config/constants.php';
include_once'../config/functions.php';
session_start();
?>

<html>
    <head>
        <title>Login - Food System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
             <br><br>

             <?php
                if (isset($_SESSION['login'])) {
	                echo $_SESSION['login'];
                    unset($_SESSION['login']);
//                    var_dump($count);
                }

                if (isset($_SESSION['no-login-message'])) {
	                echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            
             ?>
             <br><br>
            
            <!--  Login Form  -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter your username"> <br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter your Password"> <br><br>
                
                <input type="submit" name="submit" value="Login" class="btn-primary">
                 <br><br>
            </form>
            
            <p class="text-center">Created By - <a href="#">MOUIGNIDAHO Issa Ben Said</a></p>
        </div>
    </body>
</html>

<?php 
    // checker si le btn Submit est cliquer ou non
    if (isset($_POST['submit'])) {
	
        // get the data from Login Form
        
        
        // SECURISATION DES REQUETES A LA BD
        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        // SQL pour checker si l'utilisateur avec ce username et ce pwd existe
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        
        // execution
        $res = mysqli_query($conn, $sql);

        // count rows pour checker si l'utilisateur existe
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // pour checker si l'utilisateur est connecter ou non. logout la detruit
            header('location:'.SITEURL.'admin/');
        } else {
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
        
}



?>