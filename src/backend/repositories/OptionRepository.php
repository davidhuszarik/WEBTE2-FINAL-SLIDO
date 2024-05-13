<?php
namespace Repositories;
require_once __DIR__ . "/../loader.php";

use Util\DatabaseConnection;
use mysqli;
use Models\Option;

class OptionRepository{
    private mysqli $connection;

    // Constructor
    public function __construct(){
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    // CRUD methods
    // Create new option
    public function createNewOption(Option $new_option)
    {
        $query = "INSERT INTO options (question_id, value_en, value_sk, is_correct) VALUES (?, ?, ?, ?)";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $question_id = $new_option->getQuestionId();
        $value_en = $new_option->getValueEn();
        $value_sk = $new_option->getValueSk();
        $is_correct = $new_option->isIsCorrect() ? 1 : 0;

        $stmt->bind_param("issi",
            $question_id,
            $value_en,
            $value_sk,
            $is_correct,
        );

        if($stmt->execute()){
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        }else{
            error_log("Error creating new option: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all options (no restriction)
    public function getAllOptions()
    {
        $query = "SELECT * FROM options";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if($stmt->execute()){
            $result = $stmt->get_result();
            $options_array = [];
            while ($row = $result->fetch_assoc()){
                $is_correct = (bool) $row['is_correct'];
                $option = new Option($row['question_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
                $options_array[] = $option;
            }
            $stmt->close();
            return $options_array;
        }else{
            error_log("Error retrieving all users: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get option by ID
    public function getOptionById(int $id)
    {
        $query = "SELECT * FROM options WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        $option = null;
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("i", $id);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row){
                $is_correct = (bool) $row['is_correct'];
                $option = new Option($row['question_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
            }
            $stmt->close();
        }else{
            error_log("Error retrieving option with id: " . $id . " error: " . $stmt->error);
            $stmt->close();
        }
        return $option;
    }

    // Delete option by ID
    public function deleteOptionById(int $id)
    {
        $query = "DELETE FROM options WHERE id = ?";

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
        }else{
            error_log("Deletion execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Update option
    public function updateOption(Option $option)
    {
        $query = "UPDATE options SET question_id = ?, value_en = ?, value_sk = ? , is_correct = ? WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $option_id = $option->getId();
        $question_id = $option->getQuestionId();
        $value_en = $option->getValueEn();
        $value_sk = $option->getValueSk();
        $is_correct = $option->isIsCorrect() ? 1 : 0;

        $stmt->bind_param("issii",
            $question_id,
            $value_en,
            $value_sk,
            $is_correct,
            $option_id
        );

        if($stmt->execute()){
            if($stmt->affected_rows === 0){
                error_log("No rows updated, possibly because the option ID does not exit.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        }else{
            error_log("Update execution failed for option ID " . $option_id . ": " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Specific Methods
    // ---------------------------------

    // Get options by Question id
    public function getOptionsByQuestionId(int $question_id)
    {
        $query = "SELECT * FROM options WHERE question_id = ?";

        $stmt = $this->connection->prepare($query);
        if(!$stmt){
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $question_id);
        $options_array = [];

        if($stmt->execute()){
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()){
                $is_correct = (bool) $row['is_correct'];
                $option = new Option($row['question_id'], $row['value_en'], $row['value_sk'], $is_correct);
                $option->setId($row['id']);
                $options_array[] = $option;
            }
            $stmt->close();
            return $options_array;
        }else{
            error_log("Failed to retrieve options for question_id: " . $question_id . " error: " . $stmt->error);
            $stmt->close();
            return $options_array;
        }
    }
}

?>