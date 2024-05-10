<?php
namespace Repositories;

// necessary imports
require_once __DIR__ . "/../util/DatabaseConnection.php";

class PeriodRepository{
    private mysqli $connection;

    // Constructor
    public function __construct(){
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    // CRUD methods
    // Create new period
    public function createNewPeriod(Period $new_period)
    {
        $query = "INSERT INTO periods (question_id, title_en, title_sk, content_en, content_sk, type, start_timestamp, 
                     end_timestamp, code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $question_id = $new_period->getQuestionId();
        $title_en = $new_period->getTitleEn();
        $title_sk = $new_period->getTitleSk();
        $content_en = $new_period->getContentEn();
        $content_sk = $new_period->getContentSk();
        $type = $new_period->getQuestionType()->value;
        $start_timestamp = $new_period->getStartTimestamp()->format("Y-m-d H:i:s");
        $end_timestamp = $new_period->getEndTimestamp()->format("Y-m-d H:i:s");
        $code = $new_period->getCode();

        $stmt->bind_param("issssssss",
            $question_id,
            $title_en,
            $title_sk,
            $content_en,
            $content_sk,
            $type,
            $start_timestamp,
            $end_timestamp,
            $code
        );

        if($stmt->execute()){
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        }else{
            error_log("Error creating new period: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all periods (no restriction)
    public function getAllPeriods()
    {
        $query = "SELECT * FROM periods";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if($stmt->execute()){
            $result = $stmt->get_result();
            $periods_array = [];
            while ($row = $result->fetch_assoc()){
                $start_timestamp = new DateTime($row['start_timestamp']);
                $end_timestamp = new DateTime($row['end_timestamp']);

                try {
                    $type = QuestionType::from($row['type']);
                }catch (UnhandledMatchError $e){
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return null;
                }

                $period = new Period($row['question_id'], $row['title_en'], $row['title_sk'], $row['content_en'],
                                    $row['content_sk'], $type, $start_timestamp, $end_timestamp, $row['code']);
                $period->setId($row['id']);
                $periods_array[] = $period;
            }
            $stmt->close();
            return $periods_array;
        }else{
            error_log("Error retrieving all periods: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get period by ID
    public function getPeriodById(int $id)
    {
        $query = "SELECT * FROM periods WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        $period = null;
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("i", $id);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row){
                $start_timestamp = new DateTime($row['start_timestamp']);
                $end_timestamp = new DateTime($row['end_timestamp']);

                try {
                    $type = QuestionType::from($row['type']);
                }catch (UnhandledMatchError $e){
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return null;
                }

                $period = new Period($row['question_id'], $row['title_en'], $row['title_sk'], $row['content_en'],
                    $row['content_sk'], $type, $start_timestamp, $end_timestamp, $row['code']);
                $period->setId($row['id']);
            }
            $stmt->close();
        }else{
            error_log("Error retrieving period with id: " . $id . " error: " . $stmt->error);
            $stmt->close();
        }
        return $period;
    }

    // Delete period by ID
    public function deletePeriodById(int $id)
    {
        $query = "DELETE FROM periods WHERE id = ?";

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

    // Update period
    public function updatePeriod(Period $period)
    {
        $query = "UPDATE periods SET question_id = ?, title_en = ?, title_sk = ?, content_en = ?, content_sk = ?, type = ?
                   , start_timestamp = ?, end_timestamp = ?, code = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $period_id = $period->getId();
        $question_id = $period->getQuestionId();
        $title_en = $period->getTitleEn();
        $title_sk = $period->getTitleSk();
        $content_en = $period->getContentEn();
        $content_sk = $period->getContentSk();
        $type = $period->getQuestionType()->value;
        $start_timestamp = $period->getStartTimestamp()->format("Y-m-d H:i:s");
        $end_timestamp = $period->getEndTimestamp()->format("Y-m-d H:i:s");
        $code = $period->getCode();

        $stmt->bind_param("issssssssi",
            $question_id,
            $title_en,
            $title_sk,
            $content_en,
            $content_sk,
            $type,
            $start_timestamp,
            $end_timestamp,
            $code,
            $period_id
        );

        if($stmt->execute()){
            if($stmt->affected_rows === 0){
                error_log("No rows updated, possibly because the period ID does not exit.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        }else{
            error_log("Updated execution failed with period ID: " . $period_id . " error: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}

?>