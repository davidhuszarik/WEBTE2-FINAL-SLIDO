<?php
namespace Repositories;
require_once __DIR__ . "/Repository.php";
require_once __DIR__ . "/../loader.php";

use UnhandledMatchError;
use mysqli;
use DateTime;
use Models\User;
use Models\UserRole;
use Util\DatabaseConnection;

class UserRepository extends Repository
{
    // Construct
    public function __construct()
    {
        parent::__construct();
    }

    // CRUD methods
    // Create new User
    public function createNewUser(User $new_user)
    {
        $query = "INSERT INTO user (username, email, hashed_password, salt, google_2FA_secret, access_token, last_access, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $username = $new_user->getUserName();
        $email = $new_user->getEmail();
        $hashed_password = $new_user->getHashedPassword();
        $salt = $new_user->getSalt();
        $google_2FA_secret = $new_user->getGoogle2FASecret();
        $access_token = $new_user->getAccessToken();
        $last_access = $new_user->getLastAccess()->format("Y-m-d H:i:s");
        $user_role = $new_user->getUserRole()->value;

        $stmt->bind_param("ssssssss",
            $username,
            $email,
            $hashed_password,
            $salt,
            $google_2FA_secret,
            $access_token,
            $last_access,
            $user_role
        );

        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        } else {
            error_log("Error creating new user: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all Users including admin
    public function getAllUser()
    {
        $query = "SELECT * FROM user";

        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $users_array = [];
            while ($row = $result->fetch_assoc()) {
                $last_access = new DateTime($row['last_access']);
                try {
                    $user_role = UserRole::from($row['role']);
                } catch (UnhandledMatchError $e) {
                    error_log("Invalid role: " . $row['role']);
                    $stmt->close();
                    return null;
                }

                $user = new User(
                    $row['username'], $row['email'], $row['hashed_password'], $row['salt'], $row['google_2FA_secret'],
                    $row['access_token'], $last_access, $user_role
                );
                $user->setId($row['id']);
                $users_array[] = $user;
            }
            $stmt->close();
            return $users_array;
        } else {
            error_log("Error retrieving all users: " . $stmt->error);
            $stmt->close();
            return null;
        }
    }

    private function getByUnique($key_name, $keyType, $uniqueKey){
        $query = "SELECT * FROM user WHERE $key_name = ?";

        $stmt = $this->connection->prepare($query);
        $user = null;

        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("$keyType", $uniqueKey);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row) {
                $last_access = new DateTime($row['last_access']);

                try {
                    $user_role = UserRole::from($row['role']);
                } catch (UnhandledMatchError $e) {
                    error_log("Invalid role: " . $row['role']);
                    $stmt->close();
                    return null;
                }

                $user = new User($row['username'], $row['email'], $row['hashed_password'], $row['salt'], $row['google_2FA_secret'],
                    $row['access_token'], $last_access, $user_role);
                $user->setId($row['id']);
            }
            $stmt->close();
        } else {
            error_log("Error retrieving user with id: " . $uniqueKey . " error: " . $stmt->error);
            $stmt->close();
        }
        return $user;
    }

    // Get user by ID
    public function getUserById(int $id)
    {
        return $this->getByUnique('id', 'i', $id);
    }

    public function getByUsername(string $username)
    {
        return $this->getByUnique('username', 's', $username);
    }

    public function getByEmail(string $email)
    {
        return $this->getByUnique('email', 's', $email);
    }

    private function randomAccessToken()
    {
        // size of access_token in bytes
        return bin2hex(random_bytes(16));
    }

    // touches the user row, generates new access token and saves it in the database
    // all time definitions must be passed to database
    public function touch(User &$user): string|null
    {
        $this->connection->query("START TRANSACTION");

        if (($token = $user->getAccessToken()) == null) {
            $newToken = $this->randomAccessToken();
            $user->setAccessToken($newToken);

            $result = $this->updateUser($user);
            if (!$result) {
                $this->connection->query("ROLLBACK");
                return null;
            }

            $token = $newToken;
        }

        // code could be shortened if database is synced with php server
        $query = "UPDATE user SET last_access = NOW() WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            $this->connection->query("ROLLBACK");
            return null;
        }

        $id = $user->getId();
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows === 0) {
                error_log("No rows updated, possibly because the user ID does not exist.");
                $stmt->close();
                $this->connection->query("ROLLBACK");
                return null;
            }
            $stmt->close();
            $this->connection->query("COMMIT");
            $user = $this->getUserById($user->getId());
            return $token;
        } else {
            error_log("Update execution failed: " . $stmt->error);
            $stmt->close();
            $this->connection->query("ROLLBACK");
            return null;
        }
    }

    // Delete user by ID
    public function deleteUserById(int $id)
    {
        $query = "DELETE FROM user WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("i", $id);

        if($stmt->execute()){
            if($stmt->affected_rows > 0){
                $stmt->close();
                return true;
            }else{
                $stmt->close();
                return false;
            }
        }else {
            error_log("Deletion execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Update user by ID
    public function updateUser(User $user)
    {
        $query = "UPDATE user SET username = ?, email = ?, hashed_password = ?, salt = ?, google_2FA_secret = ?, access_token = ?, last_access = ?, role = ? WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $user_id = $user->getId();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $hashed_password = $user->getHashedPassword();
        $salt = $user->getSalt();
        $google_2FA_secret = $user->getGoogle2FASecret();
        $access_token = $user->getAccessToken();
        $last_access = $user->getLastAccess()->format("Y-m-d H:i:s");
        $user_role = $user->getUserRole()->value;

        $stmt->bind_param("ssssssssi",
            $username,
            $email,
            $hashed_password,
            $salt,
            $google_2FA_secret,
            $access_token,
            $last_access,
            $user_role,
            $user_id
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows === 0) {
                error_log("No rows updated, possibly because the user ID does not exist.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        } else {
            error_log("Update execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}

?>