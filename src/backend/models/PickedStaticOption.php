<?php

namespace Models;

class PickedStaticOption
{
    private int $answer_id;
    private int $static_option_id;

    // Constructor
    public function __construct(int $answer_id, int $static_option_id)
    {
        $this->answer_id = $answer_id;
        $this->static_option_id = $static_option_id;
    }

    // Getters and Setters
    public function getAnswerId(): int
    {
        return $this->answer_id;
    }

    public function setAnswerId(int $answer_id): void
    {
        $this->answer_id = $answer_id;
    }

    public function getStaticOptionId(): int
    {
        return $this->static_option_id;
    }

    public function setStaticOptionId(int $static_option_id): void
    {
        $this->static_option_id = $static_option_id;
    }

    // toArray
    public function toArray()
    {
        return [
            "answerId" => $this->answer_id,
            "staticOptionId" => $this->static_option_id
        ];
    }
}

?>