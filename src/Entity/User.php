<?php
namespace App\Entity;

class User {

    public $name;
    private $email;
    private $password;

    public function __construct(string $name, string $email, string $password){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    function getName(){
        return $this->name;
    }

    function setName($name){
        $this->name = $name;
    }

    function getEmail(){
        return $this->email;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function getPassword(){
        return $this->password;
    }

    function setPassword($password){
        $this->password = $password;
    }

}
