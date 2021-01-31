<?php

require_once '../config.php';
class Staff
{
    private $id;
    private $name;
    private $login;
    private $password;
    private $role;

    public function __construct(){
        $this->bdd = config();
    }

    public function read(){

    }
    public function insert($dataStaff){
        $insert = $this->bdd->prepare('INSERT INTO customers(name, login, password, role, date) VALUES(?, ?, ?, ?, CURDATE())');
        $insert->execute(array($dataStaff['name'], $dataStaff['login'], password_hash($dataStaff['password'], PASSWORD_DEFAULT), $dataStaff['role']));
        $insert->closeCursor();
    }

    public function update(){
        $rqt = $this->bdd->prepare('UPDATE staff SET name = :name, login = :login, password = :password, role = :role WHERE id = :id');
        $rqt->execute(array(
            'id'=>$_SESSION['id'],
            'name'=>$_POST['name'],
            'login'=>$_POST['login'],
            'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'=>$_POST['role']
        ));
        $rqt->closeCursor();
    }
    public function delete(){
        $rqt = $this->bdd->prepare('DELETE FROM staff WHERE role = ?');
        $rqt->execute(array($_SESSION['role']));
        $rqt->closeCursor();
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