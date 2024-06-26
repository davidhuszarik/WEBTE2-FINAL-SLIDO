<?php

namespace Repositories;
require_once __DIR__ . "/Repository.php";
require_once __DIR__ . "/../loader.php";

use Models\PickedStaticOption;
use mysqli;
use Util\DatabaseConnection;

class PickedStaticOptionRepository extends Repository
{
    // Construct
    public function __construct()
    {
        parent::__construct();
    }

    // CRUD methods
    // Create new
    public function createNewPickedStaticOption(PickedStaticOption $picked_static_option)
    {
        $query = "INSERT INTO picked_static_options (answer_id, static_option_id) VALUES (?, ?)";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $answer_id = $picked_static_option->getAnswerId();
        $static_option_id = $picked_static_option->getStaticOptionId();

        $stmt->bind_param("ii",
            $answer_id,
            $static_option_id
        );

        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        } else {
            error_log("Error creating new picked static option: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all picked static options (no restriction)
    public function getAllPickedStaticOptions()
    {
        $query = "SELECT * FROM picked_static_options";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $picked_static_options_array = [];
            while ($row = $result->fetch_assoc()) {
                $tmp = new PickedStaticOption($row['answer_id'], $row['static_option_id']);
                $picked_static_options_array[] = $tmp;
            }
            $stmt->close();
            return $picked_static_options_array;
        } else {
            error_log("Error retrieving all picked static options: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get picked static options by answer ID
    public function getPickedOptionsByAnswerId(int $answer_id)
    {
        $query = "SELECT * FROM picked_static_options WHERE answer_id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $answer_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $picked_static_options_array = [];
            while ($row = $result->fetch_assoc()) {
                $tmp = new PickedStaticOption($row['answer_id'], $row['static_option_id']);
                $picked_static_options_array[] = $tmp;
            }
            $stmt->close();
            return $picked_static_options_array;
        } else {
            error_log("Error retrieving picked static options for answer ID " . $answer_id . ": " . $stmt->error);
            $stmt->close();
            return [];
        }
    }
}

?>