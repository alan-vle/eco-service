<?php


class SuperSU
{
    public function __construct(){

    }

    public function getStaff(){
        $rqt = $this->bdd->prepare('SELECT * FROM staff');
        $rqt->execute();
        $staff = $rqt->fetch();
        $rqt->closeCursor();
        return $staff;
    }

    public function insert($dataStaff){
        $insert = $this->bdd->prepare('INSERT INTO staff(name, email, password, role, date) VALUES(?, ?, ?, ?, CURDATE())');
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
        $rqt = $this->bdd->prepare('DELETE FROM staff WHERE id = ?');
        $rqt->execute(array($_SESSION['id']));
        $rqt->closeCursor();
    }

}