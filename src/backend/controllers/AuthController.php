<?php
namespace Controllers;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

use Models\User;
use Models\UserRole;
use Repositories\UserRepository;
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
        $this->render("login", []);
        header("Content-Type: text/html");
    }

    public function login(): void
    {
        $this->loginService->login();
        header("Content-Type: application/json");
    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Content-Type: application/json");
    }

    public function registerIndex(): void
    {
        $this->render("register", []);
        header("Content-Type: text/html");
    }

    public function register(): void
    {
        $this->registerService->register();
        header("Content-Type: application/json");
    }
}