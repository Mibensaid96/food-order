<?php /*Modification de mot de passe*/
    if(isset($_GET['id']) && isset($_GET['token'])) {
        
        require '../config/constants.php';
//        require '../config/functions.php';
        $sql = $conn->prepare('SELECT * FROM tbl_users WHERE id = ? AND reset_token = ? AND reset_token IS NOT NULL AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE) '); // DATE_SUB() : reset_at doit etre > ala date du jour qu'on retranche 30min (aucours des 30 dernieres min) 
        $sql->execute([$_GET['id'], $_GET['token']]);
        
        $res = $sql->get_result();
        $user = mysqli_fetch_assoc($res);
//        debug($user);
        
        if($user){
            if(!empty($_POST)){
                if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                    
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    
                    $sql2 = $conn->prepare('UPDATE tbl_users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                    session_start();
                    $_SESSION['flash']['success'] = "Votre mot de passe a bien ete modifié";
                    $_SESSION['auth'] = $user;
                    header('Location: user-account.php');
                    exit();
                }
            }
        } else {
            session_start();
            $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
            header('Location: user-login.php');
            exit();
        }
    } else {
        header('Location: user-login.php');
        exit();
    }

require 'partials-user/header.php'; 

?>

<h1>Reinitialiser mon mot de passe</h1>
    

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <p>Vous n'avez pas rempli le formulaire correctement</p>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="POST">
    
    <div class="form-group">
        <label for="">Mot de passe </label>
        <input type="password" name="password" class="form-control" />
    </div>
    
    <div class="form-group">
        <label for="">Confirmation du mot de passe </label>
        <input type="password" name="password_confirm" class="form-control" />
    </div>
    
    <br>
    <button type="submit" class="btn btn-primary">Reinitialiser mon mot de passe</button>
    
</form>


<?php require 'partials-user/footer.php'; ?>