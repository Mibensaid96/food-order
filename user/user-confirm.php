<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
    
require_once '../config/constants.php';

$sql = "SELECT * FROM tbl_users WHERE id = $user_id";
$res = mysqli_query($conn, $sql);
session_start();

if($res == true) { // Si la req est executee
    
    $user = mysqli_fetch_assoc($res);         
    
    if($user && $user['confirmation_token'] == $token) { // si l'user existe et le token est correct
                                    
        $sql2 = "UPDATE tbl_users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = $user_id";
        $res2 = mysqli_query($conn, $sql2);
        
        $_SESSION['flash']['success'] = "votre compte a bien été validé. ";
        $_SESSION['auth'] = $user;
	    header('location: user-account.php');
    } else {
        $_SESSION['flash']['error'] = "Ce token n'est plus valide";
        header('location: user-login.php');
    }
}

?>