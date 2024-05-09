<?php
require_once __DIR__ . "/UserRole.php";

class User{
    private int $id;
    private string $user_name;
    private string $email;
    private string $hashed_password;
    private string $salt;
    private string $google_2FA_secret;
    private ?string $access_token;
    private DateTime $last_access;
    private UserRole $user_role;

    // Constructor
    public function __construct(string $user_name, string $email, string $hashed_password, string $salt,
                                string $google_2FA_secret, ?string $access_token, DateTime $last_access, UserRole $userRole)
    {
        $this->user_name = $user_name;
        $this->email = $email;
        $this->hashed_password = $hashed_password;
        $this->salt = $salt;
        $this->google_2FA_secret = $google_2FA_secret;
        $this->access_token = $access_token;
        $this->last_access = $last_access;
        $this->user_role = $userRole;
    }

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashed_password;
    }

    public function setHashedPassword(string $hashed_password): void
    {
        $this->hashed_password = $hashed_password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    public function getGoogle2FASecret(): string
    {
        return $this->google_2FA_secret;
    }

    public function setGoogle2FASecret(string $google_2FA_secret): void
    {
        $this->google_2FA_secret = $google_2FA_secret;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function setAccessToken(?string $access_token): void
    {
        $this->access_token = $access_token;
    }

    public function getLastAccess(): DateTime
    {
        return $this->last_access;
    }

    public function setLastAccess(DateTime $last_access): void
    {
        $this->last_access = $last_access;
    }

    public function getUserRole(): UserRole
    {
        return $this->user_role;
    }

    public function setUserRole(UserRole $user_role): void
    {
        $this->user_role = $user_role;
    }


    // toArray
    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "username" => $this->user_name,
            "email" => $this->email,
            "hashedPassword" => $this->hashed_password,
            "salt" => $this->salt,
            "google2FASecret" => $this->google_2FA_secret,
            "accessToken" => $this->access_token,
            "lastAccess" => $this->last_access->format("Y-m-d H:i:s"),
            "role" => $this->user_role->value
        ];
    }
}

?>