<?php
    require_once 'config.php';
    require_once 'Cart.php';
    $cart = new Cart();
    $rqt = $bdd->prepare('SELECT * FROM products');
    $rqt->execute();


    //$rqt->closeCursor();
    
    
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
    crossorigin="anonymous">
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous">


</script>

<div class="container-fluid">
    <div class="row text-center">
        <?php if (isset($_SESSION['id'])) {?>
            <a href="deconnexion.php">deconnexion</a>
            
        <?php } else { ?>
           <a href="views/signin.php">connexion</a>
            <a href="views/signup.php">inscription</a> 
        <?php } ?>
    </div>
    <?php 
    while($lstProducts = $rqt->fetch()){
        $i = 0;?>
    <div class="row text-center">
        <?php 
        while($i < 3){
        ?>
        <div class="col-md-4 mb-5" >
            <div class="card" style="width: 18rem;">
                <img src="http://fakeimg.pl/50/" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$lstProducts['products']?></h5>
                    <p class="card-text">Catégorie : <?=$lstProducts['id_category']?></p>
                    <p class="card-text"><?=$lstProducts['description']?></p>
                    <p class="card-text"><?=$lstProducts['date']?></p>
                    <p class="card-text">Quantité : <?=$lstProducts['quantity']?></p>
                    <p class="card-text"><?=$lstProducts['price']?> €</p>


                    <form action="#" method="POST" >
                        <input type="text" name="id" value="<?=$lstProducts['id']?>" hidden>
                        <input type="text" name="name" value="<?=$lstProducts['products']?>" hidden>
                        <input type="text" name="price" value="<?=$lstProducts['price']?>" hidden>
                        <label id="<?='idCard'.$lstProducts['id']?>">Quantité : <input type="number" class="qty" name="qty"  value="1" class="w-25"></label>
                        <p id="test"></p>
                        <button type="submit" name="addToCart" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                    <script>
                        let selectorQty = $("<?="#idCard".$lstProducts["id"]." > #qty"?>").attr("value");
                        let inputVal = $(".qty").val();
                        $(".qty").on("input", "change" function (){
                        alert(inputVal);
                        })
                    </script>
                    <a href="pasbon" onclick='window.location(href="controller/cartAction.php?action=addToCart&id=<?=$lstProducts["id"]?>&qty=" + (selectorQty.change() ? selectorQty : selectorQty)' class="btn btn-primary">Ajouter au panier</a>



                </div>
            </div>
        </div>
        <?php 
            $i++;
            $lstProducts = $rqt->fetch();
            if ($lstProducts == false) {
                break;
            }
        }?>
    </div>
    <?php
    }
    $rqt->closeCursor();
    var_dump($_SESSION['cart_contents']);

    ?>

</div>
