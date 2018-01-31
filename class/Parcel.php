<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';

class Parcel extends DB implements ActiveRecord, JsonSerializable{

    protected $id, $address_id, $user_id, $size_id;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getSizeId()
    {
        return $this->size_id;
    }

    /**
     * @param mixed $size_id
     */
    public function setSizeId($size_id)
    {
        $this->size_id = $size_id;
    }

    public function __construct() {
        $this->id = -1;
    }

    public function load($id)
    {

        $sql = "Select * from parcel where id = $id";

        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->address_id = $row['address_id'];
            $this->user_id = $row['user_id'];
            $this->size_id = $row['size_id'];

            return $row;

        } else {

            return false;

        }
    }

    static public function loadAll(){

        $sql = "SELECT * FROM parcel";
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

            $sql = "INSERT INTO parcel(address_id, user_id, size_id) VALUES 
            ('$this->address_id', '$this->user_id', '$this->size_id')";

            if ($result = self::$conn->query($sql)) {
                $this->id = self::$conn->lastInsertId();
                $this->address_id = $address_id;
                $this->user_id = $user_id;
                $this->size_id = $size_id;

                return $this;

            } else {

                return false;

            }
        }

    }

    public function update()
    {
        $sql = "UPDATE parcel SET address_id=$this->address_id, user_id=$this->user_id, size_id=$this->size_id WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            return $this;

        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM parcel WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            $this->address_id = null;
            $this->user_id = null;
            $this->size_id = null;
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

}