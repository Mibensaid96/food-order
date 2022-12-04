<?php 
require_once '../config/functions.php';
reconnect_cookie();

if(isset($_SESSION['auth'])){
    header('Location: user-account.php');
    exit();
}

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require '../config/constants.php';
    debug("Login successfully");
    
    $username = $_POST['username'];
    
    $sql = $conn->prepare("SELECT * FROM tbl_users WHERE (username = ? OR email = ?) "); // Si c'est le bon identifiant et que le compte a deja ete confirmer (mail de confirmation)  AND confirmed_at IS NOT NULL
    
    $sql->bind_param("ss",$username, $username);
    $sql->execute();
    
    $res = $sql->get_result();
    $user = mysqli_fetch_assoc($res);
//    debug($user);
    
    if(password_verify($_POST['password'], $user['password'])){ // si les pwd deja hachés sont identiques, on connecte l'user
        session_start();
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous etes maintenant connecté';
        
        if(isset($_POST['remember'])){ // si le user a cocher se souvenir de moi
            $remember_token = str_random(250);
            $userId = $user['id'];
            
            $sql2 = "UPDATE tbl_users SET remember_token = '$remember_token' WHERE id =  $userId"; // utiliser prepare()
            $res2 = mysqli_query($conn, $sql2);
            
            setcookie('remember', $user['id'] . '==' . $remember_token . sha1($user['id'] . 'ceTte#@valeur'), time() + 60*60*24*14); // cookie active pour 14 jours
        }
        
        if (isset($_SESSION['order']) && !empty($_SESSION['order'])){
            header("Location: user-checkout.php");
            exit(); 
        } else {
            header('Location: user-account.php');
            exit();
        }
        /*
        $_SESSION['flash']['success'] = 'HTTP_REFERER :'.$_SERVER['HTTP_REFERER'];
        
        header("Location:".$_SERVER['HTTP_REFERER']);
        exit(); 
        */
    } else {
        $_SESSION['flash']['error'] = "Identifiant ou mot de passe incorrect \n";
    }
}
//debug("pas ok");

require_once 'partials-user/header.php';
?>

<div class="container">

    <h1  class="text-center">Se connecter</h1>
    <br>

    <?php if(!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <p>Vous n'avez pas rempli le formulaire correctement</p>
                <?php foreach($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="register">

        <div class="form-group">
            <label for="">Pseudo ou email</label>
            <input type="text" name="username" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Mot de passe <a href="<?php echo SITEURL; ?>user/user-forget.php">(J'ai oublié mon mot de passe)</a></label>
            <input type="password" name="password" class="form-control" />
        </div>

        <div class="form-group">
            <label >
                <input type="checkbox" name="remember" value="1" /> Se souvenir de moi
            </label>
            <a href="<?php echo SITEURL; ?>user/user-register.php">M'inscrire</a>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Se connecter</button>

    </form>
    
</div>

<?php require 'partials-user/footer.php'; ?>