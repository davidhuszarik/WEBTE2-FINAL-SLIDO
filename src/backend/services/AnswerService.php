<?php

namespace Service;

use Models\Answer;
use Models\PickedStaticOption;
use Models\QuestionType;
use Models\UserRole;
use Repositories\AnswerRepository;
use Repositories\PeriodRepository;
use Repositories\PickedStaticOptionRepository;
use DateTime;

class AnswerService
{
    private AnswerRepository $answer_repository;
    private PickedStaticOptionRepository $picked_static_option_repository;
    private PeriodRepository $period_repository;

    public function __construct()
    {
        $this->answer_repository = new AnswerRepository();
        $this->picked_static_option_repository = new PickedStaticOptionRepository();
        $this->period_repository = new PeriodRepository();
    }

    public function getAllAnswers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        if ($user_role == UserRole::Admin) {
            $answers = $this->answer_repository->getAllAnswers();
            return [
                'message' => 'Successfully retrieved all answers',
                'status' => 200,
                'data' => $answers
            ];
        }else{
            return [
                'error' => 'Unauthorized access',
                'status' => 403,
            ];
        }
    }

    public function getAnswerById(int $answer_id)
    {

    }
}

?>
