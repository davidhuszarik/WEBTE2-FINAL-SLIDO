<?php
namespace Models;
require_once __DIR__ . "/QuestionType.php";

use DateTime;

class Answer
{
    private int $id;
    private int $period_id;
    private ?int $user_id;
    private QuestionType $question_type;
    private ?string $free_answer;
    private DateTime $vote_time;

    // Constructor
    public function __construct(int $period_id, ?int $user_id, QuestionType $question_type, ?string $free_answer, DateTime $vote_time)
    {
        $this->period_id = $period_id;
        $this->user_id = $user_id;
        $this->question_type = $question_type;
        $this->free_answer = $free_answer;
        $this->vote_time = $vote_time;
    }

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPeriodId(): int
    {
        return $this->period_id;
    }

    public function setPeriodId(int $period_id): void
    {
        $this->period_id = $period_id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getQuestionType(): QuestionType
    {
        return $this->question_type;
    }

    public function setQuestionType(QuestionType $question_type): void
    {
        $this->question_type = $question_type;
    }

    public function getFreeAnswer(): ?string
    {
        return $this->free_answer;
    }

    public function setFreeAnswer(?string $free_answer): void
    {
        $this->free_answer = $free_answer;
    }

    public function getVoteTime(): DateTime
    {
        return $this->vote_time;
    }

    public function setVoteTime(DateTime $vote_time): void
    {
        $this->vote_time = $vote_time;
    }

    // toArray
    public function toArray()
    {
        return [
            "id" => $this->id,
            "periodId" => $this->period_id,
            "userId" => $this->user_id,
            "questionType" => $this->question_type->value,
            "freeAnswer" => $this->free_answer,
            "voteTime" => $this->vote_time
        ];
    }
}

?>