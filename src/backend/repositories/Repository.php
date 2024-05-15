<?php

namespace Repositories;
require_once __DIR__ . "/../loader.php";
use mysqli;
use Util\DatabaseConnection;

class Repository
{
    private bool $started = false;
    protected mysqli $connection;

    public function __construct()
    {
        $this->started = false;
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function startTransaction()
    {
        if (!$this->started) {
            $this->connection->query("START TRANSACTION");
            $this->started = true;
        }
    }

    public function commitTransaction()
    {
        if ($this->started) {
            $this->connection->query("COMMIT");
            $this->started = false;
        }
    }

    public function rollbackTransaction()
    {
        if ($this->started) {
            $this->connection->query("ROLLBACK");
            $this->started = false;
        }
    }
}