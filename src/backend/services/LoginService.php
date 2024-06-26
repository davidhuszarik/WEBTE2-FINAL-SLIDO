<?php

namespace Services;

use Models\User;
use Repositories\UserRepository;

class LoginService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getLoggedInUser()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
            return $_SESSION['user'];
        }
        else{
            return null;
        }
    }

    public function login()
    {
        if (preg_match('/^[a-zA-Z0-9._]{1,64}$/', $_POST['username'])){
            $user = $this->userRepository->getByUsername($_POST['username']);

            if ($user == null) {
                echo json_encode(["error" => "Invalid username or password"]);
                http_response_code($response_code = 400);
                $_SESSION['loggedIn'] = false;
            }
            else{
                if (password_verify($_POST['password'] . $user->getSalt(), $user->getHashedPassword())) {
                    if ($this->userRepository->touch($user) != null){
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['user'] = $user;
                        http_response_code($response_code = 200);
                    }
                    else{
                        echo json_encode(["error" => "Internal server error"]);
                        http_response_code($response_code = 500);
                        $_SESSION['loggedIn'] = false;
                    }
                }
                else{
                    echo json_encode(["error" => "Invalid username or password"]);
                    http_response_code($response_code = 400);
                    $_SESSION['loggedIn'] = false;
                }
            }
        }
        else{
            echo json_encode(["error" => "Invalid username or password"]);
            http_response_code($response_code = 400);
            $_SESSION['loggedIn'] = false;
        }
    }

    public function logout(){
        session_destroy();
        session_start();
        $_SESSION['loggedIn'] = false;
    }

    public function updateSessionUser()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
            $_SESSION['user'] = $this->userRepository->getUserById($_SESSION['user']->getId());
        }
    }
}