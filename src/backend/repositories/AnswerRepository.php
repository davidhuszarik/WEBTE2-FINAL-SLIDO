<?php

// necessary imports
require_once __DIR__ . "/../util/DatabaseConnection.php";

class AnswerRepository
{
    private mysqli $connection;

    // Construct
    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    // CRUD methods
    // Create answer
    public function createAnswer(Answer $new_answer)
    {
        $query = "INSERT INTO answers (period_id, user_id, type, free_answer, vote_time) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $period_id = $new_answer->getPeriodId();
        $user_id = $new_answer->getUserId();
        $type = $new_answer->getQuestionType()->value;
        $free_answer = $new_answer->getFreeAnswer();
        $vote_time = $new_answer->getVoteTime()->format("Y-m-d H:i:s");

        $stmt->bind_param("iisss",
            $period_id,
            $user_id,
            $type,
            $free_answer,
            $vote_time
        );

        if($stmt->execute()){
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        }else{
            error_log("Error creating new answer: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all answers (no restriction)
    public function getAllAnswers()
    {
        $query = "SELECT * FROM answers";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if($stmt->execute()){
            $result = $stmt->get_result();
            $answers_array = [];
            while ($row = $result->fetch_assoc()){
                $vote_time = new DateTime($row['vote_time']);

                try {
                    $type = QuestionType::from($row['type']);
                }catch (UnhandledMatchError $e){
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return [];
                }

                $answer = new Answer($row['period_id'], $row['user_id'], $type, $row['free_answer'], $vote_time);
                $answer->setId($row['id']);
                $answers_array[] = $answer;
            }
            $stmt->close();
            return $answers_array;
        }else{
            error_log("Error retrieving all answers: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get answer by ID
    public function getAnswerById(int $id)
    {
        $query = "SELECT * FROM answers WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        $answer = null;

        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return null;
        }

        $stmt->bind_param("i", $id);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row){
                $vote_time = new DateTime($row['vote_time']);

                try {
                    $type = QuestionType::from($row['type']);
                }catch (UnhandledMatchError $e){
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return [];
                }

                $answer = new Answer($row['period_id'], $row['user_id'], $type, $row['free_answer'], $vote_time);
                $answer->setId($row['id']);
            }
            $stmt->close();
        }else{
            error_log("Error retrieving answer with id " . $id . " error: " . $stmt->error);
            $stmt->close();
        }
        return $answer;
    }

    // Delete answer by ID
    public function deleteAnswerById(int $id)
    {
        $query = "DELETE FROM answers WHERE id = ?";

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
        }else {
            error_log("Deletion execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Update answer
    public function updateAnswer(Answer $answer)
    {
        $query = "UPDATE answers SET period_id = ?, user_id = ?, type = ?, free_answer = ?, vote_time = ? WHERE id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $answer_id = $answer->getId();
        $period_id = $answer->getPeriodId();
        $user_id = $answer->getUserId();
        $type = $answer->getQuestionType()->value;
        $free_answer = $answer->getFreeAnswer();
        $vote_time = $answer->getVoteTime()->format("Y-m-d H:i:s");

        $stmt->bind_param("iisssi",
            $period_id,
            $user_id,
            $type,
            $free_answer,
            $vote_time,
            $answer_id
        );

        if($stmt->execute()){
            if($stmt->affected_rows === 0){
                error_log("No rows updated, possibly because the answer ID does not exist.");
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        }else{
            error_log("Update execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}

?>