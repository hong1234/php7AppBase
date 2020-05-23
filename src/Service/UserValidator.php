<?php
namespace App\Service;

use App\Dao\UserDao;

class UserValidator {

    private $values = array();  
    private $errors = array();  
    public $statusMsg = null;   
    public $num_errors = 0;        
    
    const NAME_LENGTH_MIN = 5;
    const NAME_LENGTH_MAX = 30;
    const PASS_LENGTH_MIN = 8;
    const PASS_LENGTH_MAX = 32;

    const COOKIE_EXPIRE =  8640000;  //60*60*24*100 seconds = 100 days by default
    const COOKIE_PATH = "/";  //Available in whole domain

    public function __construct() 
    {
        $this->values = $_POST;

        // if (isset($_SESSION['statusMsg'])) {
        //     $this->statusMsg = $_SESSION['statusMsg'];
        //     unset($_SESSION['statusMsg']);
        // }

        if (isset($_COOKIE['statusMsg'])) {
            $this->statusMsg = $_COOKIE['statusMsg'];
            setcookie("statusMsg", "", time() - self::COOKIE_EXPIRE, self::COOKIE_PATH);
        }
    }
    
    public function setUserDao(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    public function validate($field, $value) 
    {
        $valid = false;
        if ($valid == $this->isEmpty($field, $value)) {
            $valid = true;
            if ($field == "username")
                $valid = $this->checkSize($field, $value, self::NAME_LENGTH_MIN, self::NAME_LENGTH_MAX);
            if ($field == "password")
                $valid = $this->checkSize($field, $value, self::PASS_LENGTH_MIN, self::PASS_LENGTH_MAX);
            if ($valid)
                $valid = $this->checkFormat($field, $value);
        }
        return $valid;
    }

    private function isEmpty($field, $value) 
    {
        $value = trim($value);
        if (empty($value)) {
            $this->setError($field, "Field value not entered");
            return true;
        }
        return false;
    }

    private function checkSize($field, $value, $minLength, $maxLength) 
    {
        $value = trim($value); 
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            $this->setError($field, "Value length should be within ".$minLength." & ".$maxLength." characters");
            return false;
        } 
        return true;
    }

    private function checkFormat($field, $value) 
    {
        switch ($field) {
            case 'useremail':
                $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*" . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*" . "\.([a-z]{2,}){1}$/i";         
                $msg = "Email address invalid";
                break;
            case 'password':   
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Password not alphanumeric";
                break;
            case 'username':
                $regex = "/^([a-z ])+$/i";
                $msg = "Name must be alphabetic";
                break;
            default:;
        }
        if (!preg_match($regex, ( $value = trim($value)))) {
            $this->setError($field, $msg);
            return false;
        }
        return true;
    }

    private function setError($field, $errmsg) 
    {
        $this->errors[$field] = $errmsg;
        $this->num_errors = count($this->errors);
    }

    public function emailExists($useremail) 
    {
        if ($this->userDao->useremailTaken($useremail)) {
            $this->setError('useremail', "Email already in use");
            return true;
        }      
        return false;
    }

    public function getError($field) 
    {
        if (array_key_exists($field, $this->errors)) {
            return $this->errors[$field];
        } else {
            return "";
        }
    }

    public function getValue($field) 
    {
        if (array_key_exists($field, $this->values)) {
            return htmlspecialchars(stripslashes($this->values[$field]));
        } else {
            return "";
        }
    }

    public function validateCredentials($useremail, $password) 
    { 
        $result = $this->userDao->checkPassConfirmation($useremail, md5($password));
        if ($result === false) {
            $this->setError("password", "Email address or password is incorrect");
            return false;
        } 
        return true;
    }

    ///////////////////////////////////////////////////////////////////////////////

   

    // public function getErrorArray() {
    //     return $this->errors;
    // }

    
    
    // public function setValue($field, $value) {
    //     $this->values[$field] = $value;
    // }



    // public function checkPassword($useremail, $password) {
        
    //     $result = $this->userDao->checkPassConfirmation($useremail, md5($password));

    //     if ($result === false) {
    //         $this->setError("password", "Current password incorrect");
    //         return false;
    //     }
        
    //     return true;
    // }

}