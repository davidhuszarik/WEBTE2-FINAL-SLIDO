<?php
namespace Controllers;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

use Services\LoginService;
use Services\UserService;

class AuthController extends Controller
{
    private LoginService $loginService;
    private UserService $userService;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->userService = new UserService();
    }

    public function loginIndex(): void
    {
        if ($this->loginService->getLoggedInUser() == null){
            $this->render("login", []);
            header("Content-Type: text/html");
        }
        else{
            header('Location: index.php');
        }
    }

    public function login(): void
    {
        if ($this->loginService->getLoggedInUser() == null){
            $this->loginService->login();
            header("Content-Type: application/json");

        }
        else{
            header('Location: index.php');
        }

    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Content-Type: application/json");
    }

    public function registerIndex(): void
    {
        if ($this->loginService->getLoggedInUser() == null){
            $this->render("register", []);
            header("Content-Type: text/html");
        }
        else{
            header('Location: index.php');
        }
    }

    public function register(): void
    {
        if ($this->loginService->getLoggedInUser() == null){
            $this->userService->register();
            header("Content-Type: application/json");
        }
        else{
            header('Location: index.php');
        }
    }

    public function changePassword(): void
    {
        if ($this->loginService->getLoggedInUser() == null){
            $this->render("login", []);
            header("Content-Type: text/html");
        }
        else{
            $this->loginService->updateSessionUser();
            $result = $this->userService->changePassword($this->loginService->getLoggedInUser());
            if ($result['status'] == 200){
                $this->loginService->updateSessionUser();
            }
            echo json_encode($result);
            http_response_code($result['status']);
            header("Content-Type: application/json");
        }
    }
}