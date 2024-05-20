<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Models\Option;
use Models\User;
use Models\UserRole;
use Models\Question;
use DateTime;
use Models\QuestionType;
use Repositories\PeriodRepository;
use UnhandledMatchError;
use Repositories\QuestionRepository;
use Repositories\OptionRepository;
use Repositories\UserRepository;

class QuestionService
{
    private QuestionRepository $question_repository;
    private OptionRepository $option_repository;
    private UserRepository $user_repository;
    private PeriodService $periodService;

    public function __construct()
    {
        $this->question_repository = new QuestionRepository();
        $this->option_repository = new OptionRepository();
        $this->user_repository = new UserRepository();
        $this->periodService = new PeriodService();
    }

    /* Create new question */
    public function createNewQuestionForGivenUserId(?int $userId, array $data)
    {
        if(session_status() === PHP_SESSION_NONE){
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

        /**
         * @var Array $option_data;
         */
        if (!isset($data['options'])|| empty($data['question'])){
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }
        $option_data = $data['options'];
        $question_data = $data['question'];
        if (empty($question_data['title_en']) || empty($question_data['title_sk']) || empty($question_data['content_en'])
            || empty($question_data['content_sk']) || empty($question_data['type'])) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }

        try {
            $creation_date = new DateTime();
            $type = QuestionType::from($question_data['type']);
        } catch (UnhandledMatchError $e) {
            return [
                'error' => "Invalid date format or question type or isOpen state",
                'status' => 400,
            ];
        }

        $options = null;
        if ($type == QuestionType::Single_choice || $type == QuestionType::Multi_choice) {
            if (empty($option_data)) {
                return [
                    'error' => 'Missing required fields',
                    'status' => 400
                ];
            }
            $options = [];
            foreach ($option_data as $option) {
                try {
                    if ($option['is_correct'] != "true" && $option['is_correct'] != "false"){
                        return [
                            'error' => 'Bad is_correct format',
                            'status' => 400
                        ];
                    }
                    $options[] = new Option(0, $option['value_en'], $option['value_sk'], $option['is_correct']);
                } catch (\Exception $e) {
                    return [
                        'error' => 'Missing required fields',
                        'status' => 400
                    ];
                }
            }
        }

        $new_question_id = null;

        $this->question_repository->startTransaction();
        // admin creates question for himself
        if ($user_role === UserRole::Admin && $userId === null) {
            $new_question = new Question($user->getId(), $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        } elseif ($user_role === UserRole::Admin && $userId != null) { // Admin creates for specific user
            $specific_user = $this->user_repository->getUserById($userId);
            $new_question = new Question($specific_user->getId(), $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        } elseif ($user_role === UserRole::User && $userId === null) { // User creates question for himself
            $new_question = new Question($user->getId(), $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        }

        if ($new_question_id === null) {
            $this->question_repository->rollbackTransaction();
            return [
                'error' => 'Problem creating new question',
                'status' => 500
            ];
        }
        if ($options != null){
            foreach ($options as $option){
                $option->setQuestionId($new_question_id);
                if ($this->option_repository->createNewOption($option) == -1){
                    $this->question_repository->rollbackTransaction();
                    return [
                        'error' => 'Problem creating new question',
                        'status' => 500
                    ];
                }
            }
        }
        $this->question_repository->commitTransaction();
        return [
            'message' => 'Question created successfully',
            'status' => 201,
            'question_id' => $new_question_id
        ];
    }

    public function getAllQuestionsForGivenUserById(int $userId, User $requester)
    {
        $user = $this->user_repository->getUserById($userId);
        if (
            $requester->getUserRole() != UserRole::Admin
            && $requester->getId() != $user->getId()
        ) {
            return [
                'error' => "Not authorized",
                'status' => 403,
            ];
        }

        if ($user == null){
            return [
                'error' => "User does not exist",
                'status' => 404,
            ];
        }

        $questionArray = $this->question_repository->getQuestionsByUserId($user->getId());

        if ($questionArray === null) {
            return [
                'message' => "Failed to get questions",
                'status' => 500,
                'data' => $questionArray,
            ];
        } else {
            return [
                'message' => "Retrieved all question records successfully",
                'status' => 200,
                'data' => $questionArray,
            ];
        }
    }

    /**
     * Get specific question only
     * @param int $question_id
     * @param int $user_id
     * @param string $user_role
     * @return array<string, int>|array<string, int, Question>
     */
    public function getSpecificQuestion(int $question_id)
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            return [
                'error' => "Unauthorized access - no session found",
                'status' => 403
            ];
        }

        $question = $this->question_repository->getQuestionById($question_id);

        if ($question === null) {
            return [
                'error' => "Question does not exist",
                'status' => 404,
            ];
        }

        $user = $_SESSION['user'];
        $user_role = $user->getUserRole();

        if ($user_role === UserRole::Admin) {
            return [
                'message' => "Successfully retrieved question.",
                'status' => 200,
                'data' => $question,
            ];
        }

        if ($user_role === UserRole::User && $question->getUserId() === $user->getId()) {
            return [
                'message' => "Successfully retrieved question.",
                'status' => 200,
                'data' => $question,
            ];
        }

        return [
            'error' => "Not authorized",
            'status' => 403,
        ];
    }

    /* Get specific question and its options */
    public function getSpecificQuestionWithOptions(int $question_id)
    {
        $question = $this->getSpecificQuestion($question_id);
        if ($question['status'] != 200 ) {
            return $question;
        }

        $question = $question['data'];

        $options_array = $this->option_repository->getOptionsByQuestionId($question->getId());

        if($options_array === null) {
            return [
                'error' => "Failed to get options",
                'status' => 500,
            ];
        }
        else{
            return [
                'message' => "Successfully retrieved question and its options",
                'status' => 200,
                'data' => [
                    'question' => $question,
                    'options' => $options_array
                ]
            ];
        }
    }

    /* Delete specific question */
    public function deleteSpecificQuestion(int $question_id)
    {
        $question = $this->getSpecificQuestion($question_id);
        if ($question['status'] != 200 ) {
            return $question;
        }

        $question = $question['data'];

        $deleted = $this->question_repository->deleteQuestionById($question->getId());
        if ($deleted) {
            return [
                'message' => "Successfully deleted question",
                'status' => 204,
            ];
        } else {
            return [
                'error' => "Failed to delete question",
                'status' => 500,
            ];
        }
    }

    /* Update question */
    public function updateSpecificQuestion(int $question_id, array $question_data)
    {
        $question = $this->getSpecificQuestion($question_id);
        if ($question['status'] != 200 ) {
            return $question;
        }

        $question = $question['data'];

        if (empty($question_data['title_en']) || empty($question_data['title_sk']) || empty($question_data['content_en'])
            || empty($question_data['content_sk']) || empty($question_data['creation_date']) || empty($question_data['type'])
            || empty($question_data['is_open'])) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }

        $question->setTitleEn($question_data['title_en']);
        $question->setTitleSk($question_data['title_sk']);
        $question->setContentEn($question_data['content_en']);
        $question->setContentSk($question_data['content_sk']);
        $question->setCreationDate(new DateTime($question_data['creation_date']));
        $question->setQuestionType(QuestionType::from($question_data['type']));

        $update_result = $this->question_repository->updateQuestion($question);
        if($update_result){
            return [
                'message' => 'Question updated successfully',
                'status' => 200
            ];
        }else{
            return [
                'error' => "Failed to updated question",
                'status' => 500
            ];
        }
    }

    public function open($questionId, \DateTime $endTimestamp)
    {
        $result = $this->getSpecificQuestion($questionId);
        if ($result['status'] != 200){
            return $result;
        }

        $question = $result['data'];
        if ($question->isIsOpen()){
            return [
                'error' => 'Question is open',
                'status' => 400
            ];
        }

        // all errors have been resolved by this point
        $result = $this->periodService->getAllPeriodByQuestionId($question->getId());
        if ($result['status'] != 200){
            return $result;
        }

        return $this->periodService->createNewPeriod($question, $endTimestamp);
    }

    public function close($questionId)
    {
        $result = $this->getSpecificQuestion($questionId);
        if ($result['status'] != 200){
            return $result;
        }

        $question = $result['data'];
        if (!$question->isIsOpen()){
            return [
                'error' => 'Question is closed',
                'status' => 400
            ];
        }

        return $this->periodService->closeByQuestionId($question->getId());
    }
}

?>