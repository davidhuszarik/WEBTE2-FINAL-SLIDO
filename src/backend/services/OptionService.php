<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Repositories\OptionRepository;
use Repositories\QuestionRepository;
use Models\Option;
use Models\UserRole;

class OptionService{
    private OptionRepository $option_repository;
    private QuestionRepository $question_repository;

    public function __construct()
    {
        $this->option_repository = new OptionRepository();
        $this->question_repository = new QuestionRepository();
    }

    public function getOptionsByGivenQuestion(int $question_id)
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
        $userRole = $user->getUserRole();
        $question = $this->question_repository->getQuestionById($question_id);

        if (!$question) {
            return [
                'error' => "Question not found",
                'status' => 404
            ];
        }

        if ($userRole == UserRole::Admin || ($userRole == UserRole::User && $question->getUserId() == $user->getId())) {
            $options = $this->option_repository->getOptionsByQuestionId($question_id);
            return [
                'message' => 'Successfully retrieved options for question',
                'status' => 200,
                'data' => $options,
            ];
        }

        return [
            'error' => "Unauthorized access",
            'status' => 403
        ];
    }

    public function getSpecificOption(int $option_id)
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

        $option = $this->option_repository->getOptionById($option_id);
        if($option == null){
            return [
                'error' => 'Option does not exit',
                'status' => 404,
            ];
        }

        $question = $this->question_repository->getQuestionById($option->getQuestionId());
        if($question == null){
            return [
                'error' => 'Question does not exist',
                'status' => 404,
            ];
        }

        if ($user_role == UserRole::Admin || ($user_role == UserRole::User && $question->getUserId() == $user->getId())) {
            return [
                'message' => 'Successfully retrieved options for question',
                'status' => 200,
                'data' => $option,
            ];
        }

        return [
            'error' => "Unauthorized access",
            'status' => 403
        ];
    }


    public function updateOption(int $option_id, array $option_data)
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

        $option = $this->option_repository->getOptionById($option_id);
        if($option == null){
            return [
                'error' => 'Option does not exit',
                'status' => 404,
            ];
        }

        $question = $this->question_repository->getQuestionById($option->getQuestionId());
        if($question == null){
            return [
                'error' => 'Question does not exist',
                'status' => 404,
            ];
        }

        if (empty($option_data['value_en']) || empty($option_data['value_sk']) || empty($option_data['is_correct'])) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }


        if($user_role == UserRole::Admin || ($user_role == UserRole::User && $user->getId() == $question->getUserId())){
            $option->setValueEn($option_data['value_en']);
            $option->setValueSk($option_data['value_sk']);
            $option->setIsCorrect((bool)$option_data['is_correct']);

            $update_success = $this->option_repository->updateOption($option);
            if($update_success){
                return [
                    'message' => 'Successfully updated option',
                    'status' => 200
                ];
            }else{
                return [
                    'error' => 'Failed to update option',
                    'status' => 500
                ];
            }
        }

        return [
            'error' => "Unauthorized access - no session found",
            'status' => 403
        ];
    }

    public function createOption(int $question_id, array $option_data)
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

        $question = $this->question_repository->getQuestionById($question_id);
        if($question == null){
            return [
                'error' => 'Question does not exist',
                'status' => 404,
            ];
        }

        if (empty($option_data['value_en']) || empty($option_data['value_sk']) || empty($option_data['is_correct'])) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }

        if($user_role == UserRole::Admin || ($user_role == UserRole::User && $user->getId() == $question->getUserId())){
            $new_option = new Option($question_id, $option_data['value_en'], $option_data['value_sk'], (bool)$option_data['is_correct']);
            $inserted_id = $this->option_repository->createNewOption($new_option);
            if($inserted_id > -1){
                return [
                    'message' => 'Option created successful',
                    'status' => 200,
                    'data' => $inserted_id,
                ];
            }else{
                return [
                    'error' => 'Failed to create new option',
                    'status' => 500,
                ];
            }
        }

        return [
            'error' => "Unauthorized access - no session found",
            'status' => 403
        ];
    }

    public function deleteOption(int $option_id)
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

        $option = $this->option_repository->getOptionById($option_id);
        if($option == null){
            return [
                'error' => 'Option does not exit',
                'status' => 404,
            ];
        }

        $question = $this->question_repository->getQuestionById($option->getQuestionId());
        if($question == null){
            return [
                'error' => 'Question does not exist',
                'status' => 404,
            ];
        }

        if($user_role == UserRole::Admin || ($user_role == UserRole::User && $user->getId() == $question->getUserId())){
            $deleted = $this->option_repository->deleteOptionById($option_id);
            if($deleted){
                return [
                    'message' => "Successfully deleted option",
                    'status' => 200,
                ];
            }else{
                return [
                    'error' => "Failed to delete option",
                    'status' => 500,
                ];
            }
        }

        return [
            'error' => "Unauthorized access - no session found",
            'status' => 403
        ];
    }
}

?>
