<?php
namespace Controllers;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../repositories/UserRepository.php";
use Models\User;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->render("login", []);
    }

    public function login(): void
    {

    }
}