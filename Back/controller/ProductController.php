<?php
session_start();
include '../model/Products.php';
if (isset($_POST['insert']))
{
    $item = array(
        "name" => $_POST['name'],
        "category" => $_POST['category'],
        "description" => $_POST['description'],
        "img" => $_POST['img'],
        "price" => $_POST['price'],
        "qty" => $_POST['qty']
    );
    $products = new Products();
    $products->insert($item);
}

if (isset($_POST['update'], $_SESSION['staff'])) {
    echo 'yes';
}

if (isset($_POST['delete'], $_SESSION['staff'])) {
    echo 'yes';
}



