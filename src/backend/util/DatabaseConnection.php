<?php

namespace Util;

use mysqli;

// necessary imports
require_once __DIR__ . "/config.php";

// Singleton Pattern for Database Connection
class DatabaseConnection
{
    private static $instance = null;
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

        if (!$this->connection) {
            error_log("Database connection failed: " . mysqli_connect_error());
            throw new Exception("Database connection failed: " . mysqli_connect_error());
        }
    }

    // Get instance of connection
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Getter
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    // Need to prevent any external code from creating a copy of the singleton instance because it should only ever have
    // one instance in the application. Overriding this method and making it private ensures that object cannot be cloned.

    public function __wakeup()
    {
        throw new Exception("Deserialization of singleton is not allowed");
    }

    public function __sleep()
    {
        throw new Exception("Serialization of singleton is not allowed");
    }

    private function __clone()
    {
    }
}

?>