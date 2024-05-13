<?php
namespace Controllers;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

use Services\LoginService;
use Services\RegisterService;

class AuthController extends Controller
{
    private LoginService $loginService;
    private RegisterService $registerService;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->registerService = new RegisterService();
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
            $this->registerService->register();
            header("Content-Type: application/json");
        }
        else{
            header('Location: index.php');
        }
    }
}