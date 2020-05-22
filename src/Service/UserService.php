<?php
namespace App\Service;

use App\Entity\User;
use App\Dao\UserDao;
use App\Service\UserValidator;

class UserService
{
    public $userDao;
    public $validator;
    
    public $logged_in; 

    public $useremail;     
    // private $userid;        
    public $username;       
    
    public function __construct(UserDao $userDao, UserValidator $validator) 
    {     
        $this->userDao = $userDao;
        $this->validator = $validator;

        $this->logged_in = $this->isLogin();
    }

    public function logout() 
    {
        //if (isset($_COOKIE['cookname'])) {
        //    setcookie("cookname", "", time() - self::COOKIE_EXPIRE, self::COOKIE_PATH);
        //}

        unset($_SESSION['useremail']);
        $this->logged_in = false;
        $this->useremail = '';
        $this->username = '';
    }

    private function isLogin() {

        if (isset($_SESSION['useremail'])) {

            $userinfo = $this->userDao->get($_SESSION['useremail']);
            if(!$userinfo){
                return false;
            }
            
            $this->useremail = $userinfo['useremail'];
            //$this->userid = $userinfo['id'];
            $this->username = $userinfo['username'];
            
            return true;
        }
        
        //if (isset($_COOKIE['cookname'])) {
        //    $this->useremail = $_SESSION['useremail'] = $_COOKIE['cookname'];
        //    return true;
        //}
        
        return false;
    }

    public function login($values) {
        
        $useremail = $values['useremail']; 
        $password = $values['password']; 
        //$rememberme = isset($values['rememberme']);
                
        $this->validator->validate("useremail", $useremail);
        $this->validator->validate("password", $password);

        if ($this->validator->num_errors > 0) {
            return false;
        }
        
        if (!$this->validator->validateCredentials($useremail, $password)) {
            return false;
        }

        $userinfo = $this->userDao->get($useremail);
        if(!$userinfo){
            return false;
        }
        
        $this->useremail = $_SESSION['useremail'] = $userinfo['useremail'];
        $this->userid = $userinfo['id'];
        $this->username = $userinfo['username'];

        
        //if ($rememberme == 'true') {
        //    setcookie("cookname", $this->useremail, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH);
        //}

        return true;
    }

    public function register($values) 
    {
        $username = $values['username']; 
        $useremail = $values['useremail']; 
        $password = $values['password']; 
                
        $this->validator->validate("username", $username);
        $this->validator->validate("useremail", $useremail);
        $this->validator->validate("password", $password);
        
        if ($this->validator->num_errors > 0) {
            return false;
        }
        
        if($this->validator->emailExists($useremail)) {
            return false;
        }  
        
        $userArr = $this->userDao->toArray(new User($username, $useremail, $password));
        return $this->userDao->insert($userArr);
    }

    public function printUsers()
    {
        foreach ($this->userDao->getUsers() as $user) {
            echo $user['id']."<br />";
            echo $user['username']."<br />";
            echo $user['useremail']."<br />";
        }
    }

}