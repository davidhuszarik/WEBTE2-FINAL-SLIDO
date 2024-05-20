<?php

namespace Models;

use DateTime;

require_once __DIR__ . "/QuestionType.php";

class Question implements \JsonSerializable
{
    private int $id;
    private int $user_id;
    private string $title_en;
    private string $title_sk;
    private string $content_en;
    private string $content_sk;
    private DateTime $creation_date;
    private QuestionType $question_type;
    private bool $is_open;

    // Constructor
    public function __construct(int      $user_id, string $title_en, string $title_sk, string $content_en, string $content_sk,
                                DateTime $date_time, QuestionType $question_type, bool $is_open = false)
    {
        $this->user_id = $user_id;
        $this->title_en = $title_en;
        $this->title_sk = $title_sk;
        $this->content_en = $content_en;
        $this->content_sk = $content_sk;
        $this->creation_date = $date_time;
        $this->question_type = $question_type;
        $this->is_open = $is_open;
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

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getTitleEn(): string
    {
        return $this->title_en;
    }

    public function setTitleEn(string $title_en): void
    {
        $this->title_en = $title_en;
    }

    public function getTitleSk(): string
    {
        return $this->title_sk;
    }

    public function setTitleSk(string $title_sk): void
    {
        $this->title_sk = $title_sk;
    }

    public function getContentEn(): string
    {
        return $this->content_en;
    }

    public function setContentEn(string $content_en): void
    {
        $this->content_en = $content_en;
    }

    public function getContentSk(): string
    {
        return $this->content_sk;
    }

    public function setContentSk(string $content_sk): void
    {
        $this->content_sk = $content_sk;
    }

    public function getCreationDate(): DateTime
    {
        return $this->creation_date;
    }

    public function setCreationDate(DateTime $creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getQuestionType(): QuestionType
    {
        return $this->question_type;
    }

    public function setQuestionType(QuestionType $question_type): void
    {
        $this->question_type = $question_type;
    }

    public function isIsOpen(): bool
    {
        return $this->is_open;
    }

    // toArray
    public function toArray()
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "title_en" => $this->title_en,
            "title_sk" => $this->title_sk,
            "content_en" => $this->content_en,
            "content_sk" => $this->content_sk,
            "creation_date" => $this->creation_date->format("Y-m-d H:i:s"),
            "type" => $this->question_type->value,
            "is_open" => $this->is_open
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

?>