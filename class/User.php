<?php

require_once 'interfaces/ActiveRecord.php';
require_once 'abstract/DB.php';



class User extends DB implements ActiveRecord, JsonSerializable{

    protected $id,$name, $surname, $address_id, $credits, $password;

    public function __construct() {
        $this->id = -1;
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
    private function setId($id)
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
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    private function setPassword($password)
    {
        $options = [
            'cost' => 11,
            'salt' => random_bytes(22),
        ];
        $this->password = password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function saveToDB()
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO user(address_id, name, surname, credits, pass) VALUES (:address_id, :name, :surname, :credits, :pass)";
            $prepare = $conn->prepare($sql);

            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'address_id'     => $this->address_id,
                    'name'     => $this->name,
                    'surname'     => $this->surname,
                    'credits'        => $this->credits,
                    'pass' => $this->pass,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $conn->lastInsertId();
            return (bool)$result;
        }
        return false;
    }

}
