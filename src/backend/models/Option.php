<?php

class Option
{
    private int $id;
    private int $question_id;
    private string $value_en;
    private string $value_sk;
    private bool $is_correct;

    // Constructor
    public function __construct(int $question_id, string $value_en, string $value_sk, bool $is_correct)
    {
        $this->question_id = $question_id;
        $this->value_en = $value_en;
        $this->value_sk = $value_sk;
        $this->is_correct = $is_correct;
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

    public function getValueEn(): string
    {
        return $this->value_en;
    }

    public function setValueEn(string $value_en): void
    {
        $this->value_en = $value_en;
    }

    public function getValueSk(): string
    {
        return $this->value_sk;
    }

    public function setValueSk(string $value_sk): void
    {
        $this->value_sk = $value_sk;
    }

    public function isIsCorrect(): bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(bool $is_correct): void
    {
        $this->is_correct = $is_correct;
    }

    // toArray
    public function toArray()
    {
        return [
            "id" => $this->id,
            "questionId" => $this->question_id,
            "valueEn" => $this->value_en,
            "valueSk" => $this->value_sk,
            "isCorrect" => $this->is_correct,
        ];
    }
}

?>