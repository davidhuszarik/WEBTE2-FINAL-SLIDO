<?php

namespace Controllers;

require_once __DIR__ . "/../loader.php";
require_once __DIR__ . "/Controller.php";

use Models\User;
use Models\UserRole;
use Repositories\UserRepository;

class AuthController extends Controller
{
    public function loginIndex(): void
    {
        $this->render("login", []);
        header("Content-Type: text/html");
    }

    public function registerIndex(): void
    {
        $this->render("register", []);
        header("Content-Type: text/html");
    }

    public function login(): void
    {
        $repository = new UserRepository();

        if (preg_match('/^[a-zA-Z0-9._]{1,64}$/', $_POST['username'])) {
            $user = $repository->getByUsername($_POST["username"]);

            if ($user == null) {
                echo json_encode(["error" => "Invalid username or password"]);
                http_response_code($response_code = 400);
            } else {
                if (password_verify($_POST["password"] . $user->getSalt(), $user->getHashedPassword())) {
                    $access_token = $repository->touch($user);
                    echo json_encode(["credentials" => ["username" => $user->getUserName(), "access_token" => $access_token, "role" => $user->getUserRole()]]);
                    http_response_code($response_code = 200);
                } else {
                    echo json_encode(["error" => "Invalid username or password"]);
                    http_response_code($response_code = 400);
                }
            }
        } else {
            echo json_encode(["error" => "Invalid username or password"]);
            http_response_code($response_code = 400);
        }

        header("Content-Type: application/json");
    }

    public function register(): void
    {
        if (preg_match('/^[a-zA-Z0-9._]{1,64}$/', $_POST['username']) && $this->validateEmail($_POST['email'])) {
            $repository = new UserRepository();
            $emailResult = $repository->getByEmail($_POST['email']);
            $usernameResult = $repository->getByUsername($_POST['username']);

            if ($emailResult == null && $usernameResult == null) {
                $salt = $this->randomSalt();
                $newUser = new User(
                    $_POST['username'], $_POST['email'],
                    password_hash($_POST['password'] . $salt, PASSWORD_DEFAULT),
                    $salt,
                    '', null, new \DateTime(), UserRole::User
                );

                if ($repository->createNewUser($newUser) == -1) {
                    echo json_encode(["error" => "Failed to create new user"]);
                    http_response_code($response_code = 500);
                } else {
                    echo json_encode(["success" => "User created"]);
                    http_response_code($response_code = 201);
                }
            } else {
                echo json_encode(["error" => "User already exists"]);
                http_response_code($response_code = 400);
            }
        } else {
            echo json_encode(["error" => "Invalid username or email address"]);
            http_response_code($response_code = 400);
        }

        header("Content-Type: application/json");
    }

    private function validateEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        list($username, $domain) = explode('@', $email);

        if (!checkdnsrr($domain, 'MX')) {
            return false;
        }

        return true;
    }

    private function randomSalt(): string
    {
        return bin2hex(random_bytes(4));
    }
}