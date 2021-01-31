<?php
// Initialize shopping cart class
require_once '../Cart.php';
$cart = new Cart;

// Include the database config file
require_once '../config.php';

// Default redirect page
$redirectLoc = '../index.php';

// Process request based on the specified action
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $bdd = config();
    //*********ADD************
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {

        // Get product details
        $query = $bdd->prepare("SELECT * FROM products WHERE id = ?");
        $query->execute(array($_REQUEST['id']));
        $get = $query->fetch();
        $itemData = array(
            'id' => $get['id'],
            'name' => $get['products'],
            'price' => $get['price'],
            'qty' => (int)$_REQUEST['qty']
        );

        // Insert item to cart
        echo $cart->insert($itemData) ? 'ok' : 'err';
        header("location: ../index.php#idCard" . htmlspecialchars($_REQUEST['id']));
    } //*********UPDATE************
    elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        // Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);

        // Return status
        echo $updateItem ? 'ok' : 'err';
        die;

        //*********REMOVE************
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        echo 'in removeCartItem';
        // Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['id']);

        // Redirect to cart page
        $redirectLoc = '../view/viewCart.php';
    }
}

function getSavedShoppingCart($customerId)
{
    echo 'debut getSavedShoppingCart';
    $bdd = config();
    $rqt = $bdd->prepare('SELECT * FROM shopping_cart WHERE id_customer = ?');
    $rqt->execute(array($customerId));

    $cart_content = $rqt->fetch();
    require_once '../Cart.php';

    if (!empty($cart_content['cart_contents']) && empty($_SESSION['cart_contents'])) {
        // Si cart(table) != vide ET que cart(session) == vide
        $_SESSION['cart_contents'] = json_decode($cart_content['cart_contents'], true);
        $cart = new Cart();
        echo 'cart content connexion : ', '<pre>', var_dump($_SESSION['cart_contents']), '</pre>';
    } elseif (!empty($cart_content['cart_contents']) && !empty($_SESSION['cart_contents'])) {
        // Si cart(table) != vide ET que cart(session) != vide
        $cart = new Cart();
        echo 'cart content : ';
        echo var_dump(json_decode($cart_content['cart_contents'], true)) . '<br><br><br>';
        echo 'Session :';
        echo var_dump($_SESSION['cart_contents']);
    } else {
        $cart = new Cart();
        echo 'table vide';
    }
}

// Redirect to the specific page
header("Location: $redirectLoc");
exit();
