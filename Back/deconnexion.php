<?php
session_start();
require_once 'config.php';
$rqts = $bdd->prepare('SELECT COUNT(*) FROM shopping_cart WHERE id_customer = ?');
    $rqts->execute(array($_SESSION['id']));
    $array = $rqts->fetch();
    $rqts->closeCursor();
    if($array[0] != 0){
        echo 'update panier';
        $rqts = $bdd->prepare('UPDATE `shopping_cart` SET `cart_contents`= ? WHERE id_customer = ?');
        $rqts->execute(array(json_encode($_SESSION['cart_contents']), $_SESSION['id']));
    } 
    else {
        echo 'nouveau panier';
        $rqts = $bdd->prepare('INSERT INTO `shopping_cart`(`cart_contents`, `id_customer`) VALUES (?, ?)');
        $rqts->execute(array(json_encode($_SESSION['cart_contents']), $_SESSION['id']));
        $rqts->closeCursor();
    }
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();
// Suppression des cookies de connexion automatique
setcookie('email', '');
setcookie('password', '');
// Redirection sur la page d'accueil
//header('location: index.php');
exit;
?>