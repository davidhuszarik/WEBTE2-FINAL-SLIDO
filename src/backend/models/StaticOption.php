<?php

namespace Models;

class StaticOption
{
    private int $id;
    private int $period_id;
    private string $value_en;
    private string $value_sk;
    private bool $is_correct;

    // Constructor
    public function __construct(int $period_id, string $value_en, string $value_sk, bool $is_correct)
    {
        $this->period_id = $period_id;
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

    public function getPeriodId(): int
    {
        return $this->period_id;
    }

    public function setPeriodId(int $period_id): void
    {
        $this->period_id = $period_id;
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
            "periodId" => $this->period_id,
            "valueEn" => $this->value_en,
            "valueSk" => $this->value_sk,
            "isCorrect" => $this->is_correct
        ];
    }
}

?>