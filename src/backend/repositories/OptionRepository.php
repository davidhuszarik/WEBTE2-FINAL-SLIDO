<?php

// necessary imports
require_once __DIR__ . "/../util/DatabaseConnection.php";

class OptionRepository{
    private mysqli $connection;

    // Constructor
    public function __construct(){
        $this->connection = (new DatabaseConnection())->getConnection();
    }
}

?>