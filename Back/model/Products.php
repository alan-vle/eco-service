<?php

require_once '../config.php';

class Products
{
    private $id;
    private $db;
    private $products;
    private $idCategory;
    private $description;
    private $img;
    private $price;
    private $quantity;
    private $date;

    public function __construct()
    {
        $this->db = config();
    }

    public function insert($item)
    {
        $insert = $this->db->prepare('INSERT INTO products(name, id_category, description, img, price, quantity, date) VALUES(?, ?, ?, ?, ?, ?, NOW())');
        $insert->execute(array($item['name'], $item['category'], $item['description'], $item['img'], $item['price'], $item['qty']));
        $insert->closeCursor();
    }
/*
    public function update($idProduct)
    {
        $rqt = $this->db->prepare('UPDATE products SET name = :product, id_category = :id_category, description = :description, img = :img, price = :price, quantity = :quantity, date = NOW() WHERE id = :id');
        $rqt->execute(array(
            'id' => $idProduct['id'],
            'product' => $idProduct['product'],
            'id_category' => $idProduct['id_category'],
            'description' => $idProduct['description'],
            'img' => $idProduct['img'],
            'price' => $idProduct['price'],
            'quantity' => $idProduct['quantity'],
        ));
        $rqt->closeCursor();
    }

    public function delete($idProduct)
    {
        $rqt = $this->db->prepare('DELETE FROM products WHERE id = ?');
        $rqt->execute(array($idProduct));
        $rqt->closeCursor();
    }

    public function get()
    {
        $rqt = $this->db->prepare('SELECT * FROM products');
        $rqt->execute();
        $rqt->closeCursor();
    }

    public function setCategories()
    {
        
    }*/

    public function getCategories()
    {
        $rqt = $this->db->prepare('SELECT * FROM categories');
        $rqt->execute();
        $categories = $rqt->fetch();
        $rqt->closeCursor();
        return $categories;
    }


    /**
     * @return PDO
     */
    public function getBdd(): PDO
    {
        return $this->bdd;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * @param mixed $idCategory
     */
    public function setIdCategory($idCategory): void
    {
        $this->idCategory = $idCategory;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }
}