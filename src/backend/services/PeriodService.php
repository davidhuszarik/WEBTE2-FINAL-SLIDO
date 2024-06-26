<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Models\Period;
use Models\Question;
use Models\UserRole;
use Models\QuestionType;
use DateTime;
use Repositories\PeriodRepository;
use Repositories\QuestionRepository;
use Services\StaticOptionService;
class PeriodService
{
    private PeriodRepository $period_repository;
    private QuestionRepository $question_repository;
    private StaticOptionService $static_option_service;

    public function __construct()
    {
        $this->period_repository = new PeriodRepository();
        $this->question_repository = new QuestionRepository();
        $this->static_option_service = new StaticOptionService();
    }

    // Create period
    public function createNewPeriod(Question $question, DateTime $end_timestamp)
    {
        $this->checkSession();
        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        if ($user_role == UserRole::Admin || ($user_role == UserRole::User && $question->getUserId() == $user->getId())) {
            $code = $this->generateCode();
            $start_timestamp = new DateTime();

            if($start_timestamp < $end_timestamp) {
                $this->period_repository->startTransaction();
                $new_period = new Period($question->getId(), $question->getTitleEn(), $question->getTitleSk(),
                    $question->getContentEn(), $question->getContentSk(), $question->getQuestionType(),
                    $start_timestamp, $end_timestamp, $code);
                $new_period_id = $this->period_repository->createNewPeriod($new_period);
                if($new_period_id > -1){
                    // Creating static options
                    $option_data = $this->static_option_service->createStaticOption($new_period_id, $question->getId());
                    if($option_data['status'] == 500){
                        $this->period_repository->rollbackTransaction();
                        return [
                            'error' => "Failed creating static option",
                            'status' => 500
                        ];
                    }
                    $this->period_repository->commitTransaction();
                    return [
                        'message' => 'Period created successfully',
                        'status' => 201,
                        'data' => $code
                    ];
                }else{
                    $this->period_repository->rollbackTransaction();
                    return [
                        'error' => 'Failed to create new period',
                        'status' => 500,
                    ];
                }
            }else {
                return [
                    'error' => 'End timestamp must be after start timestamp',
                    'status' => 400,
                ];
            }
        }

        return [
            'error' => 'Unauthorized access',
            'status' => 403
        ];
    }

    // Update period
    public function updatePeriod()
    {

    }


    // Get all periods by question
    public function getAllPeriodByQuestionId(int $question_id)
    {
        $this->checkSession();

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        $question = $this->question_repository->getQuestionById($question_id);
        if (!$question) {
            return [
                'error' => "Question not found",
                'status' => 404,
            ];
        }

        if ($user_role == UserRole::Admin || ($user_role == UserRole::User && $user->getId() == $question->getUserId())) {
            $periods = $this->period_repository->getPeriodsByQuestionId($question_id);
            return [
                'message' => 'Successfully retrieved periods',
                'status' => 200,
                'data' => $periods
            ];
        }

        return [
            'error' => 'Unauthorized access',
            'status' => 403
        ];
    }

    public function getOpenPeriodByQuestionId(int $question_id)
    {
        $this->checkSession();

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        $question = $this->question_repository->getQuestionById($question_id);
        if (!$question) {
            return [
                'error' => "Question not found",
                'status' => 404,
            ];
        }

        if ($user_role == UserRole::Admin || ($user_role == UserRole::User && $user->getId() == $question->getUserId())) {
            $periods = $this->period_repository->getOpenPeriodsByQuestionId($question_id);
            return [
                'message' => 'Successfully retrieved periods',
                'status' => 200,
                'data' => $periods
            ];
        }

        return [
            'error' => 'Unauthorized access',
            'status' => 403
        ];
    }

    // Get period by id (specific period)
    public function getPeriodById(int $period_id)
    {
        $this->checkSession();

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        $period = $this->period_repository->getPeriodById($period_id);
        if (!$period) {
            return [
                'error' => "Period not found",
                'status' => 404
            ];
        }

        $question = $this->question_repository->getQuestionById($period->getQuestionId());
        if (!$question) {
            return [
                'error' => "Question not found",
                'status' => 404,
            ];
        }

        if ($user_role === UserRole::Admin || ($user_role === UserRole::User && $user->getId() == $question->getUserId())) {
            return [
                'message' => "Successfully retrieved period",
                'status' => 200,
                'data' => $period
            ];
        }

        return [
            'error' => 'Unauthorized access',
            'status' => 403
        ];
    }

    // Get period by code (specific period)
    public function getPeriodByCode(string $code)
    {
        $period = $this->period_repository->getPeriodByCode($code);
        if (!$period) {
            return [
                'error' => "Period not found",
                'status' => 404
            ];
        }

        return [
            'message' => "Successfully retrieved period",
            'status' => 200,
            'data' => $period
        ];
    }

    // Delete period by id
    public function deletePeriodById(int $period_id)
    {
        $this->checkSession();

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        $period = $this->period_repository->getPeriodById($period_id);
        if (!$period) {
            return [
                'error' => "Period not found",
                'status' => 404
            ];
        }

        $question = $this->question_repository->getQuestionById($period->getQuestionId());
        if (!$question) {
            return [
                'error' => "Question not found",
                'status' => 404,
            ];
        }

        if ($user_role === UserRole::Admin || ($user_role === UserRole::User && $user->getId() == $question->getUserId())) {
            $deleted = $this->period_repository->deletePeriodById($period_id);
            if ($deleted) {
                return [
                    'message' => 'Period deleted successfully',
                    'status' => 200
                ];
            } else {
                return [
                    'error' => "Failed to delete period",
                    'status' => 500
                ];
            }
        }

        return [
            'error' => 'Unauthorized access',
            'status' => 403
        ];
    }

    public function closeByQuestionId($questionId)
    {
        $result = $this->getOpenPeriodByQuestionId($questionId);
        if($result['status'] != 200){
            return $result;
        }
        /**
         * @var $periods Array<Period>
         */
        $periods = $result['data'];
        $this->period_repository->startTransaction();
        foreach ($periods as $period){
            $period->setEndTimestamp(new DateTime());
            if (!$this->period_repository->updatePeriod($period)){
                $this->period_repository->rollbackTransaction();
                return [
                    'error' => 'Period update fail',
                    'status' => 500
                ];
            }
        }
        $this->period_repository->commitTransaction();

        return [
            'message' => 'Closed all open periods for question successfully',
            'status' => 200
        ];
    }

    // Helper functions
    private function checkSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function generateCode(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do {
            $code = '';
            $max = strlen($characters) - 1;
            for ($i = 0; $i < 6; $i++) {
                $code .= $characters[rand(0, $max)];
            }
            $count = $this->period_repository->checkIfPeriodWithGivenCodeExists($code);
        }while($count > 0);

        return $code;
    }
}

?>
