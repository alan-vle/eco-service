<?php
session_start();
require '../model/Staff.php';

$staff = new Staff();
if(isset($_POST['inscript'])){
    if (empty($_POST['name']) OR empty($_POST['login']) OR empty($_POST['password']) OR empty($_POST['password-repeat'])) {
        $msg = 'champs vide';
    }
    else{
        if ($_POST['password'] == $_POST['password-repeat']) {
            $staff->insert(array("name" => $_POST['name'], "login" => $_POST['login'], "password" => $_POST['password'] ));
            header('location: ../view/staff/signIn.php');
            exit;
        }
        else header('location: ../view/staff/signup.php?errorPass');//$msg = "Mot de passe différent !";
    }
}
if (isset($_POST['connect'])) {
    if (!empty($_POST['password']) and !empty($_POST['login'])) {
        $staff->connect($_POST['login'], $_POST['password']);
        echo $staff->getName();
        $_SESSION['staffName'] = $staff->getName();
        $_SESSION['staffLogin'] = $staff->getLogin();
        $_SESSION['staffRole'] = $staff->getRole();
        $_SESSION['info'] = $staff;
        //var_dump($_SESSION['info']);
        if($_SESSION['staffRole'] == 'SuperSU'){
            $_SESSION['info'] = $staff;
            echo 'SuperSU :' . '<br />';
            echo var_dump($_SESSION['info']);
        } else {
            $_SESSION['info'] = $staff;
           // echo 'Staff : ' . '<br />';
           // echo var_dump($_SESSION['info']);
           // header('location: ../view/manage.php');
        }
    } else $msg = "Tous les champs doivent être complété";
}

if (isset($_POST['formModif']) && $_SESSION['customer']['id'] != null) {
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
        if ($_POST['email'] == "is in db" && $_SESSION['customer']['email'] != $_POST['email']) {
            echo 'Email utilisée';
        } else {
            $_SESSION['customer'] = $update;
            header('location: ../view/profil.php');
            exit;
        }
    }
}
function forgot()
{
    $forgot = new Customers();
    $test = $forgot->forgot($_POST['forgot']);
    $test != null ? sendEmail($test) : 'Address mail not exist';
    function sendEmail()
    {


    }
}

{
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        require_once '../config.php';
        $bdd = config();
        $rqt = $bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($_POST['email']));
        $compare = $rqt->fetch();
        $rqt->closeCursor();
        if ($_POST['email'] == $compare['email']) {
            return "errorMail";
        } else {
            return "";
        }
    } else return "notValidMail";
}