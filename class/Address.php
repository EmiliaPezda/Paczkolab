<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class Address extends DB implements ActiveRecord, JsonSerializable{

    private $id;
    private $city;
    private $code;
    private $street;
    private $flat;

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

        $sql = "SELECT * FROM address JOIN user ON
                address.id = user.address_id WHERE address.id = $address_id";

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
        // TODO: Implement save() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
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