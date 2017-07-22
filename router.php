<?php

//ładowanie klas
require ('load.php');

//zmienne uniwersalne
$class = null;
$returnUrl = null;

//Parsowanie zapytania
$request = $_SERVER['REQUEST_URI'];
$arrayRequest = explode('/', $request);

if($arrayRequest[3]){
    $requestClass = $arrayRequest[3];

}else {
    die("Niepoprawny adres");
}

if(isset($arrayRequest[4])){
    $requestParameter = $arrayRequest[4];
}else {
    $requestParameter = null;
}


//wyświetlenie stron
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $array = [];

    if($requestParameter == null){
        //wyświetlenie strony

        if($requestClass == 'user'){
            $array = User::loadAll();
            
        }else if($requestClass == 'box'){
            $array = Box::loadAll();
            
        }else if($requestClass == 'size'){
            $array = Size::loadAll();
            
        }else if($requestClass == 'address'){
            $array = Address::loadAll();
            
        }else if($requestClass == 'parcel'){
            $array = Parcel::loadAll();
        }
        
        
    } else {
        //pobranie konkretnego id i zwrócenie w formie json
        
        
        if($requestClass == 'user'){
            $user = new User();
            $array = $user->load($requestParameter);
            
        }else if($requestClass == 'box'){
            $user = new Box();
            $array = $user->load($requestParameter);
            
        }else if($requestClass == 'size'){
            $user = new Size();
            $array = $user->load($requestParameter);
            
        }else if($requestClass == 'address'){
            $user = new Address();
            $array = $user->load($requestParameter);
            
        }else if($requestClass == 'parcel'){
            $user = new Parcel();
            $array = $user->load($requestParameter);
        }
        
        
    }
    
    echo json_encode($array);
    return;
}

//utworzenie klasy i przekazanie parametrów
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($requestClass) {
        case 'user':
            $address_id =   $_POST['address_id'];
            $name =         $_POST['name'];
            $surname=       $_POST['surname'];
            $credits =      $_POST['credits'];
            $pass =         $_POST['pass'];
            
            $class = new User();
            $class->setAddressId($address_id);
            $class->setName($name);
            $class->setSurname($surname);
            $class->setCredits($credits);
            $class->setPass($pass);
            break;
        
        case 'box':
            $address_id = $_POST['address_id'];
            $size_id = $_POST['size_id'];
            $class = new Box();
            $class->setAddressId($address_id);
            $class->setSizeId($size_id);
            break;
        
        case 'size':
            $size = $_POST['size'];
            $price = $_POST['price'];
            $class = new Size();
            $class->setSize($size);
            $class->setPrice($price);
            break;
        
        case 'address':
            $city   = $_POST['city'];
            $code   = $_POST['code'];
            $street = $_POST['street'];
            $flat   = $_POST['flat'];
            $class = new Address();
            
            $class->setCity($city);
            $class->setCode($code);
            $class->setStreet($street);
            $class->setFlat($flat);
            break;
        
        case 'parcel':
            $address_id = $_POST['address_id'];
            $size_id = $_POST['size_id'];
            $user_id = $_POST['user_id'];
            $class = new Parcel();
            $class->setAddressId($address_id);
            $class->setSizeId($size_id);
            $class->setUserId($user_id);
            break;
        
        default:
            break;
    }
    
    if( $class->saveToDB() == false ) {
        return false;
    }else {
        return true;
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'];

    switch ($requestClass) {
        case 'user':
            $address_id =   $put_vars['address_id'];
            $name =         $put_vars['name'];
            $surname=       $put_vars['surname'];
            $credits =      $put_vars['credits'];
            // $pass =         $put_vars['pass'];
            
            $class = new User();
            $class->load($id);
            
            $class->setAddressId($address_id);
            $class->setName($name);
            $class->setSurname($surname);
            $class->setCredits($credits);
            // $class->setPass($pass);
            break;
        
        case 'box':
            $address_id = $put_vars['address_id'];
            $size_id = $put_vars['size_id'];
            $class = new Box();
            $class->load($id);
            $class->setAddressId($address_id);
            $class->setSizeId($size_id);
            break;
        
        case 'size':
            $size = $put_vars['size'];
            $price = $put_vars['price'];
            $class = new Size();
            $class->load($id);
            $class->setSize($size);
            $class->setPrice($price);
            break;
        
        case 'address':
            $city   = $put_vars['city'];
            $code   = $put_vars['code'];
            $street = $put_vars['street'];
            $flat   = $put_vars['flat'];
            $class = new Address();
            $class->load($id);
            
            $class->setCity($city);
            $class->setCode($code);
            $class->setStreet($street);
            $class->setFlat($flat);
            break;
        
        case 'parcel':
            $address_id = $put_vars['address_id'];
            $size_id = $put_vars['size_id'];
            $user_id = $put_vars['user_id'];
            $class = new Parcel();
            $class->load($id);
            $class->setAddressId($address_id);
            $class->setSizeId($size_id);
            $class->setUserId($user_id);
            break;
        
        default:
            break;
    }

    if( $class->update() == false ) {
        return false;
    }else {
        return true;
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
     parse_str(file_get_contents("php://input"), $put_vars);
     $id = $put_vars['id'];

     switch ($requestClass) {
        case 'user':
            $class = new User();
            $class->load($id);
            break;
        
        case 'box':
            $class = new Box();
            $class->load($id);
            break;
        
        case 'size':
            $class = new Size();
            $class->load($id);
            break;
        
        case 'address':
            $class = new Address();
            $class->load($id);
            break;
        
        case 'parcel':
            $class = new Parcel();
            $class->load($id);
            break;
        
        default:
            break;
    }

    if( $class->delete() == false ) {
        return false;
    }else {
        return true;
    }
    
}


