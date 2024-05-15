<?php

namespace Service;

use Models\Answer;
use Models\PickedStaticOption;
use Models\QuestionType;
use Models\UserRole;
use Repositories\AnswerRepository;
use Repositories\PeriodRepository;
use Repositories\PickedStaticOptionRepository;
use Services\LoginService;
use DateTime;

class AnswerService
{
    private AnswerRepository $answer_repository;
    private PickedStaticOptionRepository $picked_static_option_repository;
    private PeriodRepository $period_repository;
    private LoginService $login_service;

    public function __construct()
    {
        $this->answer_repository = new AnswerRepository();
        $this->picked_static_option_repository = new PickedStaticOptionRepository();
        $this->period_repository = new PeriodRepository();
        $this->login_service = new LoginService();
    }

    public function createAnswer(int $period_id, QuestionType $question_type, ?string $free_answer, array $picked_options)
    {
        // Check if period exists
        $period = $this->period_repository->getPeriodById($period_id);
        if (!$period) {
            return [
                'error' => 'Period not found',
                'status' => 404
            ];
        }

        // Check if the period is within the voting window
        $current_time = new DateTime();
        if ($current_time < $period->getStartTimestamp() || $current_time > $period->getEndTimestamp()) {
            return [
                'error' => 'Voting period is not active',
                'status' => 403
            ];
        }

        // Create new answer
        $user = $this->login_service->getLoggedInUser();
        if($user == null){
            $user_id = null;
        }else{
            $user_id = $user->getId();
        }
        $new_answer = new Answer($period_id, $user_id, $question_type, $free_answer, $current_time);
        $new_answer_id = $this->answer_repository->createAnswer($new_answer);
        if ($new_answer_id == -1) {
            return [
                'error' => 'Failed to create new answer',
                'status' => 500
            ];
        }

        // Associate picked static options with the new answer
        foreach ($picked_options as $option_id) {
            $picked_static_option = new PickedStaticOption($new_answer_id, $option_id);
            $picked_static_option_id = $this->picked_static_option_repository->createNewPickedStaticOption($picked_static_option);
            if ($picked_static_option_id == -1) {
                return [
                    'error' => 'Failed to associate static option with answer',
                    'status' => 500
                ];
            }
        }

        return [
            'message' => 'Answer created successfully',
            'status' => 201,
            'data' => $new_answer_id
        ];
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
}

?>
