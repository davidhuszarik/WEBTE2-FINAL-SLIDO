<?php

namespace Services;

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

    // Get answer by ID
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
        $answer = $this->answer_repository->getAnswerById($answer_id);
        if (!$answer) {
            return [
                'error' => 'Answer not found',
                'status' => 404
            ];
        }
        return [
            'message' => 'Successfully retrieved answer',
            'status' => 200,
            'data' => $answer
        ];
    }

    // Delete answer by ID
    public function deleteAnswerById(int $answer_id)
    {
        $deleted = $this->answer_repository->deleteAnswerById($answer_id);
        if ($deleted) {
            return [
                'message' => 'Answer deleted successfully',
                'status' => 200
            ];
        } else {
            return [
                'error' => 'Failed to delete answer',
                'status' => 500
            ];
        }
    }

    // Update answer
    public function updateAnswer(Answer $answer)
    {
        $updated = $this->answer_repository->updateAnswer($answer);
        if ($updated) {
            return [
                'message' => 'Answer updated successfully',
                'status' => 200
            ];
        } else {
            return [
                'error' => 'Failed to update answer',
                'status' => 500
            ];
        }
    }

    // Helper
    // Broadcast the vote update to the WebSocket server
    private function broadcastVoteUpdate($answer_id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8282");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['action' => 'update_vote', 'answer_id' => $answer_id]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function checkSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

?>
