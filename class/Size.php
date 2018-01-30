<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class Size extends DB implements ActiveRecord, JsonSerializable{

    protected $id, $size, $price;

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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

     /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $credits
     */
    public function setPrice($price)
    {
        $this->price = $price;
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

        $sql = "Select * from size where id = $id";

        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->size = $row['size'];
            $this->price = $row['price'];

            return $row;

        } else {

            return false;

        }
    }

    static public function loadAll(){

        $sql = "SELECT * FROM size";

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

            $sql = "INSERT INTO `size`(`size`, `price`) VALUES ('$this->size', $this->price)";

            if ($result = self::$conn->query($sql)) {
                $row   = $result->fetch(PDO::FETCH_ASSOC);

                $this->id = self::$conn->lastInsertId();
                $this->size = $row['size'];
                $this->price = $row['price'];
                return $this;

            } else {
                return false;

            }
        }

    }

    public function update()
    {
        $sql = "UPDATE `size` SET `size`='$this->size', `price`=$this->price WHERE `id`=$this->id ";

        if ($result = self::$conn->query($sql)) {
            return $this;

        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM size WHERE id=$this->id";

        if ($result = self::$conn->query($sql)) {
            $this->size = null;
            $this->price = null;
            $this->id = -1;

            return true;

        } else {

            return false;

        }
    }

}
