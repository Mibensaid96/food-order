<?php

function debug($variable) {
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length) { // generer un str d'une certaine taille et le retourner
    $alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"; // 60 carct
    // repeter les caract 60 fois, les melanger et Retourne un segment de chaîne de commencant de 0 de taille $length
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length); 
}

function logged_only() {
    if(session_status() == PHP_SESSION_NONE){ // s'il n'y a pas de session
        session_start(); // en demarrer une
    }
    if(!isset($_SESSION['auth'])){ // si l'utilisateur n'est pas connecter
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder a cette page";
        header('Location: user-login.php');
        exit();
    }
}

function reconnect_cookie() { // connecte automatiquement l'utilisateur via les cookies
    if(session_status() == PHP_SESSION_NONE){
        session_start(); 
    }
    if(isset($_COOKIE['remember'])){
        require '../config/constants.php';
        
        
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token); // separer le token a partir de '=='
        $user_id = $parts[0];
        $req = $conn->prepare('SELECT * FROM tbl_users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();

        if($user) {
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ceTte#@valeur');
            if($expected == $remember_token) { // si expected est identique au token stocker dans le cookie
                // fais une reconnexion automatique
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 14);
            }
        } else { // si le user ne correspond pas
            setcookie('remember', null, -1); // detruis le cookie
        }
    }
}

function calculateTotalCart() {

    $total_price = 0;
    $total_quantity = 0;
    
    foreach($_SESSION['order'] as $id=>$product) {

        $product = $_SESSION['order'][$id];
        
        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total_price = $total_price + ($price * $quantity);
        $total_quantity = $total_quantity + $quantity;

    }

    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;

}

function calculateTotalItem($product_qty, $product_price) {
    return $subtotal = $product_qty * $product_price;

}