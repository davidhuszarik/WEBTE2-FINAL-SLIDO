<?php

namespace Services;

use Models\Question;
use Models\QuestionType;
use Repositories\QuestionRepository;

class QuestionService
{
    private QuestionRepository $question_repository;

    public function __construct(){
        $this->question_repository = new QuestionRepository();
    }

    public function getQuestionsForGivenUser()
    {

    }
}

?>