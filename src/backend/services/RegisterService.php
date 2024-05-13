<?php

namespace Services;

require_once __DIR__ . "/../loader.php";

use Models\User;
use Models\UserRole;
use Repositories\UserRepository;

class RegisterService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    private function randomSalt(): string
    {
        return bin2hex(random_bytes(4));
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

    public function register(): void
    {
        if(preg_match('/^[a-zA-Z0-9._]{1,64}$/', $_POST['username']) && $this->validateEmail($_POST['email'])){
            $emailResult = $this->userRepository->getByEmail($_POST['email']);
            $usernameResult = $this->userRepository->getByUsername($_POST['username']);

            if ($emailResult == null && $usernameResult == null) {
                $salt = $this->randomSalt();
                $newUser = new User(
                    $_POST['username'], $_POST['email'],
                    password_hash($_POST['password'] . $salt, PASSWORD_DEFAULT),
                    $salt,
                    '', null, new \DateTime(), UserRole::User
                );

                if($this->userRepository->createNewUser($newUser) == -1){
                    echo json_encode(["error" => "Failed to create new user"]);
                    http_response_code($response_code = 500);
                }
                else{
                    echo json_encode(["success" => "User created"]);
                    http_response_code($response_code = 201);
                }
            }
            else {
                echo json_encode(["error" => "User already exists"]);
                http_response_code($response_code = 400);
            }
        }
        else{
            echo json_encode(["error" => "Invalid username or email address"]);
            http_response_code($response_code = 400);
        }
    }
}