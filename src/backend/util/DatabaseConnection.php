<?php

require_once __DIR__ . "/config.php";

class DatabaseConnection{
    private mysqli $connection;
    private string $hostname;
    private string $username;
    private string $password;
    private string $dbname;

    // Constructor
    public function __construct()
    {
        global $dbconfig;
        $this->hostname = $dbconfig['hostname'];
        $this->username = $dbconfig['username'];
        $this->password = $dbconfig['password'];
        $this->dbname = $dbconfig['dbname'];
        // Initialize connection to database
        $this->initDatabase();
    }

    // Method for initializing connection
    private function initDatabase()
    {
        $this->connection = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);

        if(!$this->connection){
            error_log("Database connection failed: " . mysqli_connect_error());
        }
    }

    // Getter
    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}

?>