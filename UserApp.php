<?php
session_start(); 
require_once __DIR__ . '/vendor/autoload.php';

use App\Dao\UserDao;
use App\Service\UserService;
use App\Service\UserValidator;

class UserApp {

    public function __construct(UserService $userService, UserValidator $validator) 
    {
        $this->userService = $userService;
        $this->validator = $validator;
        
        if (isset($_POST['login'])) {
            $this->login();
        }
        else if (isset($_POST['register'])) {
            $this->register();
        }
        else if ( isset($_GET['logout']) ) {
            $this->logout();
        }
        else if (explode('?', $_SERVER['REQUEST_URI'])[0]=='/showusers.php') {
            $this->showusers();
        }  
    }

    public function login() 
    {
        $success = $this->userService->login($_POST);
        if($success) {
            $_SESSION['statusMsg'] = "Successful login!";
            header("Location: index.php");
        } 
    }

    public function register() 
    {
        $success = $this->userService->register($_POST);
        if ($success) {
            $_SESSION['statusMsg'] = "Registration was successful!";
            header("Location: index.php");
        } 
    }

    public function logout()
    {
        $success = $this->userService->logout(); 
        header("Location: index.php");
    }

    public function showusers()
    {
        if (!$this->userService->logged_in) {
            header("Location: login.php");
        }
    }

}

$userDao = new UserDao();

$validator = new UserValidator;
$validator->setUserDao($userDao);

$userService = new UserService($userDao, $validator);

$userApp = new UserApp($userService, $validator);
