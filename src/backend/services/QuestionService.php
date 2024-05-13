<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Repositories\QuestionRepository;

class QuestionService
{
    private QuestionRepository $question_repository;

    public function __construct()
    {
        $this->question_repository = new QuestionRepository();
    }

    public function getQuestionsForGivenUser()
    {

    }
}

?>