<?php 
require_once '../config/functions.php';

if(session_status() == PHP_SESSION_NONE){ // s'il n'y a pas de session
    session_start();
}

if(!empty($_POST)){
    
    $errors = array();
    require_once '../config/constants.php';
    
    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) { // si le champ est vide ou contient des caracteres non valides
        
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumerique)";
    }else {
        
        $username = $_POST['username'];
        // verifier si ce username existe dans la DB
        $sql = "SELECT id FROM tbl_users WHERE username = '$username'"; // utiliser prepare()
        $res = mysqli_query($conn, $sql);
        
        $count = mysqli_num_rows($res);
        
        if($count == 1){ // S'il y a 1 enrgstmt correspondant
            $errors['username'] = "Ce pseudo est deja pris";
        }
    }
    
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // si pas d'email ou email ne correspond pas au filtre
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        
        $email = $_POST['email'];
        $sql2 = "SELECT id FROM tbl_users WHERE email = '$email'"; // utiliser prepare()
        $res2 = mysqli_query($conn, $sql2); // val a passer en param a notre req
        $count2 = mysqli_num_rows($res2);
        if($count2 > 0){
            $errors['email'] = "Cet email est deja utlisé pour un autre compte";
        }
    }
    
    if(empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) { // si pas d'email ou email ne correspond pas au filtre
        
        $errors['password'] = "Votre mot de passe n'est pas valide";
    }
    
    if(empty($errors)){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        
        $token = str_random(60); // pour verifier l'user lors de changement de pwd  
        // utiliser prepare() pour securiser la req
        $sql3 = "INSERT INTO tbl_users SET 
        username = '$username', 
        password = '$password', 
        email = '$email', 
        confirmation_token = '$token'";
            
        mysqli_query($conn, $sql3);
        
        $user_id = mysqli_insert_id($conn); // dernier id généré dans tbl_users
        
        // Envoi d'email de confirmation 
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8090/fo/user/user-confirm.php?id=$user_id&token=$token");
        
        $_SESSION['flash']['success'] = "<div class='col-3 success'>Un email de confirmation vous a été envoyé pour valider votre compte.</div>";
        header("location: user-login.php"); // 
        exit();
    }
}


?>

<?php require_once 'partials-user/header.php'; // on met toute la partie affichage en bas de la logique car on a redirigé l'user dans une autre page (ligne 69) ?> 

<div class="container yellow">
    
    <h1 class="text-center">S'inscrire</h1>
    
    <?php if(!empty($errors)): ?>
        <div class="text-center error">
            <ul class="col-3 " style="list-style-type: none; ">
                <p>Vous n'avez pas rempli le formulaire correctement</p>
                <?php foreach($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    

    <?php
        if (isset($_SESSION['flash']['success'])) {
            echo $_SESSION['flash']['success'];
            unset($_SESSION['flash']['success']);
        }

        ?>
    <br><br>
    

    <form action="" method="POST" class="register">
    
        <div class="order-label">
            <label for="">Pseudo</label>
            <input type="text" name="username" class="input-register" />
        </div>

        <div class="order-label">
            <label for="">Email</label>
            <input type="text" name="email" class="input-register" />
        </div>

        <div class="order-label">
            <label for="">Mot de passe</label>
            <input type="password" name="password" class="input-register" />
        </div>

        <div class="order-label">
            <label for="">Confirmer votre mot de passe</label>
            <input type="password" name="confirm_password" class="input-register" />
        </div>

        <br>
        <div class="order-label">
            <button type="submit" id="mybtn2" class="btn btn-primary">M'inscrire</button>
        </div>
    </form>
    
</div>

<?php require 'partials-user/footer.php'; ?>