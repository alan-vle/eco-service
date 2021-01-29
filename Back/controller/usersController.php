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
            header('location: ../views/signup.php?' . $testEmail);
        }
        else{
            if ($_POST['password'] == $_POST['password-repeat']) {
                $customers = new Customers();
                $customers->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'] ));
                header('location: ../views/signin.php');
            }
            else header('location: ../views/signup.php?errorPass');//$msg = "Mot de passe différent !";
        }
    }
}

if (isset($_POST['connect'])) {
    echo '1 <br>';
    if (!empty($_POST['password']) AND !empty($_POST['email'])) {
        echo '2 <br>';
        require_once '../config.php';
        $bdd = config();
        echo '3 <br>';
        $rqt = $bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($_POST['email']));
        $customers = $rqt->fetch();
        $rqt->closeCursor();
        $customers = new Customers();
        echo '4 <br>';
        $customers->connect($_POST['email'], $_POST['password']);
        if($customerInfo != null) {
            echo '<br> 4.5 <br>';
            require_once 'cartController.php';
            echo '<br> 5 <br>';
            getSavedShoppingCart($customers->getId());
            $_SESSION['id'] = $customers->getId();
            $_SESSION['name'] = $customers->getName();
            $_SESSION['email'] = $customers->setEmail();
            $customerInfo = $customers;
            echo '<br> GG <br>';


            //header("Location: ../index.php");
            //header("Location: views/profil.php?id=".$_SESSION['id']);
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