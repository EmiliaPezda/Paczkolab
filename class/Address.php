<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class Address extends DB implements ActiveRecord, JsonSerializable{

    protected $id;
    protected $city;
    protected $code;
    protected $street;
    protected $flat;

    public function __construct( ) {
        $this->id = -1;
    }

    public function getId(){
        return $this->id;
    }


    public function setCity($city){
        $this->city = $city;
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function setStreet($street){
        $this->street = $street;
    }

    public function setFlat($flat){
        $this->flat = $flat;
    }

    public function getCity(){
        return $this->city;
    }

    public function getCode(){
        return  $this->code;
    }

    public function getStreet(){
        return $this->street;
    }

    public function getFlat(){
        return $this->flat;
    }

    public function load($address_id) {

        $sql = "SELECT * FROM address WHERE id = $address_id";

        if ($result = self::$conn->query($sql)) {

            $row   = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->city = $row['city'];
            $this->code = $row['code'];
            $this->street = $row['street'];
            $this->flat = $row['flat'];

            return $row;

        } else {

            return false;

        }
    }


    public function save()
    {
        if ($this->id == -1) {

            $sql = "INSERT INTO `address` (`city`, `code`, `street`, `flat`) VALUES ('$this->city', '$this->code', '$this->street', '$this->flat')";

            if ($result = self::$conn->query($sql)) {
                $row   = $result->fetch(PDO::FETCH_ASSOC);

                $this->id = self::$conn->lastInsertId();
                $this->city = $row['city'];
                $this->code = $row['code'];
                $this->street = $row['street'];
                $this->flat = $row['flat'];

                return $this;

            } else {
                return false;

            }
        }
    }

    public function update()
    {
        $sql = "UPDATE `address` SET `city`='$this->city', `code`='$this->code', `street`='$this->street', `flat`='$this->flat'  WHERE `id`=$this->id ";
        var_dump($sql);
        if ($result = self::$conn->query($sql)) {
            return $this;

        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM `address` WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            $this->city = null;
            $this->code = null;
            $this->street = null;
            $this->flat = null;
            $this->id = -1;

            return true;

        } else {

            return false;

        }
    }

    function jsonSerialize()
    {
        return $this->array;
    }


    public static function loadAll() {
        $sql = "SELECT * FROM address";

        if ($result = Self::$conn->query($sql)) {

            foreach ($result as $key => $value) {
                $row[$key] = $value;
            }
            return $row;
        }else {
            return false;
        }
    }

}