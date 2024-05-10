<?php

// necessary imports
require_once __DIR__ . "/../util/DatabaseConnection.php";

class PickedStaticOptionRepository{
    private mysqli $connection;

    // Construct
    public function __construct(){
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }
}

?>