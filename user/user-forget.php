<?php 
if(!empty($_POST) && !empty($_POST['email'])){ // si des datas ont ete posté et que l'email n'est pas vide 
    
    require '../config/constants.php';
    require '../config/functions.php'; 

    $email = $_POST['email'];
    
    $sql = $conn->prepare("SELECT * FROM tbl_users WHERE email = ? AND confirmed_at IS NOT NULL "); // Si c'est le bon identifiant et que le compte a deja ete confirmer (mail de confirmation)  AND confirmed_at IS NOT NULL
    
    $sql->bind_param("s",$email);
    $sql->execute();
    
    $res = $sql->get_result();
    $user = mysqli_fetch_assoc($res);
//    debug($user);
    
    if($user){ // Si l'user existe
        
        session_start();
        $reset_token = str_random(60); // generer un token
        $sql2 = $conn->prepare('UPDATE tbl_users SET reset_token = ?, reset_at = NOW() WHERE id = ?'); // remplacer le reset_token par le nvx et le reset_at par la date d'aujourd'hui
        $sql2->bind_param("si",$reset_token, $user['id'])->execute();
        
        
        debug($user);
        
        $_SESSION['flash']['success'] = 'Les instruction de rappel du mot de passe vous ont ete envoyer par email';
        
        mail($_POST['email'], 'Reinitialisation de votre mot de passe pour food.com', "Afin de reinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost:8090/fo/user/user-reset.php?id={$user->id}&token=$reset_token");
        
        header('Location: user-login.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette adresse';
    }
}

require 'partials-user/header.php';

?>


<h1>Mot de passe oublié</h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Email</label>
        <input class="form-control" type="email" name="email" placeholder="Votre email">
    </div>
    
    <br>
    <div class="form-group">
        <input class="btn btn-secondary" type="submit" name="submit" value="CHANGER ">
    </div>
</form>

<?php require 'partials-user/footer.php'; ?>
