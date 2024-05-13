<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Models\User;
use Models\UserRole;
use Models\Question;
use DateTime;
use Models\QuestionType;
use UnhandledMatchError;
use Repositories\QuestionRepository;
use Repositories\OptionRepository;
use Repositories\UserRepository;

class QuestionService
{
    private QuestionRepository $question_repository;
    private OptionRepository $option_repository;
    private UserRepository $user_repository;

    public function __construct()
    {
        $this->question_repository = new QuestionRepository();
        $this->option_repository = new OptionRepository();
        $this->user_repository = new UserRepository();
    }

    /* Create new question */
    public function createNewQuestionForGivenUser(int $user_id, string $user_role, ?string $username, array $question_data)
    {
        if (empty($question_data['title_en']) || empty($question_data['title_sk']) || empty($question_data['content_en'])
            || empty($question_data['content_sk']) || empty($question_data['creation_date']) || empty($question_data['type'])
            || empty($question_data['is_open'])) {
            return [
                'error' => 'Missing required fields',
                'status' => 400
            ];
        }

        try {
            $creation_date = new DateTime($question_data['creation_date']);
            $type = QuestionType::from($question_data['type']);
            $isOpen = (bool) $question_data['is_open'];
        } catch (UnhandledMatchError $e) {
            return [
                'error' => "Invalid date format or question type or isOpen state",
                'status' => 400,
            ];
        }

        $new_question_id = null;

        // admin creates question for himself
        if ($user_role === 'admin' && $username === null) {
            $new_question = new Question($user_id, $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type, $isOpen);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        } elseif ($user_role === 'admin' && $username != null) { // Admin creates for specific user
            $specific_user = $this->user_repository->getByUsername($username);
            $new_question = new Question($specific_user->getId(), $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type, $isOpen);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        } elseif ($user_role === 'user' && $username === null) { // User creates question for himself
            $new_question = new Question($user_id, $question_data['title_en'], $question_data['title_sk'], $question_data['content_en'],
                $question_data['content_sk'], $creation_date, $type, $isOpen);
            $new_question_id = $this->question_repository->createNewQuestion($new_question);
        }

        if ($new_question_id === null) {
            return [
                'error' => 'Problem creating new question',
                'status' => 500
            ];
        } else {
            return [
                'message' => 'Question created successfully',
                'status' => 201,
                'question_id' => $new_question_id
            ];
        }
    }

    public function getAllQuestionsForGivenUser(User $user, User $requester)
    {
        if (
            $requester->getUserRole() != UserRole::Admin
            && $requester->getId() != $user->getId()
        ) {
            return [
                'error' => "Not authorized",
                'status' => 403,
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
    public function getSpecificQuestion(int $question_id, int $user_id, string $user_role)
    {
        $question = $this->question_repository->getQuestionById($question_id);

        if ($question === null) {
            return [
                'error' => "Question does not exist",
                'status' => 404,
            ];
        }

        if ($user_role === 'admin') {
            return [
                'message' => "Successfully retrieved question.",
                'status' => 200,
                'data' => $question,
            ];
        }

        if ($user_role === "user" && $question->getUserId() === $user_id) {
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
    public function getSpecificQuestionWithOptions(int $question_id, int $user_id, string $user_role)
    {
        $question = $this->getSpecificQuestion($question_id, $user_id, $user_role);
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
    public function deleteSpecificQuestion(int $question_id, int $user_id, string $user_role)
    {
        $question = $this->getSpecificQuestion($question_id, $user_id, $user_role);
        if ($question['status'] != 200 ) {
            return $question;
        }

        $question = $question['data'];

        $deleted = $this->question_repository->deleteQuestionById($question->getId());
        if ($deleted) {
            return [
                'message' => "Successfully deleted question",
                'status' => 200,
            ];
        } else {
            return [
                'error' => "Failed to delete question",
                'status' => 500,
            ];
        }
    }

    /* Update question */
    public function updateSpecificQuestion(int $user_id, string $user_role, int $question_id, array $question_data)
    {
        $question = $this->getSpecificQuestion($question_id, $user_id, $user_role);
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
        $question->setIsOpen((bool)$question_data['is_open']);

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
}

?>