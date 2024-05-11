<?php
namespace Controllers;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../repositories/UserRepository.php";
use Models\User;
use Repositories\UserRepository;

class AuthController extends Controller
{
    public function index(): void
    {
        $this->render("login", []);
        header("Content-Type: text/html");
    }

    public function login(): void
    {
        $repository = new UserRepository();


        if (preg_match('/^[a-zA-Z0-9._]{1,64}$/', $_POST['username'])){
            $user = $repository->getByUsername($_POST["username"]);

            if ($user == null) {
                echo json_encode(["error" => "Invalid username or password"]);
                http_response_code($response_code = 400);
            }
            else{
                if (password_verify($_POST["password"] . $user->getSalt(), $user->getHashedPassword())) {
                    $access_token = $repository->touch($user);
                    echo json_encode(["credentials" => ["username" => $user->getUserName(), "access_token" => $access_token, "role" => $user->getUserRole()]]);
                    http_response_code($response_code = 200);
                }
                else{
                    echo json_encode(["error" => "Invalid username or password"]);
                    http_response_code($response_code = 400);
                }
            }
        }
        else{
            echo json_encode(["error" => "Invalid username or password"]);
            http_response_code($response_code = 400);
        }

        header("Content-Type: application/json");
    }
}