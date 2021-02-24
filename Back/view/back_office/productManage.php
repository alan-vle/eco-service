<?php
require '../../config.php';
$db = config();
$rqt = $db->prepare('SELECT * FROM categories');
$rqt->execute();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../controller/ProductController.php" method="post">
        <label>Nom du produit<input type="text" name="name"></label><br />
        <select name="category" id="">
            <?php
            while($categories = $rqt->fetch()) {
            ?>
                <option value="<?= $categories['id'];?>"><?= $categories['name'];?></option>
            <?php
           }
            ?>

        </select><br />
        <label>Description<input type="text" name="description"></label><br />
        <label>Image<input type="text" name="img"></label><br />
        <label>Prix<input type="text" name="price"></label><br />
        <label>Quantité<input type="text" name="qty"></label><br />
        <input type="submit" name="insert" value="Ajouté" />
    </form>

    <form action="../../controller/ProductController.php" method="post">
        <label>Nom du produit<input type="text" name="name"></label><br />
        <select name="category" id="">
            <?php
            while($categories = $rqt->fetch()) {
                ?>
                <option value="<?= $categories['id'];?>"><?= $categories['name'];?></option>
                <?php
            }
            ?>

        </select><br />
        <label>Description<input type="text" name="description"></label><br />
        <label>Image<input type="text" name="img"></label><br />
        <label>Prix<input type="text" name="price"></label><br />
        <label>Quantité<input type="text" name="qty"></label><br />
        <input type="submit" name="update" value="Ajouté" />
    </form>
</body>
</html>
