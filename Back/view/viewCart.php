<?php
session_start();
require_once '../config.php';
require_once '../Cart.php';
$cart = new Cart();
$costNoShip = $cart->total();
$cartContents = $cart->contents();
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
      crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous">></script>
<script>
function updateCartItem(obj,id){
    $.get("../controller/CartController.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
        if(data == 'ok'){
            location.reload();
        }else{
            alert('Cart update failed, please try again.');
        }
    });
}
</script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th class="text-center">Prix</th>
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($cartContents as $item) {
                    ?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#"><?=$item['name']?></a></h4>
                                    <h5 class="media-heading"> par <a href="#">Eco-Service</a></h5>
                                    <!-- <span>Status: </span><span class="text-success"><strong>In Stock</strong></span> -->
                                </div>
                            </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            <input type="number" class="form-control" onchange="updateCartItem(this, '<?= $item["rowid"]?>')" value="<?=$item['qty']?>">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?=$item['price']?> €</strong></td>
                        <td class="col-sm-1 col-md-1 text-center">
                            <strong>
                                <?=$item['subtotal']?> €
                            </strong>
                        </td>
                        <td class="col-sm-1 col-md-1">
                            <button type="button" name="removeCartItem" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')?window.location.href='../controller/CartController.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Sous-total</h5></td>
                    <td class="text-right"><h5><strong><?=$costNoShip?> €</strong></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Frais de port</h5></td>
                    <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h3>Total</h3></td>
                    <td class="text-right"><h3><strong><?=$costNoShip + 6.94?> €</strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <button type="button" class="btn btn-secondary"> Articles </button></td>
                    <td>
                        <button type="button" class="btn btn-success"> Paiement </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
