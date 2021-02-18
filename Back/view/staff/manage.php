<?php
session_start();
require_once '../../Staff.php';
$staff = new Staff();
if($_SESSION['role'] == "order"){
    $order = $staff->getOrder();
}
if($_SESSION['role'] == "service"){
    $service = $staff->getService();
}
if($_SESSION['role'] == "SuperSU"){
    $service = $staff->getService();
}
?>


<ul>
    <li><?= $staff['name'];?></li>
    <li><?= $staff['role'];?></li>
    <li><?= $staff[''];?></li>
</ul><br /><br />
<?php
if(isset($_SESSION['role'])){

if($_SESSION['role'] = 'manageService') {
?>
<ul>Service
    <li><?= $service['name'];?></li>
    <li><?= $service['description'];?></li>
    <li><?= $service[''];?></li>
</ul>
    <?php
        }
        if ($_SESSION['role'] = 'manageOrder') {
    ?>
    <br /><br />
<ul>Commandes
    <li><?= $order['id'];?></li>
    <li><?= $order['products'];?></li>
    <li><?= $order[''];?></li>
</ul>
<?php
    }
}

?>
