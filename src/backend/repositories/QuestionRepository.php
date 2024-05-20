<?php

namespace Repositories;
require_once __DIR__ . "/Repository.php";
require_once __DIR__ . "/../loader.php";

use DateTime;
use Models\Question;
use Models\QuestionType;
use mysqli;
use UnhandledMatchError;
use Util\DatabaseConnection;

class QuestionRepository extends Repository
{
    // Construct
    public function __construct()
    {
        parent::__construct();
    }

    // CRUD methods
    // ----------------------------------
    // Create new Question
    public function createNewQuestion(Question $new_question)
    {
        $query = "INSERT INTO questions (user_id, title_en, title_sk, content_en, content_sk, creation_date, type)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return -1;
        }

        $user_id = $new_question->getUserId();
        $title_en = $new_question->getTitleEn();
        $title_sk = $new_question->getTitleSk();
        $content_en = $new_question->getContentEn();
        $content_sk = $new_question->getContentSk();
        $creation_date = $new_question->getCreationDate()->format("Y-m-d H:i:s");
        $type = $new_question->getQuestionType()->value;

        $stmt->bind_param("issssss",
            $user_id,
            $title_en,
            $title_sk,
            $content_en,
            $content_sk,
            $creation_date,
            $type,
        );

        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            return $inserted_id;
        } else {
            error_log("Error creating new question: " . $stmt->error);
            $stmt->close();
            return -1;
        }
    }

    // Get all questions (no restriction)
    public function getAllQuestions()
    {
        $query = "SELECT *,
    CASE
        WHEN EXISTS (
            SELECT 1
            FROM periods p
            WHERE p.question_id = q.id
              AND NOW() < p.end_timestamp
        ) THEN true
        ELSE false
        END AS is_open
FROM
    questions q  -- Replace 1 with the specific question_id you want to check
";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $qustions_array = [];
            while ($row = $result->fetch_assoc()) {
                $creation_date = new DateTime($row['creation_date']);
                try {
                    $type = QuestionType::from($row['type']);
                } catch (UnhandledMatchError $e) {
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return null;
                }

                $is_open = (bool)$row['is_open'];

                $question = new Question($row['user_id'], $row['title_en'], $row['title_sk'], $row['content_en'], $row['content_sk'],
                    $creation_date, $type, $is_open);
                $question->setId($row['id']);
                $qustions_array[] = $question;
            }
            $stmt->close();
            return $qustions_array;
        } else {
            error_log("Error retrieving all users: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }

    // Get question by ID (no restriction)
    public function getQuestionById(int $id)
    {
        $query = "SELECT
    *,
    CASE
        WHEN EXISTS (
            SELECT 1
            FROM periods p
            WHERE p.question_id = q.id
              AND NOW() < p.end_timestamp
        ) THEN true
        ELSE false
        END AS is_open
FROM
    questions q
WHERE
    q.id = ?;  -- Replace 1 with the specific question_id you want to check
";

        $stmt = $this->connection->prepare($query);
        $question = null;
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $creation_date = new DateTime($row['creation_date']);
                try {
                    $type = QuestionType::from($row['type']);
                } catch (UnhandledMatchError $e) {
                    error_log("Invalid question type: " . $row['type']);
                    $stmt->close();
                    return null;
                }

                $is_open = (bool)$row['is_open'];

                $question = new Question($row['user_id'], $row['title_en'], $row['title_sk'], $row['content_en'], $row['content_sk'],
                    $creation_date, $type, $is_open);
                $question->setId($row['id']);
            }
            $stmt->close();
        } else {
            error_log("Error retrieving answer with id: " . $id . " error: " . $stmt->error);
            $stmt->close();
        }
        return $question;
    }

    // Delete question by ID
    public function deleteQuestionById(int $id)
    {
        $query = "DELETE FROM questions WHERE id = ?";

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

    // Update question
    public function updateQuestion(Question $question)
    {
        $query = "UPDATE questions SET user_id = ?, title_en = ?, title_sk = ?, content_en = ?, content_sk = ?, creation_date = ?,
                    type = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return false;
        }

        $question_id = $question->getId();
        $user_id = $question->getUserId();
        $title_en = $question->getTitleEn();
        $title_sk = $question->getTitleSk();
        $content_en = $question->getContentEn();
        $content_sk = $question->getContentSk();
        $creation_date = $question->getCreationDate()->format("Y-m-d H:i:s");
        $type = $question->getQuestionType()->value;

        $stmt->bind_param("issssssi",
            $user_id,
            $title_en,
            $title_sk,
            $content_en,
            $content_sk,
            $creation_date,
            $type,
            $question_id
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows === 0) {
                error_log("No rows updated, possibly because the question ID does not exist");
                $stmt->close();
                return true;
            }
            $stmt->close();
            return true;
        } else {
            error_log("Update execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }


    // Specific Methods
    // ---------------------------

    // Get questions by user id
    public function getQuestionsByUserId(int $user_id)
    {
        $query = "SELECT
    *,
    CASE
        WHEN EXISTS (
            SELECT 1
            FROM periods p
            WHERE p.question_id = q.id
              AND NOW() < p.end_timestamp
        ) THEN true
        ELSE false
        END AS is_open
FROM
    questions q
WHERE
    q.user_id = ?";

        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $user_id);
        $questions_array = [];

        if($stmt->execute()){
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                $creation_date = new DateTime($row['creation_date']);
                $question_type = QuestionType::from($row['type']);
                $question = new Question($row['user_id'], $row['title_en'], $row['title_sk'], $row['content_en'],
                                         $row['content_sk'], $creation_date, $question_type, (bool)$row['is_open']);
                $question->setId($row['id']);
                $questions_array[] = $question;
            }
            $stmt->close();
            return $questions_array;
        }else{
            error_log("Failed retrieving questions for user_id: " . $user_id . ", error: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }
}

?>