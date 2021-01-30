<?php
require '../model/Customers.php';

$customerInfo = new Customers();

if (isset($_POST['formInscription'])) {
    require_once '../config.php';
    $bdd = config();
    if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['password-repeat'])) {
        $msg = 'champs vide';
    }
    else{
        $testEmail = email($bdd);
        if (!empty($testEmail)) {
            header('location: ../view/signup.php?' . $testEmail);
        }
        else{
            if ($_POST['password'] == $_POST['password-repeat']) {
                $customers = new Customers();
                $customers->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'] ));
                header('location: ../view/signin.php');
            }
            else header('location: ../view/signup.php?errorPass');//$msg = "Mot de passe différent !";
        }
    }
}

if (isset($_POST['connect'])) {
    if (!empty($_POST['password']) AND !empty($_POST['email'])) {
        require_once '../config.php';
        $bdd = config();
        $rqt = $bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($_POST['email']));
        $customers = $rqt->fetch();
        $rqt->closeCursor();
        $customers = new Customers();
        $customers->connect($_POST['email'], $_POST['password']);
        if($customerInfo != null) {
            require_once 'CartController.php';
            getSavedShoppingCart($customers->getId());
            $_SESSION['id'] = $customers->getId();
            $_SESSION['name'] = $customers->getName();
            $_SESSION['email'] = $customers->getEmail();
            $customerInfo = $customers;

            //header("Location: ../index.php");
            header("Location: ../view/profil.php?id=".$_SESSION['id']);
        }
        else {
            echo 'error: $customers->connect() == null';
        }
    }
    else $msg = "Tous les champs doivent être complété";
}


function email($p_bdd): string
{
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $rqt = $p_bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($_POST['email']));
        $compare = $rqt->fetch();
        $rqt->closeCursor();
        if ($_POST['email'] == $compare['email']){
            return "errorMail";
        }
        else {
            return "";
        }
    }
    else return "notValidMail";
}