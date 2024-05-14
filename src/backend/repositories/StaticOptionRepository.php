<?php

namespace Repositories;
require_once __DIR__ . "/../loader.php";

use Models\StaticOption;
use mysqli;
use Util\DatabaseConnection;

class StaticOptionRepository
{
    private mysqli $connection;

    // Constructor
    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    // CRUD methods
    // Create new option
    public function createNewStaticOption(StaticOption $new_static_option)
    {
        $query = "INSERT INTO static_options (period_id, value_en, value_sk, is_correct) VALUES (?, ?, ?, ?)";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $period_id = $new_static_option->getPeriodId();
        $value_en = $new_static_option->getValueEn();
        $value_sk = $new_static_option->getValueSk();
        $is_correct = $new_static_option->isIsCorrect() ? 1 : 0;

        $stmt->bind_param("issi",
            $period_id,
            $value_en,
            $value_sk,
            $is_correct,
        );

        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        } else {
            error_log("Error creating new static option: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all options (no restriction)
    public function getAllStaticOptions()
    {
        $query = "SELECT * FROM static_options";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $static_options_array = [];
            while ($row = $result->fetch_assoc()) {
                $is_correct = (bool)$row['is_correct'];
                $option = new StaticOption($row['period_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
                $static_options_array[] = $option;
            }
            $stmt->close();
            return $static_options_array;
        } else {
            error_log("Error retrieving all users: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get option by ID
    public function getStaticOptionById(int $id)
    {
        $query = "SELECT * FROM static_options WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        $option = null;
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row) {
                $is_correct = (bool)$row['is_correct'];
                $option = new StaticOption($row['period_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
            }
            $stmt->close();
        } else {
            error_log("Error retrieving static option with id: " . $id . " error: " . $stmt->error);
            $stmt->close();
        }
        return $option;
    }

    // Delete option by ID
    public function deleteStaticOptionById(int $id)
    {
        $query = "DELETE FROM static_options WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            error_log("Deletion execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Update option
    public function updateStaticOption(StaticOption $option)
    {
        $query = "UPDATE static_options SET period_id = ?, value_en = ?, value_sk = ? , is_correct = ? WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $option_id = $option->getId();
        $period_id = $option->getPeriodId();
        $value_en = $option->getValueEn();
        $value_sk = $option->getValueSk();
        $is_correct = $option->isIsCorrect() ? 1 : 0;

        $stmt->bind_param("issii",
            $period_id,
            $value_en,
            $value_sk,
            $is_correct,
            $option_id
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows === 0) {
                error_log("No rows updated, possibly because the static option ID does not exit.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        } else {
            error_log("Update execution failed for static option ID " . $option_id . ": " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Specific methods
    // ----------------------------

    // get all options associated to period id
    public function getAllStaticOptionsByPeriodId(int $period_id)
    {
        $query = "SELECT * FROM static_options WHERE period_id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $period_id);
        $static_options_array = [];

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $is_correct = (bool)$row['is_correct'];
                $option = new StaticOption($row['period_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
                $static_options_array[] = $option;
            }
            $stmt->close();
        } else {
            error_log("Error retrieving static options by period id");
            $stmt->close();
        }

        return $static_options_array;
    }
}

?>