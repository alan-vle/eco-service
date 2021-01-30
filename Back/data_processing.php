<?php
// INSCRIPTION
if (isset($_POST['formInscription'])) {
    require_once 'config.php';
    if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['password-repeat'])) {
        $msg = 'champs vide';
    }
    else{
        $testEmail = email($bdd);
        if (!empty($testEmail)) {
            header('location: view/signup.php?' . $testEmail);
        }
        else{
            if ($_POST['password'] == $_POST['password-repeat']) {
                $insert = $bdd->prepare('INSERT INTO customers(name, email, password, role, date) VALUES(?,?,?,?,CURDATE())');
                $insert->execute(array($_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), "membre"));
                $insert->closeCursor();
                header('location: view/signin.php');
            }
            else header('location: view/signup.php?errorPass');//$msg = "Mot de passe différent !";
        }
    }
}

// CONNEXION
if (isset($_POST['connect'])) {
    if (!empty($_POST['password']) and !empty($_POST['email'])) {
        require_once 'config.php';
        $rqt = $bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($_POST['email']));
        $customers = $rqt->fetch();
        $rqt->closeCursor();
        if ($customers['email'] == $_POST['email'] and password_verify($_POST['password'], $customers['password'])) {
            $rqt = $bdd->prepare('SELECT * FROM shopping_cart WHERE id_customer = ?');
            $rqt->execute(array($customers['id']));
            $cart_content = $rqt->fetch();
            require_once 'Cart.php';

            // if (!empty($cart_content['cart_contents']) && empty($_SESSION['cart_contents'])) {
            //     // Si cart(table) != vide ET que cart(session) == vide 
            //     $_SESSION['cart_contents'] = json_decode($cart_content['cart_contents'], true);
            //     $cart = new Cart();
            //     echo 'cart content connexion : ', '<pre>', var_dump($_SESSION['cart_contents']), '</pre>';
            // } elseif (!empty($cart_content['cart_contents']) && !empty($_SESSION['cart_contents'])) {
            //     // Si cart(table) != vide ET que cart(session) != vide 
            //     $cart = new Cart();
            //     echo 'cart content : ';
            //     echo var_dump(json_decode($cart_content['cart_contents'], true)) . '<br><br><br>';
            //     echo 'Session :';
            //     echo var_dump($_SESSION['cart_contents']);
            // } else {
            //     $cart = new Cart();
            //     echo 'table vide';
            // }
            $_SESSION['id'] = $customers['id'];
            $_SESSION['name'] = $customers['name'];
            $_SESSION['email'] = $customers['email'];

            //header("Location: view/profil.php?id=".$_SESSION['id']);
        } else {
            $msg = "Mauvais email ou mot de passe !";
        }
    } else $msg = "Tous les champs doivent être complété";
}

// PARAM COMPTE
session_start();
if (isset($_SESSION['id'], $_POST['formModif'])) {
    require_once 'config.php';
    $testEmail = email($bdd);
    if (!empty($testEmail)) {
        header('location: view/profil.php?' . $testEmail);
    }
    if (isset($_POST['password']) && $_POST['password'] != $_POST['password-repeat']) {
        header('location: view/profil.php?errorPass');
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
        header('location: profil.php');
    }
}


?>