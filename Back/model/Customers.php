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
        $insert = $this->bdd->prepare('INSERT INTO customers(name, email, password, role, date) VALUES(?,?,?,?,CURDATE())');
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
            $this->setName($customer['name']);
            $this->setEmail($customer['email']);
            $this->setAddress($customer['address']);
            $this->setAddress2($customer['address2']);
            $this->setTown($customer['town']);
            $this->setZipCode($customer['zip_code']);
            $this->setCountry($customer['country']);
            $this->setPhone($customer['phone']);
            $this->setIdCompany($customer['id_company']);
        }
    }

    public function update()
    {

    }

    function delete()
    {

    }

    function read()
    {

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