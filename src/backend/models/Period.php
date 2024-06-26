<?php

namespace Models;

use DateTime;
use JsonSerializable;

require_once __DIR__ . "/QuestionType.php";

class Period implements JsonSerializable
{
    private int $id;
    private ?int $question_id;
    private string $title_en;
    private string $title_sk;
    private string $content_en;
    private string $content_sk;
    private QuestionType $question_type;
    private DateTime $start_timestamp;
    private DateTime $end_timestamp;
    private string $code;
    private bool $is_open;

    // Constructor
    public function __construct(?int          $question_id, string $title_en, string $title_sk, string $content_en, string $content_sk,
                                QuestionType $question_type, DateTime $start_timestamp, DateTime $end_timestamp, string $code, bool $is_open = false)
    {
        $this->question_id = $question_id;
        $this->title_en = $title_en;
        $this->title_sk = $title_sk;
        $this->content_en = $content_en;
        $this->content_sk = $content_sk;
        $this->question_type = $question_type;
        $this->start_timestamp = $start_timestamp;
        $this->end_timestamp = $end_timestamp;
        $this->code = $code;
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

    public function getQuestionId(): int
    {
        return $this->question_id;
    }

    public function setQuestionId(int $question_id): void
    {
        $this->question_id = $question_id;
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

    public function getQuestionType(): QuestionType
    {
        return $this->question_type;
    }

    public function setQuestionType(QuestionType $question_type): void
    {
        $this->question_type = $question_type;
    }

    public function getStartTimestamp(): DateTime
    {
        return $this->start_timestamp;
    }

    public function setStartTimestamp(DateTime $start_timestamp): void
    {
        $this->start_timestamp = $start_timestamp;
    }

    public function getEndTimestamp(): DateTime
    {
        return $this->end_timestamp;
    }

    public function setEndTimestamp(DateTime $end_timestamp): void
    {
        $this->end_timestamp = $end_timestamp;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
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
            "questionId" => $this->question_id,
            "titleEn" => $this->title_en,
            "titleSk" => $this->title_sk,
            "contentEn" => $this->content_en,
            "contentSk" => $this->content_sk,
            "questionType" => $this->question_type->value,
            "startTimestamp" => $this->start_timestamp->format("Y-m-d H:i:s"),
            "endTimestamp" => $this->end_timestamp->format("Y-m-d H:i:s"),
            "code" => $this->code,
            "is_open" => $this->is_open,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

?>