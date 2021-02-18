<?php
require '../model/Customers.php';

$customerInfo = new Customers();

if (isset($_POST['signUp'])) {
        $customer = new Customers();
        $customer->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'] ));
        header('location: ../view/signin.php');
        exit;
}

if (isset($_POST['connect'])) {
    if (!empty($_POST['password']) AND !empty($_POST['email'])) {
        require_once '../config.php';
        $bdd = config();
        if($customerInfo->connect($_POST['email'], $_POST['password'])) {
            require_once 'CartController.php';
            getSavedShoppingCart($customerInfo->getId());
            //header('location: ../view/profil.php?id='.$customer->getId());
            //exit;
        } else echo 'error: $customers->connect() == null';
    }
    else $msg = "Tous les champs doivent être complété";
}

/*if (isset($_POST['formModif']) && $_SESSION['customer']['id'] != null) {
    require_once '../config.php';
    $bdd = config();
    $testEmail = email();
    if (!empty($testEmail)) {
        header('location: ../view/profil.php?' . $testEmail);
    }

    if (isset($_POST['password']) && $_POST['password'] != $_POST['password-repeat']) {
        header('location: ../view/profil.php?errorPass');
    } elseif (empty(email())) {
        $customer = new Customers();
        $update = $customer->update($_SESSION['id']);
        if($_POST['email'] == "is in db" && $_SESSION['customer']['email'] != $_POST['email']) {
            echo 'Email utilisée';
        } else {
            $_SESSION['customer'] = $update;
            header('location: ../view/profil.php');
            exit;
        }
    }
}*/
function forgot(){
    $forgot = new Customers();
    $test = $forgot->forgot($_POST['forgot']);
    $test != null ? sendEmail($test) : 'Address mail not exist';
    function sendEmail(){

    }
}
function email(){
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
       $customerInfo->email();
        if ($_POST['email'] == $compare['email']){
            return "errorMail";
        }
        else {
            return "";
        }
    }
    else return "notValidMail";
}