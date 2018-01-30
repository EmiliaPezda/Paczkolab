<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class User extends DB implements ActiveRecord, JsonSerializable{

    protected $id,$name, $surname, $address_id, $credits, $pass;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @param mixed $address_id
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }

    /**
     * @return mixed
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param mixed $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    /**
     * @param mixed $password
     */
    public function setPass($pass)
    {
        $options = [
            'cost' => 11,
            'salt' => random_bytes(22),
        ];
        $this->pass = password_hash($pass, PASSWORD_BCRYPT, $options);
    }

    public function __construct() {
        $this->id = -1;
    }


    function jsonSerialize()
    {
        return $this->array;
    }

    public function load($id)
    {

        $sql = "Select * from user where id = $id";

        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->credits = $row['credits'];
            $this->pass = $row['pass'];
            $this->address_id = $row['address_id'];

            return $row;

        } else {

            return false;

        }
    }

    static public function loadAll(){

        $sql = "SELECT * FROM user";

        if ($result = self::$conn->query($sql)) {
            foreach ($result as $key => $value) {
                $row[$key] = $value;
            }
            return $row;

        }else {
            return false;
        }
    }

    public function save()
    {
        if ($this->id == -1) {

            $sql = "INSERT INTO `user` (address_id, name, surname, credits, pass) VALUES 
            ('$this->address_id', '$this->name', '$this->surname', $this->credits, '$this->pass')";

            if ($result = self::$conn->query($sql)) {
                $this->id = self::$conn->lastInsertId();
                $this->name = $name;
                $this->surname = $surname;
                $this->credits = $credits;
                $this->pass = $pass;

                return $this;

            } else {

                return false;

            }
        }

    }
    public function update()
    {
        $sql = "UPDATE user SET name='$this->name', surname='$this->surname', credits='$this->credits' WHERE id=$this->id";
        var_dump($sql);
        if ($result = self::$conn->query($sql)) {
            return $this;

        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM user WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            $this->address_id = null;
            $this->name = null;
            $this->surname = null;
            $this->credits = null;
            $this->pass = null;
            $this->id = -1;

            return true;

        } else {

            return false;

        }
    }


}
