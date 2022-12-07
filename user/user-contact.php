<?php include_once 'partials-user/header.php'; ?>
    
    <div class="container">
        
        <h1 class="text-center">Contactez-nous</h1>
        <br>
        <p class="text-center">Pour tout demande, remplissez le formaulaire de contact ci-dessous:</p>
        <br>
        <form action="" method="post" class="register">
            <label class="order-label">Nom</label>
            <input type="text" name="nom" class="input-register" required>
            <label class="order-label">Email</label>
            <input type="email" name="email" class="input-register" required>
            <label class="order-label">Sujet</label>
            <input type="text" name="sujet" class="input-register" required>
            <textarea name="message" cols="30" rows="5" placeholder="message" class="order-label" required></textarea>
            <br>
            <input type="submit" name="name" class="btn btn-primary" value="Envoyer le message" />
        </form>
        
    </div>
        
        <?php
        if(isset($_POST["message"])){ // si le formulaire est soumis
            
            $message = "Ce message vous a été envoyé via la page contact du site wowfood.fr
            Nom : " . $_POST["nom"] . "
            Email : " . $_POST["email"] . "
            Message : " . $_POST["message"];
            
            $retour = mail("nayroo13@gmail.com", $_POST["sujet"], $message, "From:wow-info@gmail.com\r\nReplay-to:" . $_POST["email"]);
            
            if($retour){
                
                $_SESSION['flash']['success'] = "<div class='col-3 success'>Votre email est envoyé.</div>";
                header("location: " . SITEURL); // 
                exit();
            }
        }
        
        ?>


<?php include 'partials-user/footer.php'; ?>

