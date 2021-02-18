<?php


class Staff
{
    private PDO $db;
    private $id;
    private $name;
    private $login;
    private $password;
    private $role;

    public function __construct(){
        require_once '../config.php';
        $this->db = config();
    }

    public function read(){

    }
    public function insert($dataStaff){
        $insert = $this->db->prepare('INSERT INTO staff(name, login, password, date) VALUES(?, ?, ?, CURDATE())');
        $insert->execute(array($dataStaff['name'], $dataStaff['login'], password_hash($dataStaff['password'], PASSWORD_BCRYPT)));
        $insert->closeCursor();
    }
    public function connect($login, $password){
        $rqt = $this->db->prepare('SELECT * FROM staff WHERE login = ?');
        $rqt->execute(array($login));
        $st = $rqt->fetch();
        if($login == $st['login'] && password_verify($password, $st['password'])) {
           $this->setName($st['name']);
           $this->setLogin($st['login']);
           $this->setRole($st['role']);
           $rqt->closeCursor();
        }
    }
    public function getOrder(){
        $rqt = $this->bdd->prepare('SELECT * FROM orders');
        $rqt->execute();
        $orders = $rqt->fetch();
        $rqt->closeCursor();
        return $orders;
    }

    public function getService(){
        $rqt = $this->bdd->prepare('SELECT * FROM products');
        $rqt->execute();
        $service = $rqt->fetch();
        $rqt->closeCursor();
        return $service;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }
}