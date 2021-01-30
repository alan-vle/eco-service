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
                $customer = new Customers();
                $customer->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'] ));
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
        $customer = $rqt->fetch();
        $rqt->closeCursor();
        $customer = new Customers();
        $customer->connect($_POST['email'], $_POST['password']);
        if($customer != null) {
            require_once 'CartController.php';
            getSavedShoppingCart($customer->getId());
            echo 'id = ' .$customer->getId();
            //$_SESSION['name'] = $customers->getName();
            //$_SESSION['email'] = $customers->getEmail();
            //session_start();
            $_SESSION['customer'] = (array)$customer;
            var_dump($_SESSION['customer']);
            //header("Location: ../index.php");
            //header("Location: ../view/profil.php?id=".$_SESSION['customer']);
        }
        else {
            echo 'error: $customers->connect() == null';
        }
    }
    else $msg = "Tous les champs doivent être complété";
}

if (isset($_POST['formModif']) && $_SESSION['customer']->getId() != null) {
    require_once '../config.php';
    $bdd = config();
    $testEmail = email($bdd);
    if (!empty($testEmail)) {
        header('location: ../view/profil.php?' . $testEmail);
    }

    if (isset($_POST['password']) && $_POST['password'] != $_POST['password-repeat']) {
        header('location: ../view/profil.php?errorPass');
    }
    elseif(empty(email($bdd))){
        $rqt = $bdd->prepare('UPDATE customers SET name = :name , email = :email, password= :password, phone= :phone WHERE id = :id');
        $rqt->execute(array(
            'id'=>$_SESSION['id'],
            'name'=>$_POST['name'],
            'email'=>$_POST['email'],
            'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
            'phone'=>$_POST['phone']
        ));
        $rqt->closeCursor();
        unset($_SESSION['name'], $_SESSION['email']);
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        header('location: ../view/profil.php');
    }
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