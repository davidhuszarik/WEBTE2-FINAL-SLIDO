<?php

namespace Service;

use Models\Answer;
use Models\Period;
use Models\PickedStaticOption;
use Models\QuestionType;
use Models\StaticOption;
use Models\UserRole;
use Repositories\AnswerRepository;
use Repositories\PeriodRepository;
use Repositories\PickedStaticOptionRepository;
use DateTime;
use Repositories\StaticOptionRepository;
use Services\LoginService;

class AnswerService
{
    private AnswerRepository $answer_repository;
    private PickedStaticOptionRepository $picked_static_option_repository;
    private StaticOptionRepository  $static_option_repository;
    private PeriodRepository $period_repository;
    private LoginService $login_service;

    public function __construct()
    {
        $this->answer_repository = new AnswerRepository();
        $this->picked_static_option_repository = new PickedStaticOptionRepository();
        $this->static_option_repository = new StaticOptionRepository();
        $this->period_repository = new PeriodRepository();
        $this->login_service = new LoginService();
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

    public function createAnswer(Period $period, array $answerData)
    {
        $questionType = $period->getQuestionType();
        if(
            (
                $questionType == QuestionType::Open
                &&
                empty($answerData['free_answer'])
            )
            ||
            (
                (
                    $questionType == QuestionType::Single_choice
                    ||
                    $questionType == QuestionType::Multi_choice
                )
                &&
                (
                    empty($answerData['options'])
                    ||
                    !is_array($answerData['options'])
                )
            )
        ) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }

        $user = $this->login_service->getLoggedInUser();
        $userId = $user != null ? $user->getId() : null;

        if ($questionType == QuestionType::Open) {
            $answer = new Answer($period->getId(), $userId, $questionType, $answerData['free_answer']);
            if ($this->answer_repository->createAnswer($answer) !== -1){
                $this->answer_repository->commitTransaction();
                return [
                    'message' => 'Answer created successfully',
                    'status' => 200
                ];
            }
            else{
                $this->answer_repository->rollbackTransaction();
                return [
                    'message' => 'Answer creation failed',
                    'status' => 500
                ];
            }
        }
        else{
            $allOptions = $this->static_option_repository->getAllStaticOptionsByPeriodId($period->getId());
            $allOptionIds = [];
            foreach ($allOptions as $option) {
                $allOptionIds[] = $option->getId();
            }

            if (
                count($answerData['options']) == 0
                ||
                (
                    $questionType == QuestionType::Single_choice
                    &&
                    count($answerData['options']) != 1
                )
            ) {
                return [
                    'message' => 'Invalid selection',
                    'status' => 400
                ];
            }

            foreach ($answerData['options'] as $optionId) {
                if (!in_array($optionId, $allOptionIds)) {
                    return [
                        'message' => 'Invalid selection',
                        'status' => 400
                    ];
                }
            }

            // ----------
            $answer = new Answer($period->getId(), $userId, $questionType, null);

            $this->answer_repository->startTransaction();
            $answerId = $this->answer_repository->createAnswer($answer);

            if ($answerId === -1) {
                $this->answer_repository->rollbackTransaction();
                return [
                    'message' => 'Answer creation failed',
                    'status' => 500
                ];
            }

            foreach ($answerData['options'] as $optionId) {
                $staticOption = new PickedStaticOption($answerId, $optionId);
                if ($this->picked_static_option_repository->createNewPickedStaticOption($staticOption) === -1){
                    $this->answer_repository->rollbackTransaction();
                    return [
                        'message' => 'Answer creation failed',
                        'status' => 500
                    ];
                }
            }

            $this->answer_repository->commitTransaction();

            return [
                'message' => 'Answer created successfully',
                'status' => 201
            ];

        }
    }

    public function getAnswerById(int $answer_id)
    {

    }

    private function checkSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

?>
