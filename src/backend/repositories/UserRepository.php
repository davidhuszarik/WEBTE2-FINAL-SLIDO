<?php
namespace Repositories;

// necessary imports
use mysqli;
use DateTime;
use Models\User;
use Models\UserRole;
use Util\DatabaseConnection;

require_once __DIR__ . "/../util/DatabaseConnection.php";
require_once __DIR__ . "/../models/User.php";

class UserRepository
{
    private mysqli $connection;

    // Constructor
    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
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

        if($stmt->execute()){
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        }else{
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
            return [];
        }

        if($stmt->execute()){
            $result = $stmt->get_result();
            $users_array = [];
            while($row = $result->fetch_assoc()){
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
                $users_array[] = $user;
            }
            $stmt->close();
            return $users_array;
        }else{
            error_log("Error retrieving all users: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    private function getByUnique($keyType, $uniqueKey){
        $query = "SELECT * FROM user WHERE $keyType = ?";

        $stmt = $this->connection->prepare($query);
        $user = null;

        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("i", $uniqueKey);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row){
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
        }else{
            error_log("Error retrieving user with id: " . $uniqueKey . " error: " . $stmt->error);
            $stmt->close();
        }
        return $user;
    }

    // Get user by ID
    public function getUserById(int $id)
    {
        return $this->getByUnique('id', $id);
    }

    public function getByUsername(string $username)
    {
        return $this->getByUnique('username', $username);
    }

    public function getByEmail(string $email)
    {
        return $this->getByUnique('email', $email);
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

        if($stmt->execute()){
            if ($stmt->affected_rows === 0) {
                error_log("No rows updated, possibly because the user ID does not exist.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        }else {
            error_log("Update execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}

?>