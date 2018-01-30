<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class Box extends DB implements ActiveRecord, JsonSerializable{

    protected $id, $size_id, $address_id;

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
    public function getSizeId()
    {
        return $this->size_id;
    }

    /**
     * @param mixed $size_id
     */
    public function setSizeId($size_id)
    {
        $this->sizeId = $size_id;
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


    public function __construct() {
        $this->id = -1;
    }

    public function load($id)
    {

        $sql = "Select * from box where id = $id";

        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->size_id = $row['size_id'];
            $this->address_id = $row['address_id'];

            return $this;

        } else {

            return false;

        }
    }

    static public function loadAll(){

        $sql = "SELECT * FROM box";

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

            $sql = "INSERT INTO box(size_id, address_id) VALUES 
            ('$this->size_id', '$this->address_id')";

            if ($result = self::$conn->query($sql)) {
                $this->id = self::$conn->lastInsertId();
                $this->size_id = $size_id;
                $this->address_id = $address_id;

                return $this;

            } else {

                return false;

            }
        }

    }
    public function update()
    {
        $sql = "UPDATE box SET size_id='$this->size_id', address_id='$this->address_id'";
        var_dump($sql);
        if ($result = self::$conn->query($sql)) {
            return $this;

        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM box WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            $this->address_id = null;
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
