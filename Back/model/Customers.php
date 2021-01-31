<?php

require_once '../config.php';

class Customers{
    private $bdd;
    private $id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $address2;
    private $town;
    private $zipCode;
    private $country;
    private $phone;
    private $idCompany;

    public function __construct(){
        $this->bdd = config();
    }

    public function insert($dataCustomers)
    {
        $insert = $this->bdd->prepare('INSERT INTO customers(name, email, password, role, date) VALUES(?, ?, ?, ?, CURDATE())');
        $insert->execute(array($dataCustomers['name'], $dataCustomers['email'], password_hash($dataCustomers['password'], PASSWORD_DEFAULT), "membre"));
        $insert->closeCursor();
    }

    public function connect($email, $password)
    {
        $rqt = $this->bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($email));
        $customer = $rqt->fetch();
        $rqt->closeCursor();

        if ($customer['email'] == $email && password_verify($password, $customer['password']))
        {
            //echo 'User exist <br>';

            $this->id = $customer['id'];
            $this->name = $customer['name'];
            $this->email = $customer['email'];
            $this->address = $customer['address'];
            $this->address2 = $customer['address2'];
            $this->town = $customer['town'];
            $this->zipCode = $customer['zip_code'];
            $this->country = $customer['country'];
            $this->phone = $customer['phone'];
            $this->idCompany = $customer['id_company'];
            $_SESSION['customer'] = session();
        }
    }

    public function update($id)
    {
        $rqt = $this->bdd = prepare('SELECT password FROM customers WHERE id = ?');
        $rqt->execute($_SESSION['id']);
        $password = $rqt->fetch();
        $rqt->closeCursor();
        if(password_verify($_POST['password'], $password['password'])){
            $rqt = $this->bdd->prepare('UPDATE customers SET name = :name, email = :email, password= :password, phone= :phone WHERE id = :id');
            $rqt->execute(array(
                'id'=>$_SESSION['id'],
                'name'=>$_POST['name'],
                'email'=>$_POST['email'],
                'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone'=>$_POST['phone']
            ));
            $rqt->closeCursor();
            unset($_SESSION['customer']);
            return session();
        } else {
        return $error = 'Mot de passe actuelle incorrect';
        }
    }

    function delete()
    {
        $rqt = $this->bdd->prepare('DELETE FROM customers WHERE id = ?');
        $rqt->execute(array($_SESSION['id']));
        $rqt->closeCursor();
        unset($_SESSION['customer']);
    }
    public function forgot($email, $password = null) :string
    {
        $rqt = $this->bdd->prepare('SELECT * FROM customers WHERE email = ?');
        $rqt->execute(array($email));
        $forgot = $rqt->fetch();
        $rqt->closeCursor();
        if($forgot == false){
            if($password != null){
                return array('email' => $forgot['email'], 'password' => $forgot['password']);
            }
            else {
                return $forgot['email'];
            }
        }
        else return define(null);
    }
    function read()
    {

    }

    function session() :array
    {
        return array('id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress(),
            'address2' => $this->getAddress2(),
            'town' => $this->getTown(),
            'zipCode' => $this->getZipCode(),
            'country' => $this->getCountry(),
            'phone' => $this->getPhone(),
            'idCompany' => $this->getIdCompany()
        );
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param mixed $town
     */
    public function setTown($town): void
    {
        $this->town = $town;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getIdCompany()
    {
        return $this->idCompany;
    }

    /**
     * @param mixed $idCompany
     */
    public function setIdCompany($idCompany): void
    {
        $this->idCompany = $idCompany;
    }
}