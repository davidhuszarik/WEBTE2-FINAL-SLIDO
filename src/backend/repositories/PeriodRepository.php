<?php

// necessary imports
require_once __DIR__ . "/../util/DatabaseConnection.php";

class PeriodRepository{
    private mysqli $connection;

    // Constructor
    public function __construct(){
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }
}

?>