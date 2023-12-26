<?php

namespace controller;

use dao\UserDao;

class UserController
{
    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function index(): void
    {
        $loginPressed = filter_input(INPUT_POST, 'btnLogin');
        if (isset($loginPressed)) {
            $email = filter_input(INPUT_POST, 'txtEmail');
            $password = filter_input(INPUT_POST, 'txtPassword');
            if (trim($email) == '' || trim($password) == '') {
                echo '<div>Please input your email and password</div>';
            } else {
                /** @var  $user \entity\User */
                $user = $this->userDao->login($email, $password);
                if ($user->getEmail() == $email) {
                    $_SESSION['registered_user'] = true;
                    $_SESSION['registered_user'] = $user->getName();
                    header('location:index.php');
                } else {
                    echo '<div class="d-flex justify-content-center valided">Invalid email or password</div>';
                }
            }
        }

        $submitPressed = filter_input(INPUT_POST, 'btnSignUp');
        if (isset($submitPressed)) {
            $name = filter_input(INPUT_POST, 'signName');
            $email = filter_input(INPUT_POST, 'signEmail');
            $pass = filter_input(INPUT_POST, 'signPassword');
            if (trim($name) == ' ' || trim($email) == ' ' || trim($pass) == ' '){
                echo '<div class="d-flex justify-content-center valided">Please provide with a valid input</div>';
            } else {
                $user = new \entity\User();
                $user->setName($name);
                $user->setEmail($email);
                $user->setPassword($pass);
                $results = $this->userDao->addNewUser($user);
                if ($results) {
                    echo '<div class="d-flex justify-content-center">Data Succesfully Loaded</div>';
                } else {
                    echo '<div class="d-flex justify-content-center">Failed to add data</div>';
                }
            }
        }
        include_once 'pages\login.php';
    }
}